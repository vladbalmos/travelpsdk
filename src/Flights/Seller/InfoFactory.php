<?php

namespace TravelPSDK\Flights\Seller;

use TravelPSDK\Flights\Seller\Info as SellerInfo
    ;

class InfoFactory
{
    /**
     * @param \stdClass $sellerData
     * @return Info
     */
    public function create($sellerData)
    {
        $gates = (array) $sellerData->meta->gates;
        $gate = $gates[0];
        $gateID = $gate->id;

        if (empty($sellerData->gates_info)) {
            throw new \InvalidArgumentException("Seller data is invalid. Unable to get the gate info!");
        }


        $gateData = (array) $sellerData->gates_info->$gateID;
        $gateData['id'] = $gateID;

        $sellerInfo = new SellerInfo($gateData);
        return $sellerInfo;
    }
}
