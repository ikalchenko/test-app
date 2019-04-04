<?php

namespace TestApp\Validators\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class EmailAvailabilityException extends ValidationException {

    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Email is already taken'
        ]
    ];
}