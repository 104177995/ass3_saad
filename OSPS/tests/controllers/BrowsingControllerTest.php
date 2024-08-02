<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../app/models/ParkingSlot.php';
require_once __DIR__ . '/../../app/core/Database.php';
require_once __DIR__ . '/../../app/controllers/BrowsingController.php';

class BrowsingControllerTest extends TestCase {
    private $browsingController;
    private $dbConnection;

    protected function setUp(): void {
        $dbInstance = Database::getInstance();
        $this->dbConnection = $dbInstance->getConnection();
        $this->browsingController = new BrowsingController();
    }

    public function testIndex() {
        // Mock the ParkingSlot model
        $mockParkingSlot = $this->createMock(ParkingSlot::class);
        $mockParkingSlot->method('getAllSlots')->willReturn([
            ['id' => 1, 'location' => 'A1'],
            ['id' => 2, 'location' => 'A2']
        ]);

        // Override the parkingSlotModel with the mock
        $this->browsingController->parkingSlotModel = $mockParkingSlot;

        // Start output buffering
        ob_start();
        $this->browsingController->index();
        $output = ob_get_clean();

        // Check if the view was included
        $this->assertStringContainsString('browse.php', $output);
    }
}
?>