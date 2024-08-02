<?php
abstract class Account {
    protected $email;
    protected $password;

    public function __construct($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }

    abstract public function getEmail();
    abstract public function getPassword();
}
?>