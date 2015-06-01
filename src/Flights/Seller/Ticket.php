<?php

namespace TravelPSDK\Flights\Seller;

use TravelPSDK\Traits\OptionsAware as OptionsAwareTrait;

class Ticket extends \ArrayObject
{
    use OptionsAwareTrait;

    private $ticketTerms;
    private $totalDuration;
    private $segmentDurations;
    private $stopsAirports;
    private $maxStops;
    private $minStopDuration;
    private $maxStopDuration;
    private $isDirect;
    private $carriers;
    private $segments;
    private $segmentsAirports;
    private $segmentsTime;

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
        $this->ticketTerms = $terms;
        return $this;
    }

    public function getTicketTerms()
    {
        return $this->ticketTerms;
    }

    public function setTotalDuration($duration)
    {
        $this->totalDuration = $duration;
        return $this;
    }

    public function getTotalDuration()
    {
        return $this->totalDuration;
    }

    public function setSegmentDurations($data)
    {
        $this->segmentDurations = $data;
        return $this;
    }

    public function getSegmentDurations()
    {
        return $this->segmentDurations;
    }

    public function setStopsAirports($data)
    {
        $this->stopsAirports = $data;
        return $this;
    }
     
    public function getStopsAirports()
    {
        return $this->stopsAirports;
    }

    public function setMaxStops($stops)
    {
        $this->maxStops = $stops;
        return $this;
    }

    public function getMaxStops()
    {
        return $this->maxStops;
    }

    public function setMinStopDuration($duration)
    {
        $this->minStopDuration = $duration;
        return $this;
    }

    public function getMinStopDuration()
    {
        return $this->minStopDuration;
    }

    public function setMaxStopDuration($duration)
    {
        $this->maxStopDuration = $duration;
        return $this;
    }

    public function getMaxStopDuration()
    {
        return $this->maxStopDuration;
    }

    public function setIsDirect($state)
    {
        $this->isDirect = $state;
        return $this;
    }

    public function isDirect()
    {
        return (bool) $this->isDirect;
    }

    public function setCarriers($data)
    {
        $this->carriers = $data;
        return $this;
    }

    public function getCarriers()
    {
        return $this->carriers;
    }

    public function setSegments($segments)
    {
        $this->segments = $segments;
        return $this;
    }

    public function getSegments()
    {
        return $this->segments;
    }

    public function setSegmentsAirports($data)
    {
        $this->segmentsAirports = $data;
        return $this;
    }

    public function getSegmentsAirports()
    {
        return $this->segmentsAirports;
    }

    public function setSegmentsTime($data)
    {
        $this->segmentsTime = $data;
        return $this;
    }

    public function getSegmentsTime()
    {
        return $this->segmentsTime;
    }
}
