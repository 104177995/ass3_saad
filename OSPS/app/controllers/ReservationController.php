<?php
require '../core/Database.php';
require '../models/Reservation.php';
require '../core/Middleware.php';

checkLogin();

// In ReservationController.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbInstance = Database::getInstance();
    $dbConnection = $dbInstance->getConnection();
    $reservationModel = new Reservation($dbConnection);

    if (isset($_POST['action']) && $_POST['action'] === 'cancel') {
        $slotId = $_POST['slotId'];
        $result = $reservationModel->cancelReservation($slotId);
        if ($result) {
            $_SESSION['message'] = 'Reservation cancelled successfully.';
        } else {
            $_SESSION['message'] = 'Failed to cancel reservation.';
        }
        // Debugging: Check if slotId is being correctly received
        error_log("Slot ID: $slotId");
        header('Location: ../views/managing/manage.php');
        exit();
    }
}

?>