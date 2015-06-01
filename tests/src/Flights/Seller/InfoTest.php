<?php

namespace TravelPSDK\Tests\Flights\Seller;

use \TravelPSDK\Flights\Seller\InfoFactory as SellerInfoFactory,
    \TravelPSDK\TestsUtils\SearchProviderAwareTrait
    ;

class InfoTest extends \PHPUnit_Framework_TestCase
{

    use SearchProviderAwareTrait;

    private $factory;

    protected function setUp()
    {
        $this->factory = new SellerInfoFactory();
    }

    /**
     * @dataProvider searchResultsProvider
     */
    public function test_Integrity($data)
    {
        $data = json_decode($data)[0];
        $sellerInfo = $this->factory->create($data);

        $this->assertInstanceOf('\TravelPSDK\Flights\Seller\Info', $sellerInfo);
    }

    /**
     * @dataProvider searchResultsProvider
     */
    public function test_Properties($data)
    {
        $data = json_decode($data)[0];
        $sellerInfo = $this->factory->create($data);

        $id = $sellerInfo->getId();
        $phone = $sellerInfo->getPhone();
        $label = $sellerInfo->getLabel();
        $averageRate = $sellerInfo->getAverageRate();
        $currencyCode = $sellerInfo->getCurrencyCode();
        $isAirline = $sellerInfo->isAirline();
        $workingHours = $sellerInfo->getWorkingHours();
        $paymentMethods = $sellerInfo->getPaymentMethods();
        $email = $sellerInfo->getEmail();

        $this->assertInternalType('int', $id);
        $this->assertInternalType('array', $phone);
        $this->assertNotNull($label);
        $this->assertNotNull($currencyCode);
        $this->assertInternalType('bool', $isAirline);
        $this->assertInternalType('array', $paymentMethods);
    }
}
