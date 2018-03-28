<?php

namespace Sofi\data\AR;

abstract class ActiveRecord extends \Sofi\data\Record implements interfaces\ActiveRecord
{

    const REALTION_TYPE_ONE = 0;
    const REALTION_TYPE_MANY = 1;

    function attributes(): array
    {
        $attr = parent::attributes();
        $attr[] = $this->primaryKey();

        return $attr;
    }

    /**
     * [
     *      'type' => (one|many)
     *      'keys' => [[self_key => dist_key],...]
     *      'class' => ActiveRecord class
     * ]
     * @return type
     */
    function relations()
    {
        return [];
    }

    function __call($name, $arguments)
    {
        $relations = $this->relations();

        if (empty($relations[$name])) {
            return null;
        }

        $cond = [];
        foreach ($relations[$name]['keys'] as $key => $value) {
            $cond[$value] = $this->{$key};
        }
        foreach ($arguments as $key => $value) {
            $cond[$value] = $this->{$key};
        }
        $query = $relations[$name]['class']::find($cond);

        if ($relations[$name]['type'] == self::REALTION_TYPE_MANY) {
            return $query->all();
        } else {
            return $query->one();
        }
    }

    function load($data)
    {
        $this->data = [];
        parent::load($data);
    }

    public function isNew()
    {
        return !isset($this->data[$this->primaryKey()]);
    }

    public function save()
    {
        if ($this->isNew()) {
            return $this->insert();
        } else {
            return $this->update();
        }
    }

}
