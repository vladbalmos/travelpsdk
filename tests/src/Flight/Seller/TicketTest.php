<?php

namespace TravelPSDK\Tests\Flight\Seller;

use \TravelPSDK\Flight\Seller\InfoFactory as SellerInfoFactory,
    \TravelPSDK\Flight\Seller\TicketFactory,
    \TravelPSDK\TestsUtils\SearchProviderAwareTrait
    ;

class TicketTest extends \PHPUnit_Framework_TestCase
{

    use SearchProviderAwareTrait;

    private $sellerFactory;

    protected function setUp()
    {
        $this->sellerFactory = new SellerInfoFactory();
    }

    /**
     * @dataProvider searchResultsProvider
     */
    public function test_Integrity($data)
    {
        $data = json_decode($data)[0];
        $sellerInfo = $this->sellerFactory->create($data);

        $this->assertInstanceOf('\TravelPSDK\Flight\Seller\Info', $sellerInfo);

        $ticketFactory = new TicketFactory($sellerInfo);

        $this->assertTrue(isset($data->proposals));
        $this->assertInternalType('array', $data->proposals);

        foreach ($data->proposals as $proposal) {
            $ticket = $ticketFactory->create($proposal);

            $this->assertInstanceOf('\TravelPSDK\Flight\Seller\Ticket', $ticket);
        }
    }

    /**
     * @dataProvider searchResultsProvider
     */
    public function test_Properties($data)
    {
        $data = json_decode($data)[0];
        $sellerInfo = $this->sellerFactory->create($data);

        $this->assertInstanceOf('\TravelPSDK\Flight\Seller\Info', $sellerInfo);

        $ticketFactory = new TicketFactory($sellerInfo);

        $this->assertTrue(isset($data->proposals));
        $this->assertInternalType('array', $data->proposals);

        foreach ($data->proposals as $proposal) {
            $ticket = $ticketFactory->create($proposal);

            $this->doPropertiesTest($ticket);
        }
    }

    private function doPropertiesTest($ticket)
    {
        $terms = $ticket->getTicketTerms();
        $totalDuration = $ticket->getTotalDuration();
        $segmentDuration = $ticket->getSegmentDuration();
        $this->assertInternalType('int', $segmentDuration);
        $stopsAirports = $ticket->getStopsAirports();
        $maxStops = $ticket->getMaxStops();
        $minStopDuration = $ticket->getMinStopDuration();
        $maxStopDuration = $ticket->getMaxStopDuration();
        $isDirect = $ticket->isDirect();
        $carriers = $ticket->getCarriers();
        $segments = $ticket->getSegments();
        $segmentsAirports = $ticket->getSegmentsAirports();
        $segmentsTime = $ticket->getSegmentsTime();
    }
}
