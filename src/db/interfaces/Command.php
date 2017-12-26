<?php

namespace Sofi\data\db\interfaces;

interface Command
{
    function insert();
    function find();
    function delete();
    function update();
}

