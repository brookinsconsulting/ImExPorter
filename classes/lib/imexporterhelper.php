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
    
}