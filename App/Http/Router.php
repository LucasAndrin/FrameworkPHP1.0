<?php

namespace App\Http;

require_once 'vendor/autoload.php';

class Router
{

    private RequestInterface $request;

    private array $supportedHttpMethods = [
        "GET",
        "POST"
    ];

    function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    function __call(string $routeMethod, array $routeArguments): void
    {
        list($routePath, $method) = $routeArguments;

        $routeMethodUpperCase = strtoupper($routeMethod);
        $routeMethodLowerCase = strtolower($routeMethod);

        if (!in_array($routeMethodUpperCase, $this->supportedHttpMethods)) {
            $this->invalidMethodHandler($routeMethodUpperCase);
        }

        $this->{strtolower($routeMethodLowerCase)}[$this->formatRoute($routePath)] = $method;
    }

    /**
     * Remove barras à direita da rota
     * 
     * @param string
     * @return string
     */
    private function formatRoute(string $route): string
    {
        $route = rtrim($route, '/');

        if ($route === '') {
            return '/';
        }

        return $route;
    }

    private function invalidMethodHandler(string $methodName): void
    {
        header("{$this->request->serverProtocol} 405 Method $methodName Not Allowed");
    }

    private function defaultRequestHandler(): void
    {
        header("{$this->request->serverProtocol} 404 Not Found");
    }

    private function resolve(): void
    {
        $methodDictionary = $this->{strtolower($this->request->requestMethod)};

        $formatedRoute = $this->formatRoute($this->request->requestUri);

        if (!array_key_exists($formatedRoute, $methodDictionary)) {
            $this->defaultRequestHandler();
        }

        $classMethod = $methodDictionary[$formatedRoute];
        if (is_array($classMethod) && array_key_exists(0, $classMethod)) {
            if (is_string($classMethod[0])) {
                $classMethod[0] = new $classMethod[0];
            }
        }

        echo call_user_func_array($methodDictionary[$formatedRoute], [$this->request]);
    }

    function __destruct()
    {
        $this->resolve();
    }
}
