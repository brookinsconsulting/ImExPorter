<?php

/**
 * @author Benjamin Boit 
 */
class ImExPorterDatabase implements ImExPortDatabaseInterface
{
    
    protected $tables = array();
    
    /**
     * set tables
     * @param array $tables 
     */
    public function setTables($tables)
    {
        $this->tables = $tables;
    }
    
    /**
     * add a given table
     * @param string $tableName
     * @param ImExPorterTableInterface $table 
     */
    public function addTable($tableName, ImExPorterTableInterface $table)
    {
        $this->tables[$tableName] = $table;
    }
    
    /**
     * get tables
     * @return array 
     */
    public function getTables()
    {
        return $this->tables;
    }
    
}
