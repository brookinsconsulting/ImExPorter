<?php

/**
 * @author Benjamin Boit 
 */
class ImExPorterSettingsHandler
{
    
    protected $ezIni;
    protected $activeExtensions;
    
    public function __construct()
    {
        $this->ezIni = eZINI::instance();
        $this->activeExtensions = eZExtension::activeExtensions();
    }
    
    /**
     * searches if an extension configured in the map is active
     * @return mixed
     */
    public function findMatchingExtension()
    {
        //$this->ezIni->reset();
        
        // get ImExPorter extension / settings mappings
        $extensionSettings = $this->getExtensionSettings();
        
        $configuredExtensions = array_keys($extensionSettings['extensionSettingsMap']);
        
        foreach($configuredExtensions as $configuredExtension)
        {
            if(array_search($configuredExtension, $this->activeExtensions))
            {
                return $configuredExtension;
            }
        }
        
        return false;
    }
    
    /**
     * returns the database settings configured
     * @return array 
     */
    public function getDatabaseSettings()
    {
        
        if(!$this->ezIni->hasSection('DatabaseSettings') || $this->ezIni->variable('DatabaseSettings', 'Database') === 'nextgen')
        {
            return $this->getExtensionDatabaseSettings();
        }
        
        return array(
            'server' => $this->ezIni->variable('DatabaseSettings', 'Server'),
            'user' => $this->ezIni->variable('DatabaseSettings', 'User'),
            'port' => $this->ezIni->variable('DatabaseSettings', 'Port'),
            'password' => $this->ezIni->variable('DatabaseSettings', 'Password'),
            'database' => $this->ezIni->variable('DatabaseSettings', 'Database'),
            'charset' => $this->ezIni->variable('DatabaseSettings', 'Charset'),            
        );

    }
    
    /**
     * gets the database settings from an active extension
     * @return mixed 
     */
    public function getExtensionDatabaseSettings()
    {
        
        //$this->ezIni->reset();
        
        $extension = $this->findMatchingExtension();
        
        if($extension === false)
        {
            return false;
        }
        
        $extensionSettings = $this->getExtensionSettings();
        $extensionConfigFile = $extensionSettings['extensionSettingsMap'][$extension];
        $extensionConfigFilePath = './extension/' . $extension . '/' . $extensionConfigFile;
        
        if(!is_file($extensionConfigFilePath))
        {
            return false;
        }
        
        $this->ezIni = eZINI::fetchFromFile($extensionConfigFilePath);
        
        if(!$this->ezIni->hasSection('DatabaseSettings'))
        {
            return false;
        }
        
        return array(
            'server' => $this->ezIni->variable('DatabaseSettings', 'Server'),
            'user' => $this->ezIni->variable('DatabaseSettings', 'User'),
            'port' => $this->ezIni->variable('DatabaseSettings', 'Port'),
            'password' => $this->ezIni->variable('DatabaseSettings', 'Password'),
            'database' => $this->ezIni->variable('DatabaseSettings', 'Database'),
            'charset' => $this->ezIni->variable('DatabaseSettings', 'Charset'),            
        );
        
    }
    
    /**
     * returns the extension settings configured
     * @return array 
     */
    public function getExtensionSettings()
    {
        //$this->ezIni->reset();
        
        if(!$this->ezIni->hasSection('ImExPortSettings'))
        {
            return $this->getFallbackExtensionSettings();
        }
        
        return array(
            'compressionLevel' => $this->ezIni->variable('ImExPortSettings', 'CompressionLevel'),
            'bckDir' => $this->ezIni->variable('ImExPortSettings', 'BckDir'),
            'extensionSettingsMap' => $this->ezIni->variable('ImExPortSettings', 'ExtensionSettingsMap')
        );

    }
    
    /**
     * get fallback extension settings configured
     * @return array 
     */
    public function getFallbackExtensionSettings()
    {
        //$this->ezIni->reset();
        $this->ezIni = eZINI::fetchFromFile('./extension/imexporter/settings/imexporter.ini');

        return array(
            'compressionLevel' => $this->ezIni->variable('ImExPortSettings', 'CompressionLevel'),
            'bckDir' => $this->ezIni->variable('ImExPortSettings', 'BckDir'),
            'extensionSettingsMap' => $this->ezIni->variable('ImExPortSettings', 'ExtensionSettingsMap')
        );
    }
    
}