<?php


namespace Core;

class Request 
{

    function __construct(
        private string $route, 
        private string $method, 
        private array $parameters=[]
        ) {}

    function getData()
    {
        return $this->parameters;
    }

    function getRoute()
    {
        return $this->route;
    }

    function getMethod() 
    {
        return $this->method;
    }
}