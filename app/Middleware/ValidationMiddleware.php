<?php

namespace TestApp\Middleware;

class ValidationMiddleware extends Middleware {

    public function __invoke($request, $response, $next) {

        $this->view->getEnvironment()->addGlobal('errors', $_SESSION['validation_errors']);
        unset($_SESSION['validation_errors']);

        $response = $next($request, $response);
        return $response;
    }
}