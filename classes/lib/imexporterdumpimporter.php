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
        
        $settingsHandler = new ImExPorterSettingsHandler();
        $extensionSettings = $settingsHandler->getExtensionSettings();
        $bckDir = $extensionSettings['bckDir'];
        
        if(!is_dir($bckDir))
        {
            throw new Exception('export-folder does not exist!');
        }
        
        $databaseHandler->truncateAllTables();
        
        $fileList = scandir($bckDir);
        
        for($i=2;$i<count($fileList);$i++)
        {
            $fileName = $fileList[$i];
            $tableName = str_replace('.bck', '', $fileName);
            
            $table = $compressor->decompress(file_get_contents($bckDir . $fileName));
            $databaseHandler->insertTableDataIntoDb($tableName, $table);
        }
    }
    
}