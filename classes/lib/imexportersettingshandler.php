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
            'database' => $this->ezIni->variable('DatabaseSettings', 'Database')        
        );

    }
    
    /**
     * gets the database settings from an active extension
     * @return mixed 
     */
    public function getExtensionDatabaseSettings()
    {

        $extension = $this->findMatchingExtension();
        
        if($extension === false)
        {
            throw new Exception('No global database-settings and no matching extension found!');
        }
        
        $extensionSettings = $this->getExtensionSettings();
        $extensionConfigFile = $extensionSettings['extensionSettingsMap'][$extension];
        $extensionConfigFilePath = ImExPorterHelper::getExtensionDir() . $extension . '/' . $extensionConfigFile;
        
        if(!is_file($extensionConfigFilePath))
        {
            throw new Exception('Could not find database-settings anywhere!');
        }
        
        $this->ezIni = eZINI::fetchFromFile($extensionConfigFilePath);
        
        if(!$this->ezIni->hasSection('DatabaseSettings'))
        {
            throw new Exception('Found extension config-file given in settings, but no database configured there!');
        }

        return array(
            'server' => $this->ezIni->variable('DatabaseSettings', 'Server'),
            'user' => $this->ezIni->variable('DatabaseSettings', 'User'),
            'port' => $this->ezIni->variable('DatabaseSettings', 'Port'),
            'password' => $this->ezIni->variable('DatabaseSettings', 'Password'),
            'database' => $this->ezIni->variable('DatabaseSettings', 'Database')      
        );
        
    }
    
    /**
     * returns the extension settings configured
     * @return array 
     */
    public function getExtensionSettings()
    {
        
        if(!$this->ezIni->hasSection('ImExPortSettings'))
        {
            return $this->getFallbackExtensionSettings();
        }
        
        return array(
            'compressionLevel' => $this->ezIni->variable('ImExPortSettings', 'CompressionLevel'),
            'snapshotDir' => $this->ezIni->variable('ImExPortSettings', 'SnapshotDir'),
            'extensionSettingsMap' => $this->ezIni->variable('ImExPortSettings', 'ExtensionSettingsMap')
        );

    }
    
    /**
     * get fallback extension settings configured
     * @return array 
     */
    public function getFallbackExtensionSettings()
    {
        
        $this->ezIni = eZINI::fetchFromFile(ImExPorterHelper::getImExPorterDir() . 'settings/imexporter.ini');

        return array(
            'compressionLevel' => $this->ezIni->variable('ImExPortSettings', 'CompressionLevel'),
            'snapshotDir' => $this->ezIni->variable('ImExPortSettings', 'SnapshotDir'),
            'extensionSettingsMap' => $this->ezIni->variable('ImExPortSettings', 'ExtensionSettingsMap')
        );
        
    }
    
}