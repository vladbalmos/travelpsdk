<?php

namespace TravelPSDK\Flight;

use \GuzzleHttp\Client as HttpClient,
    \TravelPSDK\Constants
    ;

class BookingUrl
{
    private $searchID;
    private $ticketTermsID;

    private $httpClient;
    private $requestResponse;
    private $url;

    /**
     * @param string $searchID
     * @param string $ticketTermsID
     */
    public function __construct($searchID, $ticketTermsID)
    {
        $this->searchID = $searchID;
        $this->ticketTermsID = $ticketTermsID;
    }

    private function executeRequest()
    {
        $client = $this->getHttpClient();
        $url = $this->makeUrl();
        $response = $client->get($url);

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new \RuntimeException("Remote host status code exception: $statusCode");
        }
        $body = $response->getBody();
        $strBody = $body->__toString();

        $jsonResponse = json_decode($strBody);
        return $jsonResponse;
    }

    /**
     * @return string
     */
    private function makeUrl()
    {
        $url = Constants::API_HOST . "/v1/flight_searches/{$this->searchID}/clicks/{$this->ticketTermsID}.json";
        return $url;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient()
    {
        if (!$this->httpClient) {
            $this->httpClient = new HttpClient();
        }
        return $this->httpClient;
    }

    /**
     * @param \GuzzleHttp\Client $client
     */
    public function setHttpClient($client)
    {
        $this->httpClient = $client;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        if (!$this->requestResponse) {
            $this->requestResponse = $this->executeRequest();
        }

        return $this->requestResponse->url;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (!$this->url) {
            $this->url = $this->getUrl();
        }

        return $this->url;
    }
}
