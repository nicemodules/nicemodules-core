<?php

namespace NiceModules\Core\Plugin;

class Resource
{
    const TYPE_JS = 'JAVASCRIPT';
    const TYPE_CSS = 'STYLESHEET';

    public string $type;
    public string $file;
    public bool $addVersion;

    public function __construct($type, $file, $addVersion = true)
    {
        $this->type = $type;
        $this->file = $file;
        $this->addVersion = $addVersion;
    }
}