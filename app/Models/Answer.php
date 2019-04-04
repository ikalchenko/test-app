<?php

namespace TestApp\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model {
    protected $table = 'answer';
    protected $fillable = [
        'test_id',
        'user_id',
        'mark',
        'allow_retake'
    ];

}