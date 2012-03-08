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
        $settingsHandler = new ImExPorterSettingsHandler();
        $extensionSettings = $settingsHandler->getExtensionSettings();
        $bckDir = $extensionSettings['bckDir'];
        
        if(!is_dir($bckDir) || !is_writable($bckDir))
        {
            throw new Exception('export-folder does not exist or is not writeable!');
        }
        
        $compressor = new ImExPorterCompressor();
        
        foreach($database->getTables() as $tableName => $table)
        {
            $compressedTable = $compressor->compressTable($table);
            file_put_contents($bckDir . $tableName . '.bck', $compressedTable);
        }
    }
    
}