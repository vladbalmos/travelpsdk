<?php

namespace TravelPSDK\Flight\Seller;


class TicketFactory
{

    /**
     * @var Info
     */
    private $sellerInfo;

    public function __construct(Info $sellerInfo)
    {
        $this->sellerInfo = $sellerInfo;
    }

    public function create($data)
    {
        if ($this->proposalHasMultipleSegments($data)) {
            $segmentsCount = count($data->segment);

            $compositeTicket = new Ticket();
            for ($i = 0; $i < $segmentsCount; $i++) {
                $ticket = $this->createTicket($data, $i);
                $compositeTicket->append($ticket);
            }

            return $compositeTicket;
        }

        $ticket = $this->createTicket($data, 0);
        return $ticket;
    }

    private function createTicket($data, $segmentIndex)
    {
        $sellerID = $this->sellerInfo->getId();

        $ticketData = [
            'ticketTerms' => (array) $data->terms->$sellerID,
            'totalDuration' => $data->total_duration,
            'stopsAirports' => $data->stops_airports,
            'maxStops' => $data->max_stops,
            'minStopDuration' => $data->min_stop_duration,
            'maxStopDuration' => $data->max_stop_duration,
            'isDirect' => $data->is_direct,
            'carriers' => (array) $data->carriers,
            'segments' => []
        ];

        $segmentsDurations = (array) $data->segment_durations;
        $ticketData['segmentDuration'] = $segmentsDurations[$segmentIndex];

        $segmentsAirports = (array) $data->segments_airports;
        $ticketData['segmentsAirports'] = (array) $segmentsAirports[$segmentIndex];

        $segmentsTime = (array) $data->segments_time;
        $ticketData['segmentsTime'] = (array) $segmentsTime[$segmentIndex];

        $segments = (array) $data->segment[$segmentIndex]->flight;
        foreach ($segments as $segment) {
            $ticketData['segments'][] = (array) $segment;
        }

        $ticket = new Ticket($ticketData);
        return $ticket;
    }

    /**
     * @param \stdClass $data
     * @return bool
     */
    private function proposalHasMultipleSegments($data)
    {
        return count($data->segment) > 1;
    }
}
