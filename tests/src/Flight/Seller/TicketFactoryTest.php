<?php

namespace TravelPSDK\Tests\Flight\Seller;

use \TravelPSDK\Flight\Seller\TicketFactory,
    \TravelPSDK\Flight\Seller\Ticket,
    \TravelPSDK\Flight\Seller\InfoFactory as SellerInfoFactory,
    \TravelPSDK\TestsUtils\SearchProviderAwareTrait
    ;

class TicketFactoryTest extends \PHPUnit_Framework_TestCase
{
    use SearchProviderAwareTrait;

    public function test_Factory_Creates_OneWay_Ticket()
    {
        $data = $this->givenSearchReturnsDataForOneWayTicket();

        $sellerInfoFactory = new SellerInfoFactory();
        $sellerInfo = $sellerInfoFactory->create($data);

        $ticketFactory = new TicketFactory($sellerInfo);

        foreach ($data->proposals as $proposal) {
            $ticket = $ticketFactory->create($proposal);
            $this->assertFalse($ticket->isComposite());
        }

    }

    public function test_Factory_Creates_Composite_Ticket()
    {
        $data = $this->givenSearchReturnsDataForCompositeTicket();

        $sellerInfoFactory = new SellerInfoFactory();
        $sellerInfo = $sellerInfoFactory->create($data);

        $ticketFactory = new TicketFactory($sellerInfo);

        $ticket = $ticketFactory->create($data->proposals[0]);
        $this->assertTrue($ticket->isComposite());
        $this->assertEquals(2, count($ticket));

        $originTicket = $ticket[0];
        $returnTicket = $ticket[1];

        $this->assertInstanceOf('TravelPSDK\\Flight\\Seller\\Ticket', $originTicket);
        $this->assertInstanceOf('TravelPSDK\\Flight\\Seller\\Ticket', $returnTicket);

        // origin trip
        $originCode = $originTicket->getOriginCode();
        $destinationCode = $originTicket->getDestinationCode();

        $this->assertEquals('OTP', $originCode);
        $this->assertEquals('STN', $destinationCode);
        
        // return trip
        $originCode = $returnTicket->getOriginCode();
        $destinationCode = $returnTicket->getDestinationCode();

        $this->assertEquals('STN', $originCode);
        $this->assertEquals('OTP', $destinationCode);
    }

    /**
     * @return array
     */
    private function givenSearchReturnsDataForOneWayTicket()
    {
        // get the last result in the sample set
        $data = $this->getSampleDataByIndex(3);
        $data = json_decode($data);
        $data = array_pop($data);
        unset($data->flight_numbers[1],
              $data->segments[1],
              $data->proposals[0]->segments_time[1],
              $data->proposals[0]->segment[1],
              $data->proposals[0]->segment_durations[1],
              $data->proposals[0]->segments_airports[1]);

        return $data;
    }

    /**
     * @return array
     */
    private function givenSearchReturnsDataForCompositeTicket()
    {
        // get the last result in the sample set
        $data = $this->getSampleDataByIndex(3);
        $data = json_decode($data);
        $data = array_pop($data);

        return $data;
    }
}
