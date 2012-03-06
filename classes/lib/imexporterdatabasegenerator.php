<?php

/**
 * @author Benjamin Boit 
 */
class ImExPorterDatabaseGenerator
{
    
    protected $databaseHandler;
    
    public function __construct()
    {
        $this->databaseHandler = new ImExPorterDatabaseHandler();
    }
    
    /**
     * generates a database object from current database
     * @return ImExPorterDatabase 
     */
    public function generate()
    {
        
        $tableNames = $this->databaseHandler->getTableNames();
        $database = new ImExPorterDatabase();
        
        foreach($tableNames as $tableName)
        {
            $table = new ImExPorterTable();
            $rows = $this->databaseHandler->getAllFromTable($tableName);
            
            foreach($rows as $row) {
                $tableRow = new ImExPorterRow();
                
                foreach($row as $col => $value)
                {   
                    $tableRow->$col = $value; 
                }
                
                $table->addRow($tableRow);
            }
            $database->addTable($tableName, $table); 
        }

        return $database;
        
    }
    
}