<?php

namespace Sofi\data\db\interfaces;

interface Schema
{
    function __construct(Connect $connection, string $schema);
        
    function query();
}

