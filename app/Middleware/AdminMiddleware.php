<?php

namespace TestApp\Middleware;

class AdminMiddleware extends Middleware {

    public function __invoke($request, $response, $next) {

        if (!$this->auth->user()->isAdmin()) {
            return $response->withRedirect($this->router->pathFor('home'));
        }
        $response = $next($request, $response);
        return $response;
    }
}