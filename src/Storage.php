<?php

namespace Sofi\data;

class Storage
{

    protected $basePath = '';
    protected $module = 'base'.DIRECTORY_SEPARATOR;
    protected $essence = 'data'.DIRECTORY_SEPARATOR;
    protected $formater = null;

    function __construct($path = '')
    {
        if ($path == '') {
            if (defined('BASE_PATH')) {
                $this->basePath = BASE_PATH.'/storage/';
            } else {
                $this->basePath = 'storage/';
            }
        } else {
            $this->basePath = $path;
        }

        $this->formater = new \app\modules\storage\format\JSON();
    }

    function module($module)
    {
        $this->module = $module.DIRECTORY_SEPARATOR;

        return $this;
    }

    function essence($essence = 'data')
    {
        $this->essence = $essence.DIRECTORY_SEPARATOR;

        return $this;
    }

    function delimiter($delimiter)
    {
        $this->delimiter = $delimiter.DIRECTORY_SEPARATOR;

        return $this;
    }

    function get($name)
    {
        $path = $this->basePath.$this->module.$this->delimiter.$this->essence;
        if (!is_dir($path)) {
            mkdir($path,0777,true);
        }
        
        $file = $path.$name.$this->formater->ext;
        if (file_exists($file)) {
            $this->formater->push(file_get_contents($file));
            return $this->formater->data;
        } else {
            return [];
        }

    }

    function save($name, $data)
    {
        $path = $this->basePath.$this->module.$this->delimiter.$this->essence;
        if (!is_dir($path)) {
            mkdir($path,0777,true);
        }
        
        $file = $path.$name.$this->formater->ext;

        $this->formater->data = $data;
        // var_dump($file);
        // var_dump($this->formater->pop());

        file_put_contents($file, $this->formater->pop());

        return $this;
     
    }

}