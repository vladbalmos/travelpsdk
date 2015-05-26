<?php

namespace TravelPSDK\Flights;

use \GuzzleHttp\Client as HttpClient,
    \TravelPSDK\Constants,
    \TravelPSDK\Common\Collection as SellerCollection,
    \TravelPSDK\Flights\Seller\Builder as SellerBuilder
    ;

class SearchResults
{

    /**
     * @var string
     */
    private $searchID;

    /**
     * @param string $searchID
     */
    public function __construct($searchID)
    {
        if (!$searchID) {
            throw new \RuntimeException("The searchID is invalid!");
        }
        $this->searchID = $searchID;
    }

    /**
     * @return bool
     */
    public function get()
    {
        do {
            $rawData = $this->fetch();
            $decodedData = $this->decodedData($rawData);

            if ($this->isEndDataMarker($decodedData)) {
                break;
            }

            $results = $this->makeResults($decodedData);
            yield $results;

        } while (!$this->isEndDataMarker($decodedData));
    }

    /**
     * @param \stdClass $rawData
     * @return studd
     */
    public function makeResults($rawData)
    {
        $collection = new SellerCollection();

        foreach ($rawData as $data) {
            $seller = SellerBuilder::build($data);
            $collection->append($seller);

        }
        return $collection;
    }

    /**
     * @param string $rawData
     * @return \stdClass
     */
    public function decodedData($rawData)
    {
        file_put_contents('/tmp/results', $rawData . "\n\n\n", FILE_APPEND);
        $data = json_decode($rawData);
        if ( ($decodingError = json_last_error()) !== JSON_ERROR_NONE) {
            throw new \RuntimeException("Unable to decode json response: $rawData", $decodingError);
        }
        return $data;
    }

    /**
     * Check if $data represents and end of data marker
     * @param \stdClass $data
     * @return bool
     */
    public function isEndDataMarker($data)
    {

        if (!is_array($data)) { // end data marker is an array
            return false;
        }

        if (count($data) !== 1) { // end data marker has only 1 element
            return false;
        }
        $data = $data[0];
        $propertiesCount = 0;
        foreach ($data as $key => $value) {
            if (++$propertiesCount > 1) {  // end data marker item has only 1 property
                return false;
            }
        }

        return isset($data->search_id); // end data marker has a search_id property
    }

    /**
     * @return array
     */
    public function fetch()
    {
        $client = new HttpClient(['base_url' => Constants::API_HOST]);

        $response = $client->get('/v1/flight_search_results', [
            'query' => ['uuid' => $this->searchID],
            //'debug' => true
        ]);

        $statusCode = $response->getStatusCode();
        $body = $response->getBody();
        $strBody = $body->__toString();
        if ($statusCode !== 200) {
            throw new \RuntimeException("Remote host status code exception: $statusCode:{$strBody}");
        }
        return $strBody;
    }
}
