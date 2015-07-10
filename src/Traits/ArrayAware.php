<?php

namespace TravelPSDK\Traits;

trait ArrayAware
{
    public function toArray()
    {
        $resultArray = [];
        foreach ($this as $propertyName => $value) {
            if (is_object($value) && method_exists($value, 'toArray')) {
                $value = $value->toArray();
            }

            $resultArray[$propertyName] = $value;
        }

        return $resultArray;
    }
}
