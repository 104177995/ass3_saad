<?php
require '../../core/Database.php';
require '../../models/ParkingSlot.php';
require '../../models/Reservation.php';
require '../../core/Middleware.php';
checkLogin();
$userId = $_SESSION['userId'];
// Get the Database instance and connection
$dbInstance = Database::getInstance();
$dbConnection = $dbInstance->getConnection();
// Create a ParkingSlot instance and get all slots
$parkingSlotModel = new ParkingSlot($dbConnection);
$parkingSlots = $parkingSlotModel->getAllSlots();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../public/css/style.css">
    <title>OSPS - Browse</title>
</head>
<body>
    <nav>
        <ul>
            <li><a class="active" href="browse.php">Home</a></li>
            <li><a href="../managing/manage.php">Managing Parking Slots</a></li>
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
        <?php foreach ($parkingSlots as $slot): ?>
            <div class="card">
                <img src="<?php echo htmlspecialchars($slot['imageSlot']); ?>" alt="Parking Slot Image">
                <h3><?php echo htmlspecialchars($slot['timeSlot']); ?></h2>
                <p><?php echo htmlspecialchars($slot['loc']); ?></p>
                <p><?php echo htmlspecialchars($slot['vehicleType']); ?></p>
                <p>Slot Number: <?php echo htmlspecialchars($slot['lotNumber']); ?></p>
                <form action="../../controllers/BookingController.php" method="POST">
                    <input type="hidden" name="slot_id" value="<?php echo htmlspecialchars($slot['lotNumber']); ?>">
                    <button type="submit" name="action" value="book" class="bookBut">Book a slot</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>