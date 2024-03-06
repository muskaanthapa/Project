<!DOCTYPE html>
<html>
<head>
    <title>Online Car Rental</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<?php
session_start();
if(!$_SESSION['username']){
    header("location:index.php");
}
?><style>
body {
    background-color: black;
    color: white; /* Added */
}
.text {
    font-family: Helvetica;
    color: #ff3300;
}
.slider {
    width: 300px;
    height: 300px;
    margin: auto;
}
.container {
    width: 80%;
    background-color: black;
    text-align: center;
    margin: auto;
    padding: 10px;
}
a {
    text-decoration: none;
}
.cards-wrapper {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: flex-start;
}
.card {
    width: calc(25% - 20px);
    background-color: black; /* Updated */
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    padding: 20px;
    margin-right: 20px;
    text-align: center;
    cursor: pointer; /* Added */
}
.card img {
    width: 100%;
    height: auto;
    border-radius: 5px;
    margin-bottom: 10px;
}
.card h3 {
    font-size: 18px;
    margin-bottom: 10px;
    color: white; /* Added */
}
.card p {
    font-size: 14px;
    color: #888;
}

@media (max-width: 992px) {
    .container {
        width: 100%;
        padding: 0 10px;
    }
    .card {
        width: calc(50% - 20px);
        margin-right: 20px;
        margin-bottom: 20px;
    }
    .card:nth-child(2n) {
        margin-right: 0;
    }
}

@media (max-width: 768px) {
    .card {
        width: 100%;
        margin-right: 0;
    }
}
</style>

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

<!-- Car Cards -->
<div class="container">
        <div class="cards-wrapper">
            <?php
            include('connect.php');
            $sql = "SELECT * FROM cars";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            if ($query->rowCount() > 0) {
                foreach ($results as $result) {
                    ?>
                    <a href="bookacar.php?id=<?php echo $result->id; ?>" class="card">
                        <div class="card-content">
                            <img src="admin/img/carimages/<?php echo htmlentities($result->Cimage1);?>" alt="Car Image">
                            <h3><?php echo htmlentities($result->CarsBrand);?></h3>
                            <p><?php echo htmlentities($result->CarsOverview);?></p>
                            <p>Price Per Day: <?php echo htmlentities($result->PricePerDay);?></p>
                            <p>Fuel Type: <?php echo htmlentities($result->FuelType);?></p>
                            <p>Model Year: <?php echo htmlentities($result->ModelYear);?></p>
                            <p>Chasis No: <?php echo htmlentities($result->chasis_no);?></p>
                            <p>Reg No: <?php echo htmlentities($result->reg_no);?></p>
                            <p>Seating Capacity: <?php echo htmlentities($result->SeatingCapacity);?></p>
                        </div>
                    </a>
                    <?php
                }
            } else {
                ?>
                <div class="col-md-12">
                    <div class="alert alert-warning">No cars found.</div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <script>
        // JavaScript code to handle card click event and redirect to bookacar.php
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.addEventListener('click', () => {
                const carId = card.dataset.carId;
                window.location.href = `bookacar.php?id=${carId}`;
            });
        });
    </script>


</body>
</html>
