<?php
function checkLogin() {
    session_start();
    if (!isset($_SESSION['userId'])) {
        $_SESSION['message'] = 'You must log in first';
        header("Location: ../auth/authenticate.php");
        exit();
    }
}
?>