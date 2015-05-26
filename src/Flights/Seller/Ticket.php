<?php

namespace TravelPSDK\Flights\Seller;

use TravelPSDK\Traits\OptionsAware as OptionsAwareTrait;

class Ticket extends \ArrayObject
{
    use OptionsAwareTrait;

    /**
     * @param array $params
     */
    public function __construct(array $params = null)
    {
        parent::__construct();

        if ($params) {
            $this->setOptions($params);
        }
    }

    public function setTicketTerms($terms)
    {
        $this['ticketTerms'] = $terms;
        return $this;
    }

    public function setTotalDuration($duration)
    {
        $this['totalDuration'] = $duration;
        return $this;
    }

    public function setSegmentDurations($data)
    {
        $this['segmentDurations'] = $data;
        return $this;
    }

    public function setStopsAirports($data)
    {
        $this['stopsAirports'] = $data;
        return $this;
    }

    public function setMaxStops($stops)
    {
        $this['maxStops'] = $stops;
        return $this;
    }

    public function setMinStopDuration($duration)
    {
        $this['minStopDuration'] = $duration;
        return $this;
    }

    public function setMaxStopDuration($duration)
    {
        $this['maxStopDuration'] = $duration;
        return $this;
    }

    public function setIsDirect($state)
    {
        $this['isDirect'] = $state;
        return $this;
    }

    public function setCarriers($data)
    {
        $this['carriers'] = $data;
        return $this;
    }

    public function setSegments($segments)
    {
        $this['segments'] = $segments;
        return $this;
    }

    public function setSegmentsAirports($data)
    {
        $this['segmentsAirports'] = $data;
        return $this;
    }

    public function setSegmentsTime($data)
    {
        $this['segmentsTime'] = $data;
        return $this;
    }
}
