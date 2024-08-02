<?php
require_once 'Account.php';

class User extends Account {
    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }
}
?>