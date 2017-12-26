<?php

namespace Sofi\data\db\MongoDB;

class Schema implements \Sofi\data\db\interfaces\Schema
{
 
    /**
     *
     * @var Connect
     */
    protected $connection = null;
    protected $schema = '';
    
    function __construct(\Sofi\data\db\interfaces\Connect $connection, string $schema) {
        $this->connection = $connection;
        $this->schema = $this->connection->{$schema};
    }
    
    public function query()
    {
        
    }

}

