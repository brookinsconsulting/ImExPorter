<?php

/**
 * @author Benjamin Boit 
 */
class ImExPorterDatabaseHandler
{
    
    protected $ezDb;
    
    public function __construct()
    {
        $settingsHandler = new ImExPorterSettingsHandler();
        $databaseSettings = $settingsHandler->getDatabaseSettings();
        $this->ezDb = eZDB::instance(false, $databaseSettings);
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
     * executes the given commands
     * @param array $sql
     * @throws Exception 
     */
    public function executeMultiple($sql=array())
    {
        if(count($sql) === 0)
        {
            throw new Exception('Empty array of sql commands, stopping!');
        }
        
        $this->execute('BEGIN');
        
        foreach($sql as $sqlCommand)
        {
            $this->execute($sqlCommand);
        }
        
        $this->execute('COMMIT');
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
        
        $this->execute('BEGIN');
        
        foreach($tableNames as $tableName)
        {
            $sql = 'TRUNCATE ' . $tableName;
            $this->execute($sql);
        }
        
        $this->execute('COMMIT');
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
        
        $this->execute($sql);
    }
    
    /**
     * inserts the given table into tb
     * @param string $tableName
     * @param ImExPorterTableInterface $table 
     */
    public function insertTableDataIntoDb($tableName, ImExPorterTableInterface $table)
    {
        
        $this->execute('BEGIN');

        foreach($table->getRows() as $tableRow)
        {
            $this->insertRowIntoTable($tableName, $tableRow);
        }
        
        $this->execute('COMMIT');
        
    }
    
}