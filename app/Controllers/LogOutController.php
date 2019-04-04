<?php

namespace TestApp\Controllers;

use TestApp\Models\User;

class LogOutController extends Controller {

    public function get($request, $response) {

        $this->auth->logout();
        return $response->withRedirect($this->router->pathFor('login'));
    }

}
