<?php

namespace Sofi\data\AR\interfaces;

interface ActiveRecord {
    
    /**
     * 
     * @return \Sofi\data\db\interfaces\DB
     */
    static function db();
    static function tableName();
    static function primaryKey();
    
    static function find($conditions);
    
    function isNew();
        
    function save();
    function delete();
    function insert();
    function update();
    function upsert();
    static function commands();
    
}
