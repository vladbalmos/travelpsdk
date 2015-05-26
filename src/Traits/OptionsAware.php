<?php

namespace TravelPSDK\Traits;

use function Stringy\create as s;

trait OptionsAware
{
    public function setOptions($options)
    {
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($this->makeCamelCase($key));
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function makeCamelCase($str)
    {
        return s($str)->camelize($str);
    }
}
