<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../app/core/Database.php';
require_once __DIR__ . '/../../app/models/Reservation.php';

class BookingControllerTest extends TestCase {
    private $dbConnection;

    protected function setUp(): void {
        $dbInstance = Database::getInstance();
        $this->dbConnection = $dbInstance->getConnection();
    }

    public function testBookSlot() {
        // Simulate session
        $_SESSION['userId'] = 1;

        // Mock POST data
        $_POST['action'] = 'book';
        $_POST['slot_id'] = 1;

        // Mock the Reservation model
        $mockReservation = $this->createMock(Reservation::class);
        $mockReservation->method('bookSlot')->willReturn(true);

        // Override the Reservation instance with the mock
        $GLOBALS['reservationModel'] = $mockReservation;

        // Start output buffering
        ob_start();
        require __DIR__ . '/../controllers/BookingController.php';
        ob_end_clean();

        // Check if the session message and redirect are correct
        $this->assertEquals("Slot booked successfully!", $_SESSION['message']);
        $this->assertStringContainsString('manage.php', xdebug_get_headers()[0]);
    }

    public function testBookSlotAlreadyBooked() {
        // Simulate session
        $_SESSION['userId'] = 1;

        // Mock POST data
        $_POST['action'] = 'book';
        $_POST['slot_id'] = 1;

        // Mock the Reservation model
        $mockReservation = $this->createMock(Reservation::class);
        $mockReservation->method('bookSlot')->willReturn(false);

        // Override the Reservation instance with the mock
        $GLOBALS['reservationModel'] = $mockReservation;

        // Start output buffering
        ob_start();
        require __DIR__ . '/../controllers/BookingController.php';
        ob_end_clean();

        // Check if the session message and redirect are correct
        $this->assertEquals("This slot was already booked.", $_SESSION['message']);
        $this->assertStringContainsString('browse.php', xdebug_get_headers()[0]);
    }

    protected function tearDown(): void {
        $_SESSION = [];
        $_POST = [];
    }
}
?>