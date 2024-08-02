<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../app/core/Database.php';
require_once __DIR__ . '/../../app/models/User.php';
require_once __DIR__ . '/../../app/interfaces/Authentication.php';
require_once __DIR__ . '/../../app/controllers/AuthController.php';

class AuthControllerTest extends TestCase {
    private $authController;
    private $dbConnection;

    protected function setUp(): void {
        $dbInstance = Database::getInstance();
        $this->dbConnection = $dbInstance->getConnection();
        $this->authController = new AuthController();
    }

    public function testSignUp() {
        // Simulate user input
        $email = 'testuser@example.com';
        $password = 'testpassword';

        // Create a user account
        $user = new User($email, $password);

        // Call the sign-up method
        $this->authController->signUp($user);

        // Check if the user was added to the database
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotEmpty($result);
        $this->assertEquals($email, $result['email']);

        // Clean up
        $this->dbConnection->prepare("DELETE FROM users WHERE email = :email")
                           ->execute([':email' => $email]);
    }

    public function testSignIn() {
        // Add a test user to the database
        $email = 'testuser@example.com';
        $password = 'testpassword';

        // Insert the user without hashing the password
        $this->dbConnection->prepare("INSERT INTO users (email, pwd) VALUES (:email, :pwd)")
                           ->execute([':email' => $email, ':pwd' => $password]);

        // Call the sign-in method
        ob_start();
        $this->authController->signIn($email, $password);
        ob_end_clean();

        // Check if the user was signed in successfully
        $this->assertNotEmpty($_SESSION['userId'], "User ID should not be empty after successful sign-in.");
        $this->assertStringContainsString('Sign in successful', $_SESSION['message']);

        // Clean up
        $this->dbConnection->prepare("DELETE FROM users WHERE email = :email")
                           ->execute([':email' => $email]);
    }

    protected function tearDown(): void {
        $_SESSION = [];
    }
}
?>
?>