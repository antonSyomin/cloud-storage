<?php


namespace Core;

abstract class Controller
{
    protected $className;

    function __construct()
    {
        $classNameParts = explode("\\", static::class);
        $this->className = end($classNameParts);
        $this->services = new ("\Services\\" . $this->className . "Service")();
    }
}