<?php

namespace TestApp\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model {
    protected $table = 'question';
    protected $fillable = [
        'text',
        'detail',
        'test_id'
    ];

}