<?php

namespace TestApp\Controllers;

use TestApp\Models\Answer;
use TestApp\Models\Test;

class CertificateController extends Controller {

    public function showList($request, $response) {

        $answ = Answer::where('user_id', $_SESSION['user'])->get();
        $tests = Test::whereIn('id', $answ->pluck('test_id')->toArray())->get();
        $this->view->getEnvironment()->addGlobal('data', ['certificates'=> $answ,'tests' => $tests]);

        return $this->view->render($response, 'cert_list.twig');
    }
}
