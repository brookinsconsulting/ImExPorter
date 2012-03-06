<?php

/**
 * @author Benjamin Boit 
 */
interface ImExPortDatabaseInterface
{
    
    public function setTables($tables);
    
    public function addTable($tableName, ImExPorterTableInterface $table);
    
    public function getTables();
    
}
