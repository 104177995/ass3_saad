<?php
class Reservation {
    private $conn;
    private $table = 'parkingslots';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function bookSlot($slotId, $userId) {
        // Check if the slot is already booked
        $checkQuery = "SELECT userID FROM " . $this->table . " WHERE lotNumber = :slotId";
        $checkStmt = $this->conn->prepare($checkQuery);
        $checkStmt->bindValue(':slotId', $slotId, PDO::PARAM_INT);
        $checkStmt->execute();
        $slot = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($slot && $slot['userID'] !== null) {
            // Slot is already booked by another user
            return false;
        }

        // Proceed to book the slot
        $query = "UPDATE " . $this->table . " SET userID = :userId WHERE lotNumber = :slotId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':slotId', $slotId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getSlotsByUser($userId) {
        $query = "SELECT * FROM " . $this->table . " WHERE userID = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>