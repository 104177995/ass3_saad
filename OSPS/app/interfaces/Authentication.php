<?php
interface Authentication {
    public function signUp(Account $account);
    public function signIn($email, $password);
    public function logout();
}
?>