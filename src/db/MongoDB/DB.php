<?php

namespace Sofi\data\db\MongoDB;

class DB implements \Sofi\data\db\interfaces\DB
{
    /**
     *
     * @var Connect
     */
    protected $connection = null;
    protected $schemes = [];

    function __construct($dns = 'mongodb://localhost:27017') {
        if ($dns != null) $this->connect($dns);
    }

    public function connect(string $dns)
    {
        if ($dns != '') {
            $this->connection = new Connect();
            $this->connection->open($dns);
        }
    }

    public function disconnect()
    {
        $this->connection->close();
    }

    public function __get(string $schema) {
        if (empty($this->schemes[$schema])) {
            $this->schemes[$schema] = new Schema($this->connection, $schema);       
        }
        
        return $this->schemes[$schema];
    }

}

