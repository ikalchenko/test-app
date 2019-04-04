<?php

namespace TestApp\Controllers;

use TestApp\Models\User;
use TestApp\Validators\UserValidator;

class SignUpController extends Controller {

    public function get($request, $response) {

        return $this->view->render($response, 'signup.twig');
    }

    public function post($request, $response) {
        $validator = new UserValidator();
        if ($validator->is_valid($request)) {
            $user = User::create([
                'first_name' => $request->getParam('first_name'),
                'last_name' => $request->getParam('last_name'),
                'email' => $request->getParam('email'),
                'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT)

            ]);

            $this->auth->attempt($user->email, $request->getParam('password'));
            return $response->withRedirect($this->router->pathFor('home'));
        }
        return $response->withRedirect($this->router->pathFor('signup'));

    }
}
