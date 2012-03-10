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
    public function importFromDump($snapshotName=false)
    {
        if($snapshotName === false)
        {
            throw new Exception('please define a snapshot-name!');
        }
        
        $compressor = new ImExPorterCompressor();
        $database = new ImExPorterDatabase();
        $databaseHandler = new ImExPorterDatabaseHandler();
        
        $settingsHandler = new ImExPorterSettingsHandler();
        $extensionSettings = $settingsHandler->getExtensionSettings();
        $snapshotDir = ImExPorterHelper::getProjectDir() . $extensionSettings['snapshotDir'] . $snapshotName . '/';
        
        if(!is_dir($snapshotDir))
        {
            throw new Exception('snapshot-folder does not exist!');
        }
        
        $databaseHandler->truncateAllTables();
        
        $fileList = scandir($snapshotDir);
        
        for($i=2;$i<count($fileList);$i++)
        {
            $fileName = $fileList[$i];
            $tableName = str_replace('.ssf', '', $fileName);
            
            $table = $compressor->decompress(file_get_contents($snapshotDir . $fileName));
            $databaseHandler->insertTableDataIntoDb($tableName, $table);
        }
    }
    
}