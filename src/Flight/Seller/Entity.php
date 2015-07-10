<?php

namespace TravelPSDK\Flight\Seller;

use TravelPSDK\Traits\ArrayAware as ArrayAwareTrait;

class Entity
{

    use ArrayAwareTrait;

    /**
     * @var Info
     */
    private $info;

    /**
     * @var int
     */
    private $ticketsCount;

    /**
     * @var Collection
     */
    private $ticketsCollection;

    /**
     * @var FiltersBoundaries
     */
    private $filtersBoundaries;

    /**
     * @param Info $info
     * @param int $ticketsCount
     * @param \ArrayIterator $ticketsCollection
     * @param FiltersBoundaries $filtersBoundaries
     */
    public function __construct(Info $info,
                                $ticketsCount,
                                \ArrayIterator $ticketsCollection,
                                FiltersBoundaries $filtersBoundaries)
    {
        $this->info = $info;
        $this->ticketsCount = $ticketsCount;
        $this->ticketsCollection = $ticketsCollection;
        $this->filtersBoundaries = $filtersBoundaries;
    }

    /**
     * @return Info
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @return int
     */
    public function getTicketsCount()
    {
        return $this->ticketsCount;
    }

    /**
     * @return \ArrayIterator
     */
    public function getTicketsCollection()
    {
        return $this->ticketsCollection;
    }

    /**
     * @return FiltersBoundaries
     */
    public function getFiltersBoundaries()
    {
        return $this->filtersBoundaries;
    }
                                
}
