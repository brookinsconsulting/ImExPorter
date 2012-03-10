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
        $snapshotDir = ImExPorterHelper::getProjectDir() . $extensionSettings['snapshotDir'];
        
        if(!is_dir($snapshotDir))
        {
            throw new Exception('snapshot-folder does not exist!');
        }
        
        if(!is_writable($snapshotDir))
        {
            throw new Exception('snapshot-folder is not writeable!');
        }
        
        $compressor = new ImExPorterCompressor();
        
        foreach($database->getTables() as $tableName => $table)
        {
            $compressedTable = $compressor->compressTable($table);
            file_put_contents($snapshotDir . $tableName . '.ssf', $compressedTable);
        }
    }
    
}