<?php
require '../../core/Database.php';
require '../../models/ParkingSlot.php';
require '../../models/Reservation.php';
require '../../core/Middleware.php';
checkLogin();
// Get the Database instance and connection
$dbInstance = Database::getInstance();
$dbConnection = $dbInstance->getConnection();
// Create a Reservation instance and get slots booked by the current user
$reservationModel = new Reservation($dbConnection);
$userId = $_SESSION['userId'];
$bookedSlots = $reservationModel->getSlotsByUser($userId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../public/css/style.css">
    <title>OSPS - Manage</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="../browsing/browse.php">Home</a></li>
            <li><a class="active" href="manage.php">Managing Parking Slots</a></li>
            <li>
                <form action="../../controllers/AuthController.php" method="POST" style="display:inline;">
                    <button type="submit" name="action" value="logout">Log Out</button>
                </form>
            </li>
        </ul>
    </nav>
    <div class="container">
        <?php
        if (isset($_SESSION['message'])) {
            echo '<script>alert("' . htmlspecialchars($_SESSION['message']) . '");</script>';
            unset($_SESSION['message']);
        }
        ?>
        <?php if (empty($bookedSlots)): ?>
            <p>No slots booked by you.</p>
        <?php else: ?>
            <?php foreach ($bookedSlots as $slot): ?>
                <div class="card" id="book">
                    <img src="<?php echo htmlspecialchars($slot['imageSlot']); ?>" alt="Parking Slot Image">
                    <h3><?php echo htmlspecialchars($slot['timeSlot']); ?></h3>
                    <p><?php echo htmlspecialchars($slot['loc']); ?></p>
                    <p><?php echo htmlspecialchars($slot['vehicleType']); ?></p>
                    <p>Lot Number: <?php echo htmlspecialchars($slot['lotNumber']); ?></p>
                    <p>Booked By: <?php echo htmlspecialchars($slot['userID']); ?></p>
                    <button type="submit" name="action" value="delete" class="bookBut" id="can">Cancel reservation</button>
                    <button type="submit" name="action" value="pay" class="bookBut" id="pay">Make a payment</button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>