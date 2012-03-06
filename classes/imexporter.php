<?php

/**
 * @author Benjamin Boit 
 */
class ImExPorter
{
    
    /**
     * exports the current database to the filesystem 
     */
    public function export()
    {
        $databaseGenerator = new ImExPorterDatabaseGenerator();
        $database = $databaseGenerator->generate();
        
        $dumpGenerator = new ImExPorterDumpGenerator();
        $dumpGenerator->generateDumpFromDb($database);
    }
    
    /**
     * import to the current db from the filesystem 
     */
    public function import()
    {
        $dumpImporter = new ImExPorterDumpImporter();
        $dumpImporter->importFromDump();
    }
    
}