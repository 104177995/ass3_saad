<?php
class ParkingSlot {
    private $conn;
    private $table = 'parkingslots';
    public function __construct($db) {
        $this->conn = $db;
    }
    public function getAllSlots() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>