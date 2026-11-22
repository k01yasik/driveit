<?php

namespace App\Services;

use Google\Analytics\Data\V1beta\Filter;
use Google\Analytics\Data\V1beta\Filter\StringFilter;
use Google\Analytics\Data\V1beta\Filter\StringFilter\MatchType;
use Google\Analytics\Data\V1beta\FilterExpression;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Period;

class GoogleAnalyticsService
{
    public function getAnalyticData(): array
    {
        $rows = Analytics::get(
            period: $this->currentMonth(),
            metrics: ['activeUsers', 'sessions', 'eventCount'],
            dimensions: ['date'],
            maxResults: 31,
            orderBy: [OrderBy::dimension('date', false)],
        );

        return [
            $rows->pluck('date')->map(fn ($date) => $date->toFormattedDateString())->all(),
            $rows->pluck('activeUsers')->all(),
            $rows->pluck('sessions')->all(),
            $rows->pluck('eventCount')->all(),
        ];
    }

    public function getAnalyticCountryData(): array
    {
        $rows = Analytics::fetchTopCountries($this->currentMonth());

        return [$rows->pluck('country')->all(), $rows->pluck('activeUsers')->all()];
    }

    public function getCityByCountry(string $country): array
    {
        $filter = new FilterExpression([
            'filter' => new Filter([
                'field_name' => 'country',
                'string_filter' => new StringFilter([
                    'match_type' => MatchType::EXACT,
                    'value' => $country,
                ]),
            ]),
        ]);

        $rows = Analytics::get(
            period: $this->currentMonth(),
            metrics: ['activeUsers'],
            dimensions: ['city'],
            orderBy: [OrderBy::metric('activeUsers', true)],
            dimensionFilter: $filter,
        );

        return [$rows->pluck('city')->all(), $rows->pluck('activeUsers')->all()];
    }

    private function currentMonth(): Period
    {
        return Period::create(now()->startOfMonth(), now());
    }
}
