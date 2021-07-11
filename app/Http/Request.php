<?php

namespace App\Http;

class Request
{
    private $httpMethod;
    private $uri;
    private $queryParams = [];
    private $postVars = [];
    private $headers = [];

    public function __construct()
    {
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->setUri();
    }

    private function setUri()
    {
        $this->uri = explode('?', $_SERVER['REQUEST_URI'] ?? '')[0];
    }


    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    public function getUri()
    {
        return $this->uri;
    }
    
    public function getHeaders()
    {
        return $this->headers;
    }
    
    public function getQueryParams()
    {
        return $this->queryParams;
    }
    
    public function getPostVars()
    {
        return $this->postVars;
    }

}