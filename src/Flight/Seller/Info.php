<?php

namespace TravelPSDK\Flight\Seller;

use TravelPSDK\Traits\OptionsAware as OptionsAwareTrait;

class Info extends \ArrayObject
{

    use OptionsAwareTrait;

    private $id;
    private $phone = array();
    private $label;
    private $averageRate;
    private $currencyCode;
    private $isAirline;
    private $workingHours;
    private $paymentMethods = array();
    private $email;

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
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param array|string $phone
     */
    public function setPhone($phone)
    {
        if (!is_array($phone)) {
            $phone = [$phone];
        }

        $this->phone = $phone;
        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setAverageRate($rate)
    {
        $this->averageRate = $rate;
        return $this;
    }

    public function getAverageRate()
    {
        return $this->averageRate;
    }

    public function setCurrencyCode($currency)
    {
        $this->currencyCode = $currency;
        return $this;
    }

    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    public function setIsAirline($state)
    {
        $this->isAirline = (bool) $state;
        return $this;
    }

    public function setWorkingHours($hours)
    {
        $this->workingHours = $hours;
        return $this;
    }

    public function getWorkingHours()
    {
        return $this->workingHours;
    }

    public function setPaymentMethods($methods)
    {
        if (!is_array($methods)) {
            $methods = [$methods];
        }
        $this->paymentMethods = $methods;
        return $this;
    }

    public function getPaymentMethods()
    {
        return $this->paymentMethods;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return bool
     */
    public function isAirline()
    {
        return $this->isAirline;
    }


}
