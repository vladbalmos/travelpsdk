<?php

namespace TravelPSDK\Tests\Flights;
use \TravelPSDK\Flights\Search,
    \TravelPSDK\Flights\SearchParameters,
    \TravelPSDK\Flights\TripClass,
    \TravelPSDK\Flights\SearchResults
    ;

class SearchTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider searchParamsProvider
     */
    public function test_FlightsSearch_Returns_a_Search_ID($searchParametersArray)
    {
        $searchParameters = new SearchParameters($searchParametersArray);
        $flightsSearch = new Search($searchParameters);

        $searchID = $flightsSearch->run();
        $this->assertNotEmpty($searchID);
        $this->continue_test_FlightsSerch_Returns_Results($searchID);
    }

    /**
     */
    public function continue_test_FlightsSerch_Returns_Results($searchID)
    {
        $searchResults = new SearchResults($searchID);

        foreach ($searchResults->get() as $data) {
            $this->assertInstanceOf('\TravelPSDK\Common\Collection', $data);
        }
    }

    /**
     * @return array
     */
    public function searchParamsProvider()
    {
        $date = new \DateTime('+3 days');
        $date = $date->format('Y-m-d');
        return [
            [
                [
                    'apiToken' => getenv('TP_API_TOKEN'),
                    'host' => 'zazat.net',
                    'locale' => 'en',
                    'affiliateMarker' => getenv('TP_AFFILIATE_MARKER'),
                    'passengers' => [
                        'adults' => 1,
                        'children' => 0,
                        'infants' => 0
                    ],
                    'segments' => [
                        [
                            'date' => $date,
                            'destination' => 'LON',
                            'origin' => 'IAS',
                        ]
                    ],
                    'tripClass' => TripClass::BUSINESS,
                    'ip' => '127.0.0.1'
                ]
            ]
        ];
    }
}


