<?php

namespace TravelPSDK\Flights;

use TravelPSDK\Traits\OptionsAware as OptionsAwareTrait;

class SearchParameters extends \ArrayObject
{

    use OptionsAwareTrait;

    /**
     * @param array $params
     */
    public function __construct(array $params = null)
    {
        parent::__construct();

        if ($params) {
            $this->setOptions($params);
        }
    }

    /**
     * @var string
     */
    private $apiToken;

    /**
     * @param string $marker
     * @return $this
     */
    public function setAffiliateMarker($marker)
    {
        $this['marker'] = $marker;
        return $this;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setApiToken($token)
    {
        $this->apiToken = $token;
        return $this;
    }

    /**
     * @param string $host
     * @return $this
     */
    public function setHost($host)
    {
        $this['host'] = $host;
        return $this;
    }

    /**
     * @param string $ip
     * @return $this
     */
    public function setIp($ip)
    {
        $this['user_ip'] = $ip;
        return $this;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this['locale'] = $locale;
        return $this;
    }

    /**
     * @param string $tripClass
     * @return $this
     */
    public function setTripClass($tripClass)
    {
        if ($tripClass !== TripClass::ECONOMY &&
            $tripClass !== TripClass::BUSINESS) 
        {
            throw new \InvalidArgumentException("Invalid tripClass given: $tripClass");
        }
        $this['trip_class'] = $tripClass;
        return $this;
    }

    /**
     * @param array $passengers
     * @return $this
     */
    public function setPassengers(array $passengers)
    {
        $validKeys = ['adults', 'children', 'infants'];
        $this->validateArrayFormat($passengers, $validKeys, "Invalid passengers format given: %s");
        $this['passengers'] = $passengers;
        return $this;
    }

    /**
     * @param array $segments
     * @return $this
     */
    public function setSegments(array $segments)
    {
        $validKeys = ['origin', 'desgination', 'date'];
        $expectedDateFormat = "Y-m-d";
        foreach ($segments as $segment) {
            $this->validateArrayFormat($segment, $validKeys, "Invliad segment format given: %s");
            $date = \DateTime::createFromFormat($expectedDateFormat, $segment['date']);
            if (!$date) {
                throw new \InvalidArgumentException("Invalid date format given: {$segment['date']}. Expected format: $expectedDateFormat");
            }
        }
        $this['segments'] = $segments;
        return $this;
    }

    /**
     * @param array $array
     * @param array $expectedKeys
     * @param string $errorMessage
     * @throws \InvalidArgumentException
     */
    private function validateArrayFormat($array, $expectedKeys, $errorMessage)
    {
        $keys = array_keys($array);

        $intersection = array_intersect($keys, $expectedKeys);
        if (empty($intersection)) {
            $errorMessage = sprintf($errorMessage, serialize($array));
            throw new \InvalidArgumentException($errorMessage);
        }
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        if (!isset($this['signature'])) {
            $this['signature'] = $this->makeSignature();
        }

        return $this['signature'];
    }

    /**
     * @param array $array
     * @return array
     */
    private function recursiveSort($array)
    {
        $clonedArray = (array) $array;
        ksort($clonedArray, SORT_NATURAL);
        foreach ($clonedArray as $key => $value) {
            if (is_array($clonedArray[$key])) {
                $clonedArray[$key] = $this->recursiveSort($clonedArray[$key]);
            }
        }
        return $clonedArray;
    }

    /**
     * @param array $array
     * @return array
     */
    private function getFlatternedValues($array)
    {
        $return = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $return = array_merge($return, $this->getFlatternedValues($value));
            } else {
                $return[] = $value;
            }
        }

        return $return;
    }

    /**
     * @return string
     */
    private function makeSignature()
    {
        $parameters = $this->recursiveSort($this);
        $values = $this->getFlatternedValues($parameters);

        $signatureString = implode(':', $values);
        $signatureString = $this->apiToken . ':' . $signatureString;  

        $signature = md5($signatureString);
        return $signature;
    }

    /**
     * @return array
     */
    public function getApiParams()
    {
        $clonedArray = (array) $this;
        $clonedArray['signature'] = $this->getSignature();
        return $clonedArray;
    }
}
