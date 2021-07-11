<?php

namespace App\Http;

class Router
{
    private $url = '';
    private $prefix = '';
    private $routes = [];
    private $request;
    
    public function __construct($url)
    {
        $this->request = new Request();
        $this->url = $url;
        $this->setPrefix();
    }

    private function setPrefix()
    {
        $parseUrl = parse_url($this->url);
        $this->prefix = $parseUrl['path'] ?? '';
    }

    private function add($method, $route, $params = [])
    {
        foreach ($params as $key => $value) {
            if ($value instanceof \Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';
        $this->routes[$patternRoute][$method] = $params;  
    }

    private function getUri()
    {
        $uri = $this->request->getUri();
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
        return end($xUri);
    }

    private function getRoute()
    {
        $uri = $this->getUri();
        $httpMethod = $this->request->getHttpMethod();

        foreach ($this->routes as $patternRoute => $methods) {
            if (preg_match($patternRoute, $uri)) {
                if ($methods[$httpMethod]) {
                    return $methods[$httpMethod];
                }
                throw new \Exception("Método não permitido", 405);                
            }
        }
        throw new \Exception("URL não encontrada", 404);
    }

    public function get($route, $params = [])
    {
        return $this->add('GET', $route, $params);        
    }

    public function dispatch()
    {
        try {
            $route = $this->getRoute();

            echo '<pre>';
            print_r($route);
            echo '</pre>';
            exit;
        } catch (\Exception $e) {
            return new Response($e->getCode(), $e->getMessage());            
        }
    }

}