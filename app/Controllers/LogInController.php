<?php

namespace TestApp\Controllers;

use TestApp\Models\User;

class LogInController extends Controller {

    public function get($request, $response) {

        return $this->view->render($response, 'login.twig');
    }

    public function post($request, $response) {

        $is_authenticated = $this->auth->attempt($request->getParam('email'), $request->getParam('password'));
        if ($is_authenticated) {
            return $response->withRedirect($this->router->pathFor('home'));
        }
        return $response->withRedirect($this->router->pathFor('login'));

    }
}
