<?php

namespace TestApp\Authentication;

use TestApp\Models\User;

class Authentication {

    public function user()
    {
        if ($this->is_authenticated()) {
            return User::find($_SESSION['user']);
        }
        return null;
    }

    public function is_authenticated() {
        return isset($_SESSION['user']);
    }

    public function attempt($email, $password) {
        $user = User::where('email', $email)->first();
        if (!$user) {
            return false;
        }
        if (password_verify($password, $user->password)) {
            $_SESSION['user'] = $user->id;
            return true;
        }
        return false;
    }

    public function logout() {
        unset($_SESSION['user']);
    }
}
