<?php

namespace App\Services;

use Analytics;
use Spatie\Analytics\Period;
use Carbon\Carbon;

class GoogleAnalyticsService
{
    /**
     * @return array
     */
    public function getAnalyticData(): array
    {
        $analyticsData = Analytics::performQuery(Period::create(Carbon::now()->startOfMonth(), Carbon::now()), 'ga:users', [
            'metrics' => 'ga:users, ga:sessions, ga:hits',
            'dimensions' => 'ga:date'
        ]);

        $datesQuery = [];
        $usersQuery = [];
        $sessionQuery = [];
        $hitsQuery = [];

        foreach ($analyticsData['rows'] as $value) {
            array_push($datesQuery, Carbon::createFromDate(substr($value[0], 0, 4), substr($value[0], 4, 2), substr($value[0], 6, 2))->toFormattedDateString());
            array_push($usersQuery, $value[1]);
            array_push($sessionQuery, $value[2]);
            array_push($hitsQuery, $value[3]);
        }

        return [$datesQuery, $usersQuery, $sessionQuery, $hitsQuery];
    }

    public function getAnalyticCountryData(): array
    {
        $countryData = Analytics::performQuery(Period::create(Carbon::now()->startOfMonth(), Carbon::now()), 'ga:users', [
            'metrics' => 'ga:users',
            'dimensions' => 'ga:country',
            'sort' => '-ga:users',
            'max-results' => 10
        ]);

        $countryQueryLabels = [];
        $countryQueryData = [];

        if ($countryData['totalResults'] > 0) {
            foreach ($countryData['rows'] as $value) {
                array_push($countryQueryLabels, $value[0]);
                array_push($countryQueryData, $value[1]);
            }
        }

        return [$countryQueryLabels, $countryQueryData];
    }

    public function getCityByCountry(string $country): array
    {
        $cityRussiaData = Analytics::performQuery(Period::create(Carbon::now()->startOfMonth(), Carbon::now()), 'ga:users', [
            'metrics' => 'ga:users',
            'dimensions' => 'ga:city',
            'sort' => '-ga:users',
            'segment' => 'users::condition::ga:country=='.$country,
            'max-results' => 10
        ]);

        $cityQueryLabels = [];
        $cityQueryData = [];

        if ($cityRussiaData['totalResults'] > 0) {
            foreach ($cityRussiaData['rows'] as $value) {
                array_push($cityQueryLabels, $value[0]);
                array_push($cityQueryData, $value[1]);
            }
        }

        return [$cityQueryLabels, $cityQueryData];
    }
}