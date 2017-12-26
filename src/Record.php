<?php

namespace Sofi\data;

class Record
{

    /**
     * Рабочие данные
     * @var Array 
     */
    protected $data = [];

    public function fields(): array
    {
        return [];
    }

    public function hidden(): array
    {
        return [];
    }
    
    public function closed(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return array_keys($this->fields());
    }

    function __construct($data = null)
    {
        if ($data !== null) {
            $newData = (array) $data;
            foreach ($this->fields() as $key => $value) {
                $this->data[$key] = $newData[$key] ?? $value;
            }
        }
    }

    public function __set($name, $value)
    {
        if (method_exists($this, 'setAttr' . $name)) {
            return $this->{'setAttr' . $name}($name, $value);
        }
        
        if (in_array($name, $this->closed())) {
            return false;
        }

        $attr = $this->fields();

        if (isset($attr[$name])) {
            $this->data[$name] = $value;
        } else {
            $this->{$name} = $value;
        }
    }

    public function __unset($name)
    {
        if (isset($this->data[$name])) {
            $this->data[$name] = $this->fields()[$name];
        } else {
            unset($this->{$name});
        }
    }

    public function __get($name)
    {
        if (method_exists($this, 'getAttr' . $name)) {
            return $this->{'getAttr' . $name}($name);
        }

        if (isset($this->data[$name])) {
            return $this->data[$name];
        }

        return $this->fields()[$name] ?? null;
    }

    public function asArray(): array
    {
        $result = [];
        $attr = array_diff($this->attributes(), $this->hidden());
        
        foreach ($attr as $key) {
            $result[$key] = $this->{$key};
        }
        
        return $result;
    }

    public function isModified(): bool
    {
        if ($this->data == [])
            return false;

        if ($this->data == $this->fields())
            return false;

        foreach ($this->fields() as $key => $value) {
            if ($this->data[$key] != $value)
                return true;
        }

        return false;
    }

}
