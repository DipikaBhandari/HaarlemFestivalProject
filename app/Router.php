<?php

namespace App;
class Router
{
    private function stripParameters($uri)
    {
        if (str_contains($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }
        return $uri;
    }

    public function route($uri)
    {
        $uri = $this->stripParameters($uri);
        $uriNoLeading = ltrim($uri, '/');
        $explodedUri = explode('/', $uriNoLeading);
        if (!isset($explodedUri[0]) || empty($explodedUri[0])) {
            $explodedUri[0] = 'home';
        }
        $controllerName = "App\\Controllers\\" . $explodedUri[0] . "Controller";

        if (!isset($explodedUri[1]) || empty($explodedUri[1])) {
            $explodedUri[1] = 'index';
        }
        $methodName = $explodedUri[1];

        // Controller/method matching the URL not found
        if (!class_exists($controllerName) || !method_exists($controllerName, $methodName)) {
            http_response_code(404);
            return;
        }

        try {
            $controllerObj = new $controllerName();
            $controllerObj->$methodName();
        } catch (\App\Error $e) {
            // For some reason the class/method doesn't work
            http_response_code(500);
        }
    }
}