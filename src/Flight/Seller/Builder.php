<?php

namespace TravelPSDK\Flight\Seller;

use TravelPSDK\Flight\Seller\Info as SellerInfo,
    TravelPSDK\Flight\Seller\InfoFactory as SellerInfoFactory,
    TravelPSDK\Common\Collection as TicketsCollection
    ;

class Builder
{

    /**
     * @var \stdClass
     */
    private $sellerData;

    /**
     * @var SellerInfoFactory
     */
    private $sellerInfoFactory;

    /**
     * @param \stdClass $sellerData
     */
    public function __construct($sellerData)
    {
        $this->sellerData = $sellerData;
        $this->sellerInfoFactory = new SellerInfoFactory();
    }

    /**
     * @param \stdClass $sellerData
     * @return Entity
     */
    public static function build($sellerData)
    {
        $builder = new Builder($sellerData);

        $sellerInfo = $builder->buildSellerInfo();
        $ticketsCount = $builder->extractTicketsCount();
        $ticketsCollection = $builder->buildTicketsCollection($sellerInfo);
        $filtersBoundaries = $builder->buildFiltersBoundaries();

        $entity = new Entity($sellerInfo,
                             $ticketsCount,
                             $ticketsCollection,
                             $filtersBoundaries);

        return $entity;
    }

    private function buildFiltersBoundaries()
    {
        $this->validateSellerMetaGates();
        $filtersBoundaries = new FiltersBoundaries();
        if (!isset($this->sellerData->filters_boundary)) {
            return $filtersBoundaries;
        }
        $data = $this->sellerData->filters_boundary;

        foreach ($data as $key => $value) {
            $filterName = $key;
            $filterBoundary = $value;

            $filtersBoundaries->importFilter($filterName, $filterBoundary);
        }
        return $filtersBoundaries;
    }

    /**
     * @param SellerInfo $sellerInfo
     * @return \ArrayIterator
     */
    private function buildTicketsCollection($sellerInfo)
    {
        $proposals = $this->sellerData->proposals;
        $collection = new TicketsCollection();
        if (empty($proposals)) {
            return $collection;
        }

        $ticketFactory = new TicketFactory($sellerInfo);

        foreach ($proposals as $proposal) {
            $ticket = $ticketFactory->create($proposal);
            $collection->append($ticket);
        }

        return $collection;
    }

    private function extractTicketsCount()
    {
        $this->validateSellerMetaGates();
        $gates = (array) $this->sellerData->meta->gates;
        $gate = $gates[0];

        return $gate->good_count;
    }

    private function validateSellerMetaGates()
    {
        if (empty($this->sellerData->meta)
            ||
            empty($this->sellerData->meta->gates))
        {
            throw new \InvalidArgumentException("Seller data is invalid. Unable to get gate id/count!: " . serialize($this->sellerData));
        }
    }

    /**
     * @return SellerInfo
     */
    private function buildSellerInfo()
    {
        $this->validateSellerMetaGates();
        $sellerInfo = $this->sellerInfoFactory->create($this->sellerData);
        return $sellerInfo;
    }
}
