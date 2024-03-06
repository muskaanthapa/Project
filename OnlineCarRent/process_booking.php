<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $reserve_date = $_POST['reserve_date'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $drop_location = $_POST['drop_location'];
    $pickup_location = $_POST['pickup_location'];
    $required_driver = $_POST['required_driver'];

    // Validate form data (you can add more validation as per your requirements)
    if (empty($name) || empty($reserve_date) || empty($start_date) || empty($end_date) || empty($drop_location) || empty($pickup_location) || empty($required_driver)) {
        // Handle validation errors (e.g., display an error message and redirect back to the booking form)
        echo "Error: All fields are required.";
        // You can use header("Location: bookacar.php"); to redirect back to the booking form.
        exit;
    }

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "carrent";

    try {
        // Create a new PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement to insert data into the bookings table
        $sql = "INSERT INTO bookings (Name, Reserve_date, Start_date, End_date, Drop_location, Pickup_location, Required_driver)
                VALUES (:name, :reserve_date, :start_date, :end_date, :drop_location, :pickup_location, :required_driver)";

        // Create a prepared statement
        $stmt = $conn->prepare($sql);

        // Bind the parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':reserve_date', $reserve_date);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->bindParam(':drop_location', $drop_location);
        $stmt->bindParam(':pickup_location', $pickup_location);
        $stmt->bindParam(':required_driver', $required_driver);

        // Execute the prepared statement
        $stmt->execute();

        // Close the connection
        $conn = null;

        // Redirect back to the booking form with a success message
       // header("Location: bookacar.php?success=1");
       echo '<p style="color: green;">Car booked successfully!</p>';
        header('Refresh: 3; url=booking.php');
        exit;
    } catch (PDOException $e) {
        // Handle database connection errors or query errors (e.g., display an error message)
        echo "Error: " . $e->getMessage();
        // You can use header("Location: bookacar.php"); to redirect back to the booking form.
        exit;
    }
} else {
    // If the form is not submitted directly to this file, redirect back to the booking form
    header("Location: bookacar.php");
    exit;
}
?>