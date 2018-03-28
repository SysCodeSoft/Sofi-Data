<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Sofi\data;

/**
 * Description of Embedded
 *
 * @author hawk
 */
class Embedded extends \ArrayObject
{

    protected $owner;

    function __construct($input = '[]', $owner = null)
    {
        $this->owner = $owner;
        parent::__construct($input, \ArrayObject::ARRAY_AS_PROPS);
    }

    function embedded()
    {
        return is_object($this->owner) ? $this->owner->embedded() : [];
    }

    function offsetGet($index)
    {
        if (!$this->offsetExists($index)) {
            return null;
        } else {
            $embedded = $this->embedded();
            $val = parent::offsetGet($index);
            if (isset($embedded[$index]) && !is_object($val)) {
                $val = new Embedded(array_merge($embedded[$index], $val), $this);
//                echo 'Set n get ' . $index . '<br>';
                $this->offsetSet($index, $val);
            }
            return $val;
        }
    }

    function offsetSet($index, $newval)
    {
//        if ($index == 'price')
//        echo 'set in set index:' . ($index) . '<br>';
//        var_dump($newval);
//        echo '<br>';
        $embedded = $this->embedded();
        if (isset($embedded[$index])) {
            parent::offsetSet($index, new Embedded(array_merge($embedded[$index], (array) $newval), $this));
        } else {
//            echo '<br>This index'.$index.'!<br>';
//            var_dump($this);
//            echo '<br>';
            parent::offsetSet($index, $newval);
        }
//        echo '<br>End set in set index:' . ($index) . '<br>';
    }

}
