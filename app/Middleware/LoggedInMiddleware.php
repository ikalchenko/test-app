<?php

namespace TestApp\Middleware;

class LoggedInMiddleware extends Middleware {

    public function __invoke($request, $response, $next) {

        if (!$this->auth->is_authenticated()) {
            return $response->withRedirect($this->router->pathFor('login'));
        }
        $response = $next($request, $response);
        return $response;
    }
}