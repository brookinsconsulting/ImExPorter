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
        
        return @$this->ezDb->arrayQuery($sql);
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
    
    /**
     * inserts given row-object into table
     * @param string $tableName
     * @param ImExPorterRowInterface $tableRow 
     */
    public function insertRowIntoTable($tableName=false, ImExPorterRowInterface $tableRow)
    {
        $values = get_object_vars($tableRow);
        $columns = array_keys($values);
        
        $queryColumns = implode(',', $columns);
        
        foreach($values as $key => $value)
        {
            $values[$key] = "'" . mysql_real_escape_string($value) . "'";
        }
        
        $queryValues = implode(',', $values);
        
        $sql = "INSERT INTO " . $tableName . " (" . $queryColumns . ") VALUES(" . $queryValues . ")";
        
        $databaseHandler = new ImExPorterDatabaseHandler();
        $databaseHandler->execute($sql);
    }
    
    /**
     * inserts the given table into tb
     * @param string $tableName
     * @param ImExPorterTableInterface $table 
     */
    public function insertTableDataIntoDb($tableName, ImExPorterTableInterface $table)
    {

        foreach($table->getRows() as $tableRow)
        {
            $this->insertRowIntoTable($tableName, $tableRow);
        }
        
    }
    
}