<!DOCTYPE html>
<html lang="en">
<head>
    <title>Online Car Rental - Book a Car</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: black;
            color: white;
        }

        .container {
            width: 80%;
            background-color: black;
            text-align: center;
            margin: auto;
            padding: 10px;
            display: grid;
            grid-gap: 20px;
        }

        .booking-form {
            background-color: black;
            border-radius: 5px;
            padding: 20px;
            color: white;
            max-width: 400px;
            margin: auto;
        }

        .booking-form h2 {
            color: #ff8c00; /* Orange color */
        }

        .booking-form input,
        .booking-form select {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            background-color: white;
            color: black;
            border: none;
            padding: 10px;
            border-radius: 5px;
        }

        .booking-form button {
            background-color: #ff3300;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .booking-form button:hover {
            background-color: #e60000;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var currentDate = new Date().toISOString().split('T')[0];
            var dateInputs = document.querySelectorAll('input[type="date"]');
            
            for (var i = 0; i < dateInputs.length; i++) {
                dateInputs[i].setAttribute('min', currentDate);
            }
        });
    </script>
</head>
<body>
   <div class="menu">
        <ul>
            <li><a href="index1.php">HOME</a></li>
            <li><a href="About-us.html">About-us</a></li>
            <li><a href="booking.php">Booking</a></li>
            <li><a href="logout.php">logout</a></li>
            <li><a href="admin">admin</a></li>
        </ul>
    </div>
    <div class="container">
        <?php
         
        if (isset($_GET['id'])) {
            $carId = $_GET['id'];
            include('connect.php');
            $sql = "SELECT * FROM cars WHERE id = :carId";
            $query = $dbh->prepare($sql);
            $query->bindParam(':carId', $carId, PDO::PARAM_INT);
            $query->execute();
            $car = $query->fetch(PDO::FETCH_OBJ);
            if ($car) {
            
        ?>
        <div class="car-details">
                    <h2>Car Details</h2>
                    <img src="admin/img/carimages/<?php echo htmlentities($car->Cimage1); ?>" alt="Car Image">
                    <h3><?php echo htmlentities($car->CarsBrand); ?></h3>
                    <p><?php echo htmlentities($car->CarsOverview); ?></p>
                    <p>Price Per Day: <?php echo htmlentities($car->PricePerDay); ?></p>
                    <p>Fuel Type: <?php echo htmlentities($car->FuelType); ?></p>
                    <p>Model Year: <?php echo htmlentities($car->ModelYear); ?></p>
                    <p>Chassis No: <?php echo htmlentities($car->chasis_no); ?></p>
                    <p>Reg No: <?php echo htmlentities($car->reg_no); ?></p>
                    <p>Seating Capacity: <?php echo htmlentities($car->SeatingCapacity); ?></p>
                </div>
        <div class="row">
            <div class="col-md-6 offset-md-3 booking-form">
                <h2>Book Now</h2>
                <form action="process_booking.php" method="post">
    <!-- Simplified form fields -->
    <input type="text" name="name" placeholder="Name" required>
    <input type="date" name="reserve_date" placeholder="Reserve Date" required>
    <input type="date" name="start_date" placeholder="Start Date" required>
    <input type="date" name="end_date" placeholder="End Date" required>
    <input type="text" name="drop_location" placeholder="Drop Location" required>
    <input type="text" name="pickup_location" placeholder="Pickup Location" required>
    <select name="required_driver" required>
        <option value="yes">Yes, I need a driver</option>
        <option value="no">No, I don't need a driver</option>
    </select>
    <button type="submit">Book Now</button>
</form>
            </div>
        </div>
          <?php
            } else {
                echo "Car not found.";
            }
        } else {
            echo "Car ID not provided.";
        }
        ?>
    </div>
</body>
</html>
