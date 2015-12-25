<?php

namespace TravelPSDK\Flight;

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
    public function getLocale()
    {
        return $this->responseData->locale;
    }

    /**
     * @return string
     */
    public function getSearchID()
    {
        return $this->responseData->search_id;
    }

    /**
     * @return string (Y - Economy, C - Business)
     */
    public function getTripClass()
    {
        return $this->responseData->trip_class;
    }

    /**
     * @return int Total number of agencies
     */
    public function getGatesCount()
    {
        return $this->responseData->gates_count;
    }

    /**
     * @return array List of trip components [date, origin IATA, destination IATA]
     */
    public function getSegments()
    {
        return $this->responseData->segments;
    }

    /**
     * @return bool
     */
    public function isRoundTrip()
    {
        $segments = $this->getSegments();
        $state = count($segments) === 2;
        return $state;
    }

    /**
     * @return array Passenger information [adults => x, children => y, infants => z]
     */
    public function getPassengers()
    {
        return (array) $this->responseData->passengers;
    }

    /**
     * @return array
     */
    public function getCurrencyRates()
    {
        return (array) $this->responseData->currency_rates;
    }
}
