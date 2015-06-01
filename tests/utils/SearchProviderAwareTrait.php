<?php

namespace TravelPSDK\TestsUtils;

trait SearchProviderAwareTrait
{
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
