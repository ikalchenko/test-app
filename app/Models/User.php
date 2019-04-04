<?php

namespace TestApp\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
    protected $table = 'user';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'is_admin'
    ];

    public function isAdmin() {
        return $this->is_admin === 1;
    }

    public function fullName() {
        return $this->first_name . ' ' . $this->last_name;
    }

}
