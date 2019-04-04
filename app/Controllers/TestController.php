<?php

namespace TestApp\Controllers;

use TestApp\Models\Test;
use TestApp\Models\Question;
use TestApp\Models\Option;
use TestApp\Models\Answer;

class TestController extends Controller
{

    public function testList($request, $response)
    {
        $answers = Answer::where('user_id', $_SESSION['user'])->where('allow_retake', 0)->pluck('test_id')->toArray();
        $tests = Test::whereNotIn('id', $answers)->get();
        $this->view->getEnvironment()->addGlobal('tests', $tests);
        return $this->view->render($response, 'test_list.twig');
    }

    public function showTest($request, $response, $args)
    {
        $old_answer = Answer::where('user_id', $_SESSION['user'])->where('test_id', (int)$args['id'])->first();
        if (!$old_answer or $old_answer->allow_retake == 1) {
            $test = Test::findOrFail((int)$args['id']);
            $questions = Question::where('test_id', $test->id)->get();
            $question_ids = $questions->pluck('id')->toArray();
            $options = Option::whereIn('question_id', $question_ids)->get();

            $this->view->getEnvironment()->addGlobal('test', [
                'test' => $test,
                'questions' => $questions,
                'options' => $options
            ]);
            return $this->view->render($response, 'test_view.twig');
        }
        return $response->withRedirect($this->router->pathFor('test_list'));

    }

    public function checkTest($request, $response, $args)
    {
        $answers_raw = $request->getParams();
        unset($answers_raw['_name']);
        unset($answers_raw['_value']);
        $answers = [];
        foreach ($answers_raw as $q_o => $st) {
            array_push($answers, $q_o);
        }
        $answers = array_unique($answers);

        $test = Test::find((int)$args['id']);
        $questions = Question::where('test_id', $test->id)->get();
        $question_ids = $questions->pluck('id')->toArray();
        $options = Option::where('is_correct', '=', 1)->whereIn('question_id', $question_ids)->get()->toArray();

        $correct_answers = [];
        foreach ($options as $option) {
            array_push($correct_answers, $option['question_id'] . '_' . $option['id']);
        }
        $correct_answers = array_unique($correct_answers);

        $incorrect_checked = array_diff($answers, $correct_answers);

        $failed_questions = [];
        foreach ($incorrect_checked as $ic) {
            array_push($failed_questions, explode('_', $ic)[0]);
        }
        $failed_questions = array_unique($failed_questions);

        $clear_answers = [];
        foreach ($answers as $ans) {
            $ans_question = explode('_', $ans)[0];
            if (!in_array($ans_question, $failed_questions)) {
                array_push($clear_answers, $ans);
            }
        }
        $options_cnt = sizeof($options);
        $correct_cnt = sizeof($clear_answers);

        $percentage = ($correct_cnt * 100) / $options_cnt;

        if ($percentage >= 90) {
            $mark = 5;
        } elseif ($percentage >= 75) {
            $mark = 4;
        } elseif ($percentage >= 50) {
            $mark = 3;
        } else {
            $mark = 2;
        }
        $answer = Answer::where('test_id', (int)$args['id'])->where('user_id', $_SESSION['user'])->first();
        if ($answer) {
            $answer->mark = $mark;
            $answer->allow_retake = 0;
            $answer->save();
            return $this->view->render($response, 'test_success.twig', ['mark' => $mark, 'answer' => $answer]);
        }
        $answer = Answer::create([
            'test_id' => $test->id,
            'user_id' => $_SESSION['user'],
            'mark' => $mark,
            'allow_retake' => 0
        ]);
        return $this->view->render($response, 'test_success.twig', ['mark' => $mark, 'answer' => $answer]);
    }
}

