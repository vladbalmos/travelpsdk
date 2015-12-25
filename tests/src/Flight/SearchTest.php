<?php

namespace TravelPSDK\Tests\Flight;
use \TravelPSDK\Flight\Search,
    \TravelPSDK\Flight\SearchResponse,
    \TravelPSDK\Flight\SearchParameters,
    \TravelPSDK\Flight\TripClass,
    \TravelPSDK\Flight\SearchResults
    ;

class SearchTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider searchParamsProvider
     */
    public function test_FlightSearch_Returns_Response($searchParametersArray)
    {
        $searchParameters = new SearchParameters($searchParametersArray);
        $flightsSearch = new Search($searchParameters);

        $response = $flightsSearch->run();
        $this->assertInstanceOf('\\TravelPSDK\\Flight\\SearchResponse', $response);

        $searchID = $response->getSearchID();
        $this->assertNotEmpty($searchID);

        $locale = $response->getLocale();
        $this->assertNotEmpty($locale);

        $tripClass = $response->getTripClass();
        $this->assertNotEmpty($tripClass);
        $this->assertEquals($searchParameters['trip_class'],  $tripClass);

        $gatesCount = $response->getGatesCount();
        $this->assertTrue(is_numeric($gatesCount));

        $segments = $response->getSegments();
        $this->assertInternalType('array', $segments);
        $this->assertEquals(count($searchParameters['segments']), count($segments));

        $passengers = $response->getPassengers();
        $this->assertInternalType('array', $passengers);
        $this->assertEquals($searchParameters['passengers'], (array) $passengers);

        $currency = $response->getCurrencyRates();
        $this->assertInternalType('array', $currency);
        $this->assertNotEmpty($currency);
    }

    /**
     * @dataProvider searchParamsProvider
     */
    public function test_FlightSearch_Returns_Results($searchParametersArray)
    {
        $searchParameters = new SearchParameters($searchParametersArray);
        $flightsSearch = new Search($searchParameters);

        $response = $flightsSearch->run();
        $searchID = $response->getSearchID();
        $searchResults = new SearchResults($searchID);

        foreach ($searchResults as $data) {
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


