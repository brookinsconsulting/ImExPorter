<?php

/**
 * @author Benjamin Boit 
 */
class ImExPorterDumpGenerator
{
    
    /**
     * saves a given db as dump to the filesystem
     * @param ImExPorterDatabase $database 
     */
    public function generateDumpFromDb(ImExPorterDatabase $database)
    {
        if(!is_dir(__FOLDER__) || !is_writable(__FOLDER__))
        {
            throw new Exception('export-folder does not exist or is not writeable!');
        }
        
        $compressor = new ImExPorterCompressor();
        
        foreach($database->getTables() as $tableName => $table)
        {
            $compressedTable = $compressor->compressTable($table);
            file_put_contents(__FOLDER__ . $tableName . '.bck', $compressedTable);
        }
    }
    
}