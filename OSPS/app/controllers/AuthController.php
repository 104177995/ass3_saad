<?php
require_once '../core/Database.php';
require_once '../models/Customer.php';
require_once '../interfaces/Authentication.php';
session_start();

class AuthController implements Authentication {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function signUp(Account $account) {
        // Check if email already exists
        $checkQuery = "SELECT COUNT(*) FROM users WHERE email = :email";
        $checkStmt = $this->db->prepare($checkQuery);
        $checkStmt->bindValue(':email', $account->getEmail());
        $checkStmt->execute();
        $emailExists = $checkStmt->fetchColumn() > 0;

        if ($emailExists) {
            $_SESSION['message'] = 'Error: Email already exists';
            return;
        }

        // Proceed with account creation
        $query = "INSERT INTO users (email, pwd) VALUES (:email, :password)";
        $stmt = $this->db->prepare($query);
        if ($stmt) {
            $stmt->bindValue(':email', $account->getEmail());
            $stmt->bindValue(':password', $account->getPassword());
            if ($stmt->execute()) {
                $_SESSION['message'] = 'Account created: ' . $account->getEmail();
            } else {
                $_SESSION['message'] = 'Error: ' . $stmt->errorInfo()[2];
            }
        } else {
            $_SESSION['message'] = 'Error preparing statement: ' . $this->db->errorInfo()[2];
        }
    }

    public function signIn($email, $password) {
        $query = "SELECT userID, pwd FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        if ($stmt) {
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $userId = $result['userID'];
                $storedPassword = $result['pwd'];
                if ($password === $storedPassword) {
                    $_SESSION['userId'] = $userId;
                    $_SESSION['message'] = 'Sign in successful: ' . $email;
                    header("Location: ../views/browsing/browse.php");
                    exit();
                } else {
                    $_SESSION['message'] = 'Sign in failed: Invalid email or password';
                }
            } else {
                $_SESSION['message'] = 'Sign in failed: Invalid email or password';
            }
        } else {
            $_SESSION['message'] = 'Error preparing statement: ' . $this->db->errorInfo()[2];
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: ../views/auth/authenticate.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $action = $_POST['action'];
    $authController = new AuthController();
    $customer = new Customer($email, $password);
    if ($action === 'sign-up') {
        $authController->signUp($customer);
    } elseif ($action === 'sign-in') {
        $authController->signIn($email, $password);
    } elseif ($action === 'logout') {
        $authController->logout();
    }
    header("Location: ../views/auth/authenticate.php");
    exit();
}
?>