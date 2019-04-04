<?php

namespace TestApp\Controllers;

use TestApp\Models\Test;
use TestApp\Models\Answer;
use TestApp\Models\User;

class AdminTestResultsController extends Controller {

    public function get($request, $response, $args) {

        $test = Test::find((int)$args['id']);
        $answers = Answer::where('test_id', $test->id)->get();
        $user_ids = $answers->pluck('user_id');
        $users = User::whereIn('id', $user_ids)->get();
        $this->view->getEnvironment()->addGlobal('results', [
            'test' => $test,
            'users' => $users,
            'answers' => $answers
        ]);
        return $this->view->render($response, 'admin_test_results.twig');
    }

    public function post($request, $response, $args) {
        $answer = Answer::where('user_id', $args['user_id'])->where('test_id', $args['test_id'])->first();
        $answer->allow_retake = 1;
        $answer->save();

        return $response->withRedirect($this->router->pathFor('test_results', ['id' => $args['test_id']]));
    }

}
