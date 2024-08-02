<?php
require_once '../models/ParkingSlot.php';
require_once '../models/Database.php'; 

class BrowsingController {
    private $parkingSlotModel;

    public function __construct() {
        $dbInstance = Database::getInstance(); 
        $dbConnection = $dbInstance->getConnection(); 
        $this->parkingSlotModel = new ParkingSlot($dbConnection);
    }

    public function index() {
        $slots = $this->parkingSlotModel->getAllSlots();
        require '../views/browsing/browse.php';
    }
}
?>