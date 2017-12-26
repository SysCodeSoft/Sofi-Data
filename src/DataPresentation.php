<?php

namespace Sofi\data;

class DataPresentation extends \stdClass
{

    public $params = [];
    protected $data = [];
    protected $guidelines = [];

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __unset($name)
    {
        if (isset($this->data[$name])) {
            unset($this->data[$name]);
        }
    }

    public function __get($name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }

        return null;
    }
    
    public function __construct($data = null)
    {
        if ($data != null) $this->load($data);
    }
    
    public function load($data)
    {
        $this->data = $data;
    }


    public function asArray() : array
    {
        return $this->data;
    }

    public function asObject()
    {
        return (object)$this->data;
    }

    function guideline($agent, $type = 'text/html')
    {
        $this->guidelines[$type] = $agent;
    }
    
    function present($type = 'text/html')
    {
        
    }
    
    function __toString()
    {
        return $this->present();
    }

}
