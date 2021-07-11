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

        $params['variables'] = [];        
        $patternVariable = '/{(.*?)}/';
        if (preg_match_all($patternVariable, $route, $matches)) {
            $route = preg_replace($patternVariable, '(.*?)', $route);
        }

        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

        echo '<pre>';
        print_r($patternRoute);
        echo '</pre>';
        exit;

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
                if (isset($methods[$httpMethod])) {
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

    public function post($route, $params = [])
    {
        return $this->add('POST', $route, $params);        
    }
    
    public function put($route, $params = [])
    {
        return $this->add('PUT', $route, $params);        
    }
    
    public function delete($route, $params = [])
    {
        return $this->add('DELETE', $route, $params);        
    }

    public function dispatch()
    {
        try {
            $route = $this->getRoute();
            if (!isset($route['controller'])) {
                throw new \Exception("A URL não pode ser processada.", 500);
            }

            $args = [];

            return call_user_func_array($route['controller'], $args);
        } catch (\Exception $e) {
            return new Response($e->getCode(), $e->getMessage());            
        }
    }

}