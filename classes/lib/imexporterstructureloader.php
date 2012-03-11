<?php

/**
 * @author Benjamin Boit 
 */
class ImExPorterStructureLoader
{
    
    /**
     * applies the given sql file on db
     * @param type $fileName 
     */
    public function load($fileName)
    {
        
        $sqlParser = new ImExPorterSqlDumpParser($fileName);
        $parsedSqlCommands = $sqlParser->parse();
        
        $databaseHandler = new ImExPorterDatabaseHandler();
        
        $databaseHandler->executeMultiple($parsedSqlCommands);
        
    }
    
}