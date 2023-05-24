<?php

namespace NiceModules\Core\Crud;

class CrudHeader
{
    public string $text;
    public string $value;
    public bool $sortable;
    public int $width;
    
    public function __construct(string $text, string $value, bool $sortable, ?int $width = null)
    {
        $this->text = $text;
        $this->value = $value;
        $this->sortable = $sortable;
        
        if($width !== null){
            $this->width = $width;    
        }
        
    }

}