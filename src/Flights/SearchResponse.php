<?php

namespace TravelPSDK\Flights;

class SearchResponse
{

    /**
     * @var \stdClass
     */
    private $responseData;

    /**
     * @param \stdClass $data
     */
    public function __construct($data)
    {
        $this->responseData = $data;
    }

    /**
     * @return string
     */
    public function getSearchID()
    {
        return $this->responseData->search_id;
    }
}
