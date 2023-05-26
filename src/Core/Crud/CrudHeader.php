<?php

namespace NiceModules\Core\Crud;

class CrudHeader
{
    public string $text;
    public string $value;
    public bool $sortable;
    public string $type;
    public int $width;
    
    public function __construct(string $text, string $value, string $type, bool $sortable = true,  ?int $width = null)
    {
        $this->text = $text;
        $this->value = $value;
        $this->type = $type;
        $this->sortable = $sortable;
        $this->sortable = $sortable;
        
        if($width !== null){
            $this->width = $width;    
        }

    
    }

}