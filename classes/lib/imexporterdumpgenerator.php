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
        $compressor = new ImExPorterCompressor();
        
        foreach($database->getTables() as $tableName => $table)
        {
            $compressedTable = $compressor->compressTable($table);
            file_put_contents('./bck/' . $tableName . '.bck', $compressedTable);
        }
    }
    
}