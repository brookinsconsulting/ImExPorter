<?php

/**
 * @author Benjamin Boit 
 */
class ImExPorter
{
    
    /**
     * exports the current database to the filesystem 
     */
    public function export($snapshotName='default')
    {        
        $databaseGenerator = new ImExPorterDatabaseGenerator();
        $database = $databaseGenerator->generate();
        
        $dumpGenerator = new ImExPorterDumpGenerator();
        $dumpGenerator->generateDumpFromDb($database, $snapshotName);
    }
    
    /**
     * import to the current db from the filesystem 
     */
    public function import($snapshotName='default')
    {
        $dumpImporter = new ImExPorterDumpImporter();
        $dumpImporter->importFromDump($snapshotName);
    }
    
    /**
     * loads a given sql structure file 
     */
    public function loadStructure()
    {
        
    }
    
}