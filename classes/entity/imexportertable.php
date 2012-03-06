<?php

/**
 * @author Benjamin Boit 
 */
class ImExPorterTable implements ImExPorterTableInterface
{
    
    protected $rows = array();
    
    /**
     * set rows
     * @param array $rows 
     */
    public function setRows($rows)
    {
        $this->rows = $rows;
    }
    
    /**
     * add row
     * @param ImExPorterRowInterface $row 
     */
    public function addRow(ImExPorterRowInterface $row)
    {
        $this->rows[] = $row;
    }
    
    /**
     * get rows
     * @return array 
     */
    public function getRows()
    {
        return $this->rows;
    }
    
}