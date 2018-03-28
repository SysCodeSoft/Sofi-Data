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

    public function embedded()
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
            $this->load($data);
        }
    }

    function load($data)
    {
        $embedded = $this->embedded();
        $newData = (array) $data;
        $fields = $this->fields();
        foreach ($this->attributes() as $key) {
            $default = $fields[$key] ?? null;
            if (is_array($default)) {
                if (isset($embedded[$key]) && count($default) == 0) {
                    $this->data[$key] = new EmbeddedCollection($embedded[$key], !empty($newData[$key]) ? (array) $newData[$key] : [], $this);
                } else {
                    $this->data[$key] = new Embedded($newData[$key] ?? $default, $this);
                }
            } else {
                $this->data[$key] = $newData[$key] ?? $default;
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

        $attr = $this->attributes();

        if (in_array($name, $attr)) {
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

        $fields = $this->fields();
        $embedded = $this->embedded();

        if (!empty($fields[$name]) && is_array($fields[$name])) {
            if (isset($embedded[$name]) && count($fields[$name]) == 0) {
                $this->data[$name] = new EmbeddedCollection($embedded[$name], [], $this);
            } else {
                $this->data[$name] = new Embedded($fields[$name], $this);
            }
            return $this->data[$name];
        }

        return $this->fields()[$name] ?? null;
    }

    public function asArray(): array
    {
        $result = [];
        $attr = array_diff($this->attributes(), $this->hidden());

        foreach ($attr as $key) {
            $result[$key] = is_object($this->{$key}) ? (array) $this->{$key} : $this->{$key};
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
