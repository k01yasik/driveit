<?php

namespace App\Services;

use Analytics;
use Spatie\Analytics\Period;
use Carbon\Carbon;
use Exception;
use Spatie\Analytics\Exceptions\InvalidConfiguration;

class GoogleAnalyticsService
{
    /**
     * Get analytics data for the current month
     * 
     * @return array
     * @throws InvalidConfiguration|Exception
     */
    public function getAnalyticData(): array
    {
        try {
            $analyticsData = Analytics::performQuery(
                Period::create(Carbon::now()->startOfMonth(), Carbon::now()), 
                'ga:users', 
                [
                    'metrics' => 'ga:users, ga:sessions, ga:hits',
                    'dimensions' => 'ga:date'
                ]
            );

            $datesQuery = [];
            $usersQuery = [];
            $sessionQuery = [];
            $hitsQuery = [];

            if (isset($analyticsData['rows'])) {
                foreach ($analyticsData['rows'] as $value) {
                    array_push($datesQuery, Carbon::createFromDate(
                        substr($value[0], 0, 4), 
                        substr($value[0], 4, 2), 
                        substr($value[0], 6, 2)
                    )->toFormattedDateString());
                    array_push($usersQuery, $value[1]);
                    array_push($sessionQuery, $value[2]);
                    array_push($hitsQuery, $value[3]);
                }
            }

            return [$datesQuery, $usersQuery, $sessionQuery, $hitsQuery];
        } catch (Exception $e) {
            throw new Exception("Failed to fetch analytics data: " . $e->getMessage());
        }
    }

    /**
     * Get country analytics data
     * 
     * @return array
     * @throws InvalidConfiguration|Exception
     */
    public function getAnalyticCountryData(): array
    {
        try {
            $countryData = Analytics::performQuery(
                Period::create(Carbon::now()->startOfMonth(), Carbon::now()), 
                'ga:users', 
                [
                    'metrics' => 'ga:users',
                    'dimensions' => 'ga:country',
                    'sort' => '-ga:users',
                    'max-results' => 10
                ]
            );

            $countryQueryLabels = [];
            $countryQueryData = [];

            if (isset($countryData['rows'])) {
                foreach ($countryData['rows'] as $value) {
                    array_push($countryQueryLabels, $value[0]);
                    array_push($countryQueryData, $value[1]);
                }
            }

            return [$countryQueryLabels, $countryQueryData];
        } catch (Exception $e) {
            throw new Exception("Failed to fetch country analytics data: " . $e->getMessage());
        }
    }

    /**
     * Get city data for a specific country
     * 
     * @param string $country
     * @return array
     * @throws InvalidConfiguration|Exception
     */
    public function getCityByCountry(string $country): array
    {
        try {
            $cityData = Analytics::performQuery(
                Period::create(Carbon::now()->startOfMonth(), Carbon::now()), 
                'ga:users', 
                [
                    'metrics' => 'ga:users',
                    'dimensions' => 'ga:city',
                    'sort' => '-ga:users',
                    'segment' => 'users::condition::ga:country=='.$country,
                    'max-results' => 10
                ]
            );

            $cityQueryLabels = [];
            $cityQueryData = [];

            if (isset($cityData['rows'])) {
                foreach ($cityData['rows'] as $value) {
                    array_push($cityQueryLabels, $value[0]);
                    array_push($cityQueryData, $value[1]);
                }
            }

            return [$cityQueryLabels, $cityQueryData];
        } catch (Exception $e) {
            throw new Exception("Failed to fetch city data for country {$country}: " . $e->getMessage());
        }
    }
}
