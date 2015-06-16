<?php

namespace TravelPSDK\Flight\Seller;

class Entity
{

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

    public function __construct(Info $info,
                                $ticketsCount,
                                \ArrayIterator $ticketsCollection)
    {
        $this->info = $info;
        $this->ticketsCount = $ticketsCount;
        $this->ticketsCollection = $ticketsCollection;
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

    public function getTicketsCollection()
    {
        return $this->ticketsCollection;
    }
                                
}
