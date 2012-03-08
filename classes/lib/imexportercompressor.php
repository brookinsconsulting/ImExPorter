<?php

/**
 * @author Benjamin Boit 
 */
class ImExPorterCompressor
{
    
    /**
     * compresses a table object and returns a string
     * @param ImExPorterTableInterface $table
     * @return string 
     */
    public function compressTable(ImExPorterTableInterface $table)
    {
        $settingsHandler = new ImExPorterSettingsHandler();
        $extensionSettings = $settingsHandler->getExtensionSettings();
        
        $serializedTable = serialize($table);
        $base64encodedTable = base64_encode($serializedTable);
        return gzdeflate($base64encodedTable, $extensionSettings['compressionLevel']);
    }
    
    /**
     * decompresses a string and creates a table object
     * @param type $dumpString
     * @return ImExPorterTableInterface 
     */
    public function decompress($dumpString)
    {
        $uncompressedTable = gzinflate($dumpString);
        $base64decodedTable = base64_decode($uncompressedTable);
        return unserialize($base64decodedTable);
    }
    
}