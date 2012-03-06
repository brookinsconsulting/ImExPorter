<?php

/**
 * @author Benjamin Boit 
 */
class ImExPorterDumpImporter
{
    
    public function importFromDump()
    {
        $fileList = scandir('./bck');
        
        unset($fileList[0]);
        unset($fileList[1]);
        
        $compressor = new ImExPorterCompressor();
        $database = new ImExPorterDatabase();
        $databaseHandler = new ImExPorterDatabaseHandler();
        
        foreach($fileList as $file)
        {
            $table = $compressor->decompress(file_get_contents('./bck/' . $file));
            $database->addTable(str_replace('.bck', '', $file), $table);
        }

        return $database;
    }
    
}