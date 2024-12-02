<?php
// index.php

// Define the late fee calculation logic
$lateFee = 0;
$lateDays = 0;
$error = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservationId = $_POST['reservation_id'] ?? null;

    // If reservation ID is provided, calculate late fee
    if ($reservationId) {
        // Sample logic: calculate late days and fee (for demo purposes)
        $dueDate = new DateTime('2024-11-25');  // Sample due date
        $returnDate = new DateTime();           // Current date as return date
        $lateDays = $dueDate->diff($returnDate)->days;
        
        if ($lateDays > 0) {
            $lateFee = $lateDays * 5;  // Fee: $5 per day
        } else {
            $lateDays = 0;
            $lateFee = 0;
        }
    } else {
        $error = "Please provide a reservation ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Late Fee Calculator</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Late Fee Calculator</h1>
        <p>Enter the reservation ID to calculate the late fee for overdue book returns.</p>

        <!-- Form to calculate late fee -->
        <form action="index.php" method="POST">
            <label for="reservation_id">Reservation ID:</label>
            <input type="number" id="reservation_id" name="reservation_id" required placeholder="Enter Reservation ID">
            <button type="submit">Calculate</button>
        </form>

        <!-- Feedback for the user -->
        <div id="feedback">
            <?php if ($error): ?>
                <p class="error"><?= htmlspecialchars($error); ?></p>
            <?php elseif ($lateDays > 0): ?>
                <p class="success">Late Days: <?= htmlspecialchars($lateDays); ?></p>
                <p class="success">Late Fee: $<?= htmlspecialchars($lateFee); ?></p>
            <?php else: ?>
                <p class="success">No late fee. Return on time!</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
