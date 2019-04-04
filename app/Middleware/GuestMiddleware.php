<?php

namespace TestApp\Middleware;

class GuestMiddleware extends Middleware {

    public function __invoke($request, $response, $next) {

        if ($this->auth->is_authenticated()) {
            return $response->withRedirect($this->router->pathFor('home'));
        }
        $response = $next($request, $response);
        return $response;
    }
}