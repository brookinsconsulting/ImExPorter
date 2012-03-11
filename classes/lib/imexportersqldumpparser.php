<?php

/**
 * @author Benjamin Boit 
 */
class ImExPorterSqlDumpParser
{
    
    protected $sqlFile;
    
    public function __construct($fileName=false)
    {
        if($fileName !== false)
        {
            $this->loadSqlFile($fileName);
        }
    }
    
    /**
     * loads and sets the given sql-file
     * @param string $fileName
     * @throws Exception 
     */
    public function loadSqlFile($fileName)
    {
        $settingsHandler = new ImExPorterSettingsHandler();
        $extensionSettings = $settingsHandler->getExtensionSettings();
        
        $filePath = ImExPorterHelper::getProjectDir() . $extensionSettings['structureDumpsDir'] . $fileName;
        
        if(!is_file($filePath))
        {
            throw new Exception('Cannot load sql-file!');
        }
        
        $this->sqlFile = file_get_contents($filePath);
    }
    
    /**
     * returns an array of sql commands
     * @return array
     * @throws Exception 
     */
    public function parse()
    {
        $parsedSqlCommands = explode(';', $this->sqlFile);
        
        if(count($parsedSqlCommands) === 0)
        {
            throw new Exception('Sql-file is empty!');
        }
        
        return $parsedSqlCommands;
    }
    
}