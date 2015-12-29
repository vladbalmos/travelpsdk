<?php

namespace TravelPSDK\Flight;

use \GuzzleHttp\Client as HttpClient,
    \TravelPSDK\Constants,
    \TravelPSDK\Common\Collection as SellerCollection,
    \TravelPSDK\Flight\Seller\Builder as SellerBuilder
    ;

class SearchResults implements \IteratorAggregate
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

    public function getIterator()
    {
        return $this->get();
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

        } while (true);
    }

    /**
     * @param \stdClass $rawData
     * @return studd
     */
    public function makeResults($rawData)
    {
        $collection = new SellerCollection();

        foreach ($rawData as $data) {
            if ($this->isEndDataMarker($data)) {
                continue;
            }
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
        if (empty($data)) {
            return true;
        }

        if (is_array($data)) {
            if (isset($data[0]) && is_object($data[0])) {
                $data = (array) $data[0];
            }
            return $this->hasOnlySearchIDProperty($data);
        }

        $data = (array) $data;
        return $this->hasOnlySearchIDProperty($data);
    }

    private function hasOnlySearchIDProperty($data)
    {
        return count($data) === 1 && isset($data['search_id']);
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
