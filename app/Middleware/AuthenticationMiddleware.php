<?php

namespace TestApp\Middleware;

class AuthenticationMiddleware extends Middleware {

    public function __invoke($request, $response, $next) {

        if ($this->auth->is_authenticated()) {
            $this->view->getEnvironment()->addGlobal('auth', [
                'user' => $this->auth->user()
            ]);
        }
        $response = $next($request, $response);
        return $response;
    }
}