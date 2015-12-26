<?php

namespace TravelPSDK\Tests\Flight;

use \TravelPSDK\Flight\BookingUrl,
    \GuzzleHttp\Client,
    \GuzzleHttp\Subscriber\Mock,
    \GuzzleHttp\Message\Response,
    \GuzzleHttp\Stream\Stream
    ;

class BookingUrlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Exception
     */
    public function test_BookingUrl_Throws_Exception_While_Executing_Request()
    {
        $httpClient = $this->givenHttpClientWillReturn404NotFound();

        $searchID = 'searchID'; $ticketTermID = '10231';
        $bookingUrl = new BookingUrl($searchID, $ticketTermID);
        $bookingUrl->setHttpClient($httpClient);

        $url = $bookingUrl->__toString();
    }

    public function test_BookingUrl_Returns_A_Correct_Url()
    {
        $expectedData = [
            'params' => new \stdClass,
            'method' => 'GET',
            'url' => 'https://www.svyaznoy.travel/?utm_source=aviasales.ru&utm_medium=cpa&utm_campaign=meta_avia#MOW0906/BKK1506/A1/C0/I0/S0/22316/EK-132;EK-374/EK-373;EK-131&marker=7uh46i0v2',
            'gate_id' => 62,
            'click_id' => '22135952358110'
        ];
        $httpClient = $this->givenHttpClientWillReturnResponse(json_encode($expectedData));

        $searchID = 'searchID'; $ticketTermID = '10231';
        $bookingUrl = new BookingUrl($searchID, $ticketTermID);
        $bookingUrl->setHttpClient($httpClient);

        $url = $bookingUrl->__toString();
        $this->assertEquals($expectedData['url'], $url);
    }

    private function givenHttpClientWillReturn404NotFound()
    {
        $response = new Response(404);
        $mock = new Mock([$response]);
        $client = new Client();
        $client->getEmitter()->attach($mock);

        return $client;
    }

    private function givenHttpClientWillReturnResponse($responseBody)
    {
        $responseBodyStream = Stream::factory($responseBody);
        $response = new Response(200, [], $responseBodyStream);
        $mock = new Mock([$response]);
        $client = new Client();
        $client->getEmitter()->attach($mock);

        return $client;
    }
}
