<?php

/**
 * @author Benjamin Boit 
 */
class ImExPorterDatabaseHandler
{
    
    protected $ezDb;
    
    public function __construct()
    {
        $this->ezDb = eZDB::instance();
    }
    
    /**
     * execute the given sql on db
     * @param string $sql
     * @return array 
     */
    protected function execute($sql=false)
    {
        if($sql === false)
        {
            throw new Exception('No sql for execution given!');
        }
        
        return $this->ezDb->arrayQuery($sql);
    }
    
    /**
     * get the defined tableNames in current db
     * @return array
     */
    public function getTableNames()
    {        
        return array_keys($this->ezDb->eZTableList());
    }
    
    /**
     * gets all rows from given table
     * @param type $tableName
     * @return type
     * @throws Exception 
     */
    public function getAllFromTable($tableName=false)
    {
        if($tableName === false)
        {
            throw new Exception('No table-name given!');
        }
        
        $sql = 'SELECT * FROM ' . $tableName;
        
        return $this->execute($sql);
    }
    
    /**
     * truncates all tables in current db 
     */
    public function truncateAllTables()
    {
        $tableNames = $this->getTableNames();
        
        foreach($tableNames as $tableName)
        {
            $sql = 'TRUNCATE ' . $tableName;
            $this->execute($sql);
        }
    }
    
    public function insertTableDataIntoDb($tableName, ImExPorterTableInterface $table)
    {
        $definedVars = get_object_vars($table);
        
        $cols = '';
        $values = '';
        
        foreach($definedVars as $name => $value)
        {
            $cols .= $name . ',';
            $values .= "'" . $value . "',";
        }
        
        $cols = substr($cols, 0, strlen($cols)-1);
        $values = substr($values, 0, strlen($values)-1);
        
        
        $sql = "INSERT INTO " . $tableName . " (" . $cols . ") VALUES(" . $values . ")";
        var_dump($sql);
    }
    
}