<?php

namespace App\Http;

class Request
{
  private $router;
  private $headers      = [];
  private $httpMethod;
  private $postVars     = [];
  private $queryParams  = [];
  private $uri;

  public function __construct($router) {
    $this->router      = $router;
    $this->headers     = getallheaders();
    $this->httpMethod  = $_SERVER['REQUEST_METHOD'] ?? '';
    $this->queryParams = $_GET ?? [];
    $this->setUri();      
    $this->setPostVars();
  }

  private function setPostVars() {
    if ($this->httpMethod == 'GET') return false;

    $this->postVars = $_POST ?? [];

    $inputRaw = file_get_contents('php://input');

    $this->postVars = (strlen($inputRaw) && empty($_POST)) ? json_decode($inputRaw, true) : $this->postVars;
  }

  private function setUri() {
    $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    $xUri = explode('?', $this->uri);
    $this->uri = $xUri[0];
    //$this->uri = explode('?', $this->uri)[0];
  }

  public function getRouter() {
    return $this->router;
  }

  public function getHttpMethod() {
    return $this->httpMethod;
  }

  public function getUri() {
    return $this->uri;
  }

  public function getHeaders() {
    return $this->headers;
  }

  public function getQueryParams() {
    return $this->queryParams;
  }

  public function getPostVars() {
    return $this->postVars;
  }
}
