<?php

namespace TravelPSDK\Common;

class Collection extends \ArrayIterator
{

    /**
     * @param	array	$array
     * @param	int	$flags	
     */
    public function __construct($array = array(), $flags = 0)
    {
        parent::__construct($array, $flags);
    }
}
