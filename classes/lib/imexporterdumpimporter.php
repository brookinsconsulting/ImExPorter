<?php

/**
 * @author Benjamin Boit 
 */
class ImExPorterDumpImporter
{
    
    /**
     * import data from dump
     * @throws Exception 
     */
    public function importFromDump()
    {
        $compressor = new ImExPorterCompressor();
        $database = new ImExPorterDatabase();
        $databaseHandler = new ImExPorterDatabaseHandler();
        
        if(!is_dir(__FOLDER__))
        {
            throw new Exception('export-folder does not exist!');
        }
        
        $databaseHandler->truncateAllTables();
        
        $fileList = scandir(__FOLDER__);
        
        for($i=2;$i<count($fileList);$i++)
        {
            $fileName = $fileList[$i];
            $tableName = str_replace('.bck', '', $fileName);
            
            $table = $compressor->decompress(file_get_contents(__FOLDER__ . $fileName));
            $databaseHandler->insertTableDataIntoDb($tableName, $table);
        }
    }
    
}