<?php

namespace NiceModules\Core;

abstract class Controller
{
    protected Context $context;

    public function __construct()
    {
        $this->context = Context::instance();
    }

    /**
     * @return Context
     */
    public function getContext(): mixed
    {
        return $this->context;
    }
}