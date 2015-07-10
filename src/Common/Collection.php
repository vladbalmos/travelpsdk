<?php

namespace TravelPSDK\Common;

use TravelPSDK\Traits\ArrayAware as ArrayAwareTrait;

class Collection extends \ArrayIterator
{

    use ArrayAwareTrait;

    /**
     * @param	array	$array
     * @param	int	$flags	
     */
    public function __construct($array = array(), $flags = 0)
    {
        parent::__construct($array, $flags);
    }
}
