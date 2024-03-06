<?php
session_start();
error_reporting(0); // Enable error reporting for debugging
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_GET['booking_id']) && isset($_GET['action']) && $_GET['action'] == 'cancel') {
        $booking_id = intval($_GET['booking_id']);
        $status = "Cancelled"; // Set status to Cancelled

        try {
            // Update the status in the database
            $sql = "UPDATE bookings SET status=:status WHERE booking_id=:booking_id";
            $query = $dbh->prepare($sql);
            $query->bindParam(':status', $status, PDO::PARAM_STR);
            $query->bindParam(':booking_id', $booking_id, PDO::PARAM_STR);
            $query->execute();

            // Check if the query was successful
            if ($query->rowCount() > 0) {
                // Redirect back to the booking management page with a success message
                $msg = "Booking Successfully Cancelled";
                header("Location: manage-bookings.php?msg=$msg");
                exit;
            } else {
                // Handle the case where the query didn't affect any rows (no matching booking ID)
                $msg = "No Booking Found for Cancellation";
                header("Location: manage-bookings.php?msg=$msg");
                exit;
            }
        } catch (PDOException $e) {
            // Handle database errors
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
