<?php

namespace TravelPSDK\Tests\Flight\Seller;

use \TravelPSDK\Flight\Seller\Builder as SellerBuilder,
    \TravelPSDK\Flight\Seller\Entity as SellerEntity,
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
        $filtersBoundaries = $entity->getFiltersBoundaries();

        $this->assertInstanceOf('\TravelPSDK\Flight\Seller\Entity', $entity);
        $this->assertInstanceOf('\TravelPSDK\Flight\Seller\Info', $info);
        $this->assertInternalType('int', $ticketsCount);
        $this->assertInstanceOf('\TravelPSDK\Common\Collection', $ticketsCollection);
        $this->assertInstanceOf('\TravelPSDK\Flight\Seller\FiltersBoundaries', $filtersBoundaries);
    }


}
