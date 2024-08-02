<?php
session_start();
require_once __DIR__ . '../core/Database.php';
require_once __DIR__ . '../models/Reservation.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'book') {
    $slotId = $_POST['slot_id'];
    $userId = $_SESSION['userId'];

    $dbInstance = Database::getInstance();
    $dbConnection = $dbInstance->getConnection();

    $parkingSlotModel = new Reservation($dbConnection);
    $result = $parkingSlotModel->bookSlot($slotId, $userId);

    if ($result) {
        $_SESSION['message'] = "Slot booked successfully!";
        header("Location: ../views/managing/manage.php");
    } else {
        $_SESSION['message'] = "This slot was already booked.";
        header('Location: ../views/browsing/browse.php');
    }
    exit();
}
?>