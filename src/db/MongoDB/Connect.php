<?php

namespace Sofi\data\db\MongoDB;

class Connect implements \Sofi\data\db\interfaces\Connect
{
    /**
     *
     * @var \MongoDB\Driver\Manager
     */
    protected $manager = null;
    
    public function close()
    {
        $this->manager->close();
    }

    public function open(string $dns)
    {
        
        $this->manager = new \MongoDB\Client($dns);
    }
    
    function isActive() : bool
    {
        return $this->manager == null ? false : true;
    }
    
    public function __get(string $schema) {
        $this->manager->{$schema};  
    }
    

}

