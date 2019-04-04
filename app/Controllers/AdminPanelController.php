<?php

namespace TestApp\Controllers;

use TestApp\Models\Test;

class AdminPanelController extends Controller {

    public function get($request, $response) {

        $tests = Test::all();
        $this->view->getEnvironment()->addGlobal('tests', $tests);
        return $this->view->render($response, 'admin.twig');
    }

}
