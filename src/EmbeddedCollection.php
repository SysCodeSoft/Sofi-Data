<?php

namespace Sofi\data;

/**
 * Description of Embedded
 *
 * @author hawk
 */
class EmbeddedCollection extends \ArrayObject
{

    protected $format = [];

    function __construct(array $format = [], array $data = [])
    {
        $this->format = $format;

        $items = [];

        foreach ($data as $item) {
            $rs = array_merge($format, (array)$item);
            $items[] = new Embedded($rs);
        }

        parent::__construct($items);
    }

    function offsetSet($index, $newval)
    {
        parent::offsetSet($index, new Embedded(array_merge($this->format, (array) $newval)));
    }

    function offsetGet($index)
    {
        if (!$this->offsetExists($index)) {
            return null;
        } else {
            return parent::offsetGet($index);
        }
    }

    function append($value = [])
    {
        parent::append(new Embedded(array_merge($this->format, $value)));
    }

}
