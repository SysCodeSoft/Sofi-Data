<?php

namespace Sofi\data;

class Dataset
{

    /**
     * Рабочие данные
     * @var Array 
     */
    protected $cursor;
    protected $presenter;

    function __construct($cursor, $as = null)
    {
        $this->cursor = $cursor;
        $this->presenter = $as;
    }
    
    function each()
    {
//        reset($this->cursor);
        foreach ($this->cursor as $value) {
            yield (new $this->presenter($value));
        }
        return true;
    }
    
}
