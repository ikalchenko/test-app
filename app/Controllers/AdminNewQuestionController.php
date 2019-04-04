<?php

namespace TestApp\Controllers;

use TestApp\Models\Option;
use TestApp\Models\Question;
use TestApp\Models\Test;

class AdminNewQuestionController extends Controller {

    public function get($request, $response, $args) {

        $test = Test::findOrFail($args['id']);
        $this->view->getEnvironment()->addGlobal('test', $test);

        return $this->view->render($response, 'add_question.twig');
    }

    public function post($request, $response, $args) {
        $question_raw = $request->getParams();

        $options = [];
        $checks = [];
        foreach ($question_raw as $key => $value) {
            $splitted_value = explode('_', $key);
            if (in_array('option', $splitted_value)) {
                $options[$splitted_value[1]] = $value;
            }
            if (in_array('check', $splitted_value)) {
                $checks[$splitted_value[1]] = $value;
            }
        }

        $question = Question::create([
            'text' => $question_raw['question'],
            'detail' => $question_raw['detail'],
            'test_id' => $args['id']
        ]);
        $new_options = [];

        foreach ($options as $option_num => $option) {
            if ($option != '') {
                array_push($new_options, [
                    'text' => $option,
                    'question_id' => $question->id,
                    'is_correct' => array_key_exists($option_num, $checks) ? 1 : 0]);
            }
        }

        Option::insert($new_options);
        return $response->withRedirect($this->router->pathFor('add_question', ['id' => $args['id']]));
    }
}
