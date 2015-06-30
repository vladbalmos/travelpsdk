<?php

namespace TravelPSDK\Flight\Seller;

use Stringy\StaticStringy as S
    ;

class FiltersBoundaries implements \Countable
{

    /**
     * @var array
     */
    private $filters = array();

    /**
     * @return int
     */
    public function count()
    {
        return count($this->filters);
    }

    /**
     * @param string $rawName
     * @param \stdClass $boundary
     */
    public function importFilter($rawName, $boundary)
    {
        $name = S::camelize($rawName);
        $boundary = (array) $boundary;
        $isRanged = false;
        $title = S::humanize($rawName);

        if (isset($boundary['max']) || isset($boundary['min'])) {
            $isRanged = true;
        }

        $filterData = [
            'name' => $name,
            'isRanged' => $isRanged,
            'title' => $title,
            'values' => $boundary
        ];

        $this->filters[] = $filterData;
    }
}
