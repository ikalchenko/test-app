<?php

namespace TestApp\Controllers;

use TestApp\Models\Test;

class AdminTestActivationController extends Controller {

    public function activate($request, $response, $args) {

        $test = Test::findOrFail($args['id']);
        $test->is_active = 1;
        $test->save();

        return $response->withRedirect($this->router->pathFor('admin'));
    }

    public function deactivate($request, $response, $args) {

        $test = Test::findOrFail($args['id']);
        $test->is_active = 0;
        $test->save();

        return $response->withRedirect($this->router->pathFor('admin'));
    }
}
