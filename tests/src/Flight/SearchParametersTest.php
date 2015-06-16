<?php

namespace TravelPSDK\Tests\Flight;

use \TravelPSDK\Flight\SearchParameters,
    \TravelPSDK\Flight\TripClass
    ;

class SearchParametersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider rawSearchParametersProvider
     */
    public function test_SearchParameters_Makes_Correct_Signature($rawParameters)
    {
        $searchParameters = new SearchParameters();

        extract($rawParameters);

        $searchParameters->setAffiliateMarker($affiliateMarker)
                         ->setApiToken($apiToken)
                         ->setHost($host)
                         ->setIp($ip)
                         ->setLocale($locale)
                         ->setTripClass($tripClass)
                         ->setPassengers($passengers)
                         ->setSegments($segments);

        $actualSignature = $searchParameters->getSignature();

        $this->assertEquals($actualSignature, $expectedSignature);
    }

    /**
     * @dataProvider rawSearchParametersProvider
     */
    public function test_SearchParameters_Prepares_Data_For_Search_API($rawParameters)
    {
        $searchParameters = new SearchParameters($rawParameters);

        $expectedKeys = ['signature', 'marker', 'host', 'user_ip', 'locale', 'trip_class', 
                         'passengers', 'adults', 'children', 'infants', 'segments', 'origin',
                         'destination', 'date'];

        $actualSearchParameters = $searchParameters->getApiParams();

        $assert = function ($data) use ($expectedKeys, &$assert) {
            foreach ($data as $key => $value) {
                if (is_array($data[$key])) {
                    $assert($data[$key]);
                    continue;
                }

                $this->assertContains($key, $expectedKeys, "Asserting that $key is valid");
            }
        };

        $assert($actualSearchParameters);
    }


    public function rawSearchParametersProvider()
    {
        return [
            [
                [
                    'apiToken' => 'my-token',
                    'host' => 'myhost.com',
                    'locale' => 'en',
                    'affiliateMarker' => 'my-marker',
                    'passengers' => [
                        'adults' => 1,
                        'children' => 0,
                        'infants' => 0
                    ],
                    'segments' => [
                        [
                            'date' => '2015-06-06',
                            'destination' => 'BUC',
                            'origin' => 'IAS',
                        ]
                    ],
                    'tripClass' => TripClass::ECONOMY,
                    'ip' => '127.0.0.1',
                    // my-token:myhost.com:en:my-marker:1:0:0:2015-06-06:BUC:IAS:Y:127.0.0.1
                    'expectedSignature' => 'd68c1587015117070a797df608a0ef49'
                ]
            ],
            [
                [
                    'apiToken' => 'my-token',
                    'host' => 'myhost.com',
                    'locale' => 'en',
                    'affiliateMarker' => 'my-marker',
                    'passengers' => [
                        'adults' => 1,
                        'children' => 0,
                        'infants' => 0
                    ],
                    'segments' => [
                        [
                            'date' => '2015-06-06',
                            'destination' => 'BUC',
                            'origin' => 'IAS',
                        ],
                        [
                            'date' => '2015-06-06',
                            'destination' => 'IAS',
                            'origin' => 'BUC',
                        ],
                    ],
                    'tripClass' => TripClass::BUSINESS,
                    'ip' => '127.0.0.1',
                    //my-token:myhost.com:en:my-marker:1:0:0:2015-06-06:BUC:IAS:2015-06-06:IAS:BUC:C:127.0.0.1
                    'expectedSignature' => '3c6ff3a62e84695608fbf34d26a633c0'
                ]
            ],
            [
                [
                    'apiToken' => 'my-token',
                    'host' => 'myhost.com',
                    'locale' => 'ro',
                    'affiliateMarker' => 'my-marker',
                    'passengers' => [
                        'adults' => 1,
                        'children' => 0,
                        'infants' => 0
                    ],
                    'segments' => [
                        [
                            'date' => '2015-06-06',
                            'destination' => 'BUC',
                            'origin' => 'IAS',
                        ]
                    ],
                    'tripClass' => TripClass::BUSINESS,
                    'ip' => '127.0.0.1',
                    //my-token:myhost.com:ro:my-marker:1:0:0:2015-06-06:BUC:IAS:C:127.0.0.1
                    'expectedSignature' => '4e5415a02ab1c286405ba99ba575a243'
                ]
            ],
        ];
        
    }
}
