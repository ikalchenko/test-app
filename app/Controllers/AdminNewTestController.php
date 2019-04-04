<?php

namespace TestApp\Controllers;

use TestApp\Models\Test;

class AdminNewTestController extends Controller {

    public function get($request, $response) {

        return $this->view->render($response, 'add_test.twig');
    }

    public function post($request, $response) {
        $test_raw = $request->getParams();
        $test = Test::create([
            'title' => $test_raw['test_title'],
            'description' => $test_raw['test_description']
        ]);

        return $response->withRedirect($this->router->pathFor('add_question', ['id' => $test->id]));
    }
}
