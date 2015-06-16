<?php

namespace TravelPSDK\Flight;

use \GuzzleHttp\Client as HttpClient,
    \TravelPSDK\Constants
    ;

class Search
{

    /**
     * @var SearchParameters
     */
    private $searchParameters;

    /**
     * @param SearchParameters $searchParameters
     */
    public function __construct(SearchParameters $searchParameters)
    {
        $this->searchParameters = $searchParameters;
    }

    /**
     * Returns the searchID
     * @return string
     */
    public function run()
    {
        $searchParams = $this->searchParameters->getApiParams();
        $response = $this->executeRequest($searchParams);
        return $response->getSearchID();
    }

    /**
     * @param array $searchParams
     * @return SearchResponse
     */
    private function executeRequest(array $searchParams)
    {
        $client = new HttpClient(['base_url' => Constants::API_HOST,
                                  'headers' => [
                                      'Content-Type' => 'application/json'
                                  ]]);

        $response = $client->post('/v1/flight_search', [
            'json' => $searchParams
        ]);

        $statusCode = $response->getStatusCode();
        $body = $response->getBody();
        $strBody = $body->__toString();
        if ($statusCode !== 200) {
            throw new \RuntimeException("Remote host status code exception: $statusCode:{$strBody}");
        }

        return $this->makeApiResponse($strBody);
    }

    /**
     * @param string $jsonString
     * @return SearchResponse
     */
    private function makeApiResponse($jsonString)
    {
        $data = json_decode($jsonString);
        if (!$data) {
            throw new \RuntimException("Unable to decode json response: $jsonString");
        }

        return new SearchResponse($data);
    }
}
