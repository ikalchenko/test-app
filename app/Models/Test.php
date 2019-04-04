<?php

namespace TestApp\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model {
    protected $table = 'test';
    protected $fillable = [
        'title',
        'description',
        'is_active'
    ];

    public function active() {
        return $this->is_active === 1;
    }

}