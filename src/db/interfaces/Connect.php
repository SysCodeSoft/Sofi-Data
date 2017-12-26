<?php

namespace Sofi\data\db\interfaces;

interface Connect
{
    function open(string $dns);
    
    function close();
    
    function isActive() : bool;
}

