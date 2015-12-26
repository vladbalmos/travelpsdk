<?php

namespace TravelPSDK\TestsUtils;

trait SearchProviderAwareTrait
{
    /**
     * @return array
     */
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

    /**
     * @param int $index
     * @return string
     */
    public function getSampleDataByIndex($index)
    {
        $filename = SAMPLE_DATA_PATH . '/flights.api.search.results.' . $index;

        $data = file_get_contents($filename);
        return $data;
    }
}
