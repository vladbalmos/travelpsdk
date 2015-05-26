<?php

namespace TravelPSDK\Flights\Seller;

use TravelPSDK\Traits\OptionsAware as OptionsAwareTrait;

class Info extends \ArrayObject
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

    public function setId($id)
    {
        $this['id'] = $id;
        return $this;
    }

    /**
     * @param array|string $phone
     */
    public function setPhone($phone)
    {
        if (!is_array($phone)) {
            $phone = [$phone];
        }

        $this['phone'] = $phone;
        return $this;
    }

    public function setLabel($label)
    {
        $this['label'] = $label;
        return $this;
    }

    public function setAverageRate($rate)
    {
        $this['averageRate'] = $rate;
        return $this;
    }

    public function setCurrencyCode($currency)
    {
        $this['currencyCode'] = $currency;
        return $this;
    }

    public function setIsAirline($state)
    {
        $this['isAirline'] = (bool) $state;
        return $this;
    }

    public function setWorkingHours($hours)
    {
        $this['workingHours'] = $hours;
        return $this;
    }

    public function setPaymentMethods($methods)
    {
        if (!is_array($methods)) {
            $methods = [$methods];
        }
        $this['methods'] = $methods;
        return $this;
    }

    public function setEmail($email)
    {
        $this['email'] = $email;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAirline()
    {
        return $this['isAirline'];
    }


}
