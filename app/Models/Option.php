<?php

namespace TestApp\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model {
    protected $table = 'option';
    protected $fillable = [
        'text',
        'question_id',
        'is_correct'
    ];

}