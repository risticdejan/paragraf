<?php

namespace Core\Router;

use Core\Request as Request;

class Router {

    private $routes = [];

    private $route404;

    public function get($pattern, $fn) {
        $this->match('GET', $pattern, $fn);
    }

    public function post($pattern, $fn) {
        $this->match('POST', $pattern, $fn);
    }

    private function match($methods, $pattern, $fn){
        $pattern = Request::getBasePath() . '/' . trim($pattern, '/');
        $pattern = Request::getBasePath() ? rtrim($pattern, '/') : $pattern;

        foreach (explode('|', $methods) as $method) {
            $this->routes[$method][] = [
                'pattern' => $pattern,
                'fn' => $fn
            ];
        }
    }

    public function run(){
        $requestedMethod = Request::getMethod();

        if (isset($this->routes[$requestedMethod])) {
            $this->handle($this->routes[$requestedMethod]);
        }
        
    }

    public function setRoute404($fn){
        $this->route404 = $fn;
    }

    private function handle($routes, $quitAfterRun = false) {
        $uri = Request::getUri();
 
        foreach ($routes as $route) {
            // Replace all curly braces matches {} into word patterns (like Laravel)
            $route['pattern'] = preg_replace('/\/{(.*?)}/', '/(.*?)', $route['pattern']);
            // we have a match!
            if (preg_match_all('#^' . $route['pattern'] . '$#', $uri, $matches, PREG_OFFSET_CAPTURE)) {
                $matches = array_slice($matches, 1);

                // Extract the matched URL parameters 
                $params = array_map(function ($match, $index) use ($matches) {
                    if (isset($matches[$index + 1]) && isset($matches[$index + 1][0]) && is_array($matches[$index + 1][0])) {
                        return trim(substr($match[0][0], 0, $matches[$index + 1][0][1] - $match[0][1]), '/');
                    } 
                    return isset($match[0][0]) ? trim($match[0][0], '/') : null;
                }, $matches, array_keys($matches));

               
                $this->invoke($route['fn'], $params);
            } else {
                $this->invoke($this->route404);
            }
        }
    }

    private function invoke($fn, $params = []) {
        if (is_callable($fn)) {
            call_user_func_array($fn, $params);
        } else if (stripos($fn, '@') !== false) {
            list($controller, $method) = explode('@', $fn);

            if (class_exists($controller)) {
                if (call_user_func_array([new $controller(), $method], $params) === false) {
                    if (forward_static_call_array([$controller, $method], $params) === false);
                }
            } else {
                if(DEBUG) { 
                    exit("There is no controller with name '".$controller."'.");
                }
            }
        } else {
            if(DEBUG) { 
                exit("It couldn't invoke any method.");
            }
        }
    } 
}


