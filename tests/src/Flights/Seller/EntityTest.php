<?php

namespace Tests\Flights\Seller;

use \TravelPSDK\Flights\Seller\Builder as SellerBuilder,
    \TravelPSDK\Flights\Seller\Entity as SellerEntity
    ;

class SellerEntityTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider searchResultsProvider
     */
    public function test_Integrity($data)
    {
        $data = json_decode($data)[0];
        $entity = SellerBuilder::build($data);

        $info = $entity->getInfo();
        $ticketsCount = $entity->getTicketsCount();
        $ticketsCollection = $entity->getTicketsCollection();

        $this->assertInstanceOf('\TravelPSDK\Flights\Seller\Entity', $entity);
        $this->assertInstanceOf('\TravelPSDK\Flights\Seller\Info', $info);
        $this->assertInternalType('int', $ticketsCount);
        $this->assertInstanceOf('\TravelPSDK\Common\Collection', $ticketsCollection);
    }

    public function searchResultsProvider()
    {
        $globIterator = glob(SAMPLE_DATA_PATH . '/flights.api.search.results.*');

        $providedData = [];
        foreach ($globIterator as $filename) {
            $data = trim(file_get_contents($filename));
            $providedData[] = [$data];
        }
        return $providedData;
    }

}
