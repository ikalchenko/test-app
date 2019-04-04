<?php

namespace TestApp\Controllers;

use TestApp\Models\User;

class HomeController extends Controller {

    public function index($request, $response) {

        $user = User::where('id', 1)->first();
        return $this->view->render($response, 'home.twig');
    }
}
