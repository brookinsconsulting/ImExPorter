<?php

/**
 * @author Benjamin Boit 
 */
interface ImExPorterTableInterface
{
    
    public function setRows($rows);
    
    public function addRow(ImExPorterRowInterface $row);
    
    public function getRows();
    
}