<?php

namespace TravelPSDK\Tests\Flights\Seller;

use \TravelPSDK\Flights\Seller\Builder as SellerBuilder,
    \TravelPSDK\Flights\Seller\Entity as SellerEntity,
    \TravelPSDK\TestsUtils\SearchProviderAwareTrait
    ;

class SellerEntityTest extends \PHPUnit_Framework_TestCase
{

    use SearchProviderAwareTrait;

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


}
