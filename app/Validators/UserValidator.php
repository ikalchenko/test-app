<?php

namespace TestApp\Validators;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class UserValidator {

    protected  $rules;
    protected  $errors;

    public function __construct() {
        $rus_alpha = 'АаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя';
        $this->rules = [
            'last_name' => v::notEmpty()->alpha($rus_alpha),
            'first_name' => v::notEmpty()->alpha($rus_alpha),
            'email' => v::notEmpty()->noWhitespace()->email()->emailAvailability(),
            'password' => v::notEmpty()->noWhitespace()
        ];
    }

    public function is_valid($request) {
        foreach ($this->rules as $field => $rule) {
            try {
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            } catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages();
            }
        }
        $_SESSION['validation_errors'] = $this->errors;
        return empty($this->errors);


    }
}