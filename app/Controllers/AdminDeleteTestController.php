<?php

namespace TestApp\Controllers;

use TestApp\Models\Test;

class AdminDeleteTestController extends Controller {

    public function get($request, $response, $args) {

        $test = Test::findOrFail($args['id']);
        $this->view->getEnvironment()->addGlobal('test', $test);

        return $this->view->render($response, 'delete_confirmation.twig');
    }

    public function post($request, $response, $args) {

        Test::findOrFail($args['id'])->delete();

        return $response->withRedirect($this->router->pathFor('admin'));
    }
}
