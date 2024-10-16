<?php

declare(strict_types=1);

class Router {

    private array $routes = [];

    public function add(string $method, string $path, array $controller) {
        $path = $this->normalizePath($path);
        $this->routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller,
            'middlewares' => []
        ];
    }

    private function normalizePath(string $path): string {
        $path = trim($path, '/');
        return "/{$path}";
    }

    public function dispatch(string $path): void
    {
        $path = $this->normalizePath($path);
        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        foreach ($this->routes as $route) {
            if (
                !preg_match("#^{$route['path']}$#", $path) ||
                $route['method'] !== $method
            ) {
                continue;
            }

            [$class, $function] = $route['controller'];

            $controllerInstance = new $class;

            foreach ($route['middlewares'] as $middleware) {
                $middleware();
            }

            $controllerInstance->{$function}();
            return;
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}
