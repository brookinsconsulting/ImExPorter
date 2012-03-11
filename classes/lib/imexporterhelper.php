<?php

/**
 * @author Benjamin Boit 
 */
class ImExPorterHelper
{
    
    /**
     * helper method for getting the projectDir
     * @return string
     */
    public static function getProjectDir()
    {
        return substr(__DIR__, 0, strpos(__DIR__, '/extension')) . '/';
    }
    
    /**
     * helper method for getting the extensionDir
     * @return type 
     */
    public static function getExtensionDir()
    {
        return self::getProjectDir() . 'extension/';
    }
    
    /**
     * helper method for getting the varDir
     * @return type 
     */
    public static function getVarDir()
    {
        return self::getProjectDir() . 'var/';
    }
    
    /**
     * helper method for getting the ImExPorter extension Dir
     * @return type 
     */
    public static function getImExPorterDir()
    {
        return substr(__DIR__, 0, strpos(__DIR__, '/classes/lib')) . '/';
    }
    
    /**
     * shortcut for accessing the database-settings
     * @return array
     */
    public static function getDatabaseSettings()
    {
        $settingsHandler = new ImExPorterSettingsHandler();
        
        return $settingsHandler->getDatabaseSettings();
    }
    
    /**
     * shortcut for accessing the extension-settings
     * @return array
     */
    public static function getExtensionSettings()
    {
        $settingsHandler = new ImExPorterSettingsHandler();
        
        return $settingsHandler->getExtensionSettings();
    }
    
}