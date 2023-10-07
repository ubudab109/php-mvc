<?php

namespace MVC;

class Router
{
    protected $routes = [];

    /**
     * The addRoute function adds a new route to the routes array with the specified controller and
     * action.
     * 
     * @param mixed $route The route parameter is a string that represents the URL pattern for the route. It
     * is used to match incoming requests to the appropriate controller and action.
     * @param string|mixed $controller The controller parameter refers to the name of the controller class that will
     * handle the request for the specified route. The controller class is responsible for processing
     * the request and returning the appropriate response.
     * @param string|mixed $action The action parameter refers to the specific method or function within the
     * controller that should be executed when the specified route is accessed.
     * @param string $method The action method.
     */
    public function addRoute($route, $controller, $action, $method = 'GET')
    {
        $this->routes[$route] = ['controller' => $controller, 'action' => $action, 'method' => $method];
    }

    /**
     * The dispatch function checks if a given URI exists in the routes array, and if so, it creates an
     * instance of the corresponding controller and calls the specified action.
     * 
     * @param string $uri The `` parameter is the Uniform Resource Identifier (URI) that is used to
     * determine which route to dispatch. It is a string that represents the path or endpoint that the
     * user is trying to access.
     * 
     * @throws \Exception
     */
    public function dispatch($uri, $serverMethod)
    {
        if (str_contains($uri, '?')) {
            $realUri = explode("?", $uri)[0];
        } else {
            $realUri = $uri;
        }
        if (array_key_exists($realUri, $this->routes)) {
            $controller = $this->routes[$realUri]['controller'];
            $action = $this->routes[$realUri]['action'];
            $method = $this->routes[$realUri]['method'];
            if (strtoupper($method) != strtoupper($serverMethod)) {
                throw new \Exception("Invalid method for this route. Correct method is : ". $method. " Instead : ". $serverMethod);
            }
            $controller = new $controller();
            $controller->$action();
        } else {
            throw new \Exception("No route found for URI: $realUri");
        }
    }
}