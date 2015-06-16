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
        $sellerID = $this->sellerInfo->getId();
        $ticketData = [
            'ticketTerms' => (array) $data->terms->$sellerID,
            'totalDuration' => $data->total_duration,
            'segmentDurations' => $data->segment_durations,
            'stopsAirports' => $data->stops_airports,
            'maxStops' => $data->max_stops,
            'minStopDuration' => $data->min_stop_duration,
            'maxStopDuration' => $data->max_stop_duration,
            'isDirect' => $data->is_direct,
            'carriers' => (array) $data->carriers,
            'segments' => []
        ];

        $segmentsAirports = (array) $data->segments_airports;
        $ticketData['segmentsAirports'] = (array) $segmentsAirports[0];

        $segmentsTime = (array) $data->segments_time;
        $ticketData['segmentsTime'] = (array) $segmentsTime[0];

        $segments = (array) $data->segment[0]->flight;
        foreach ($segments as $segment) {
            $ticketData['segments'][] = (array) $segment;
        }

        $ticket = new Ticket($ticketData);
        return $ticket;
    }
}
