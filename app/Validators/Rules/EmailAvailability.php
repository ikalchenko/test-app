<?php

namespace TestApp\Validators\Rules;

use TestApp\Models\User;
use Respect\Validation\Rules\AbstractRule;

class EmailAvailability extends AbstractRule {

    public function validate($input) {
        return User::where('email', $input)->count() === 0;
    }
}