<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{
    header('location:index.php');
}
else {
    $limit = 20; // Number of items to display per page
    $page = isset($_GET['page']) ? $_GET['page'] : 1; 

    $start = ($page - 1) * $limit; 

    if(isset($_POST['submit'])) {
        $CarsBrand = $_POST['CarsBrand'];
        $CarsOverview = $_POST['CarsOverview'];
        $PricePerDay = $_POST['PricePerDay'];
        $FuelType = $_POST['FuelType'];
        $ModelYear = $_POST['ModelYear'];
        $chasis_no = $_POST['chasis_no'];
        $reg_no = $_POST['reg_no'];
        $SeatingCapacity = $_POST['SeatingCapacity'];
        $Cimage1 = $_FILES["img1"]["name"];
    

        move_uploaded_file($_FILES["img1"]["tmp_name"],"img/carimages/".$_FILES["img1"]["name"]);
        

        $sql = "INSERT INTO cars(CarsBrand,CarsOverview,PricePerDay,FuelType,ModelYear,chasis_no,reg_no,SeatingCapacity,Cimage1) VALUES(:CarsBrand,:CarsOverview,:PricePerDay,:FuelType,:ModelYear,:chasis_no,:reg_no,:SeatingCapacity,:Cimage1)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':CarsBrand', $CarsBrand, PDO::PARAM_STR);
        $query->bindParam(':CarsOverview', $CarsOverview, PDO::PARAM_STR);
        $query->bindParam(':PricePerDay', $PricePerDay, PDO::PARAM_STR);
        $query->bindParam(':FuelType', $FuelType, PDO::PARAM_STR);
        $query->bindParam(':ModelYear', $ModelYear, PDO::PARAM_STR);
        $query->bindParam(':chasis_no', $chasis_no, PDO::PARAM_STR);
        $query->bindParam(':reg_no', $reg_no, PDO::PARAM_STR);
        $query->bindParam(':SeatingCapacity', $SeatingCapacity, PDO::PARAM_STR);
        $query->bindParam(':Cimage1', $Cimage1, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId) {
            $msg = "Car posted successfully";
        } else {
            $error = "Something went wrong. Please try again";
        }
    } elseif (isset($_GET['del'])) {
        $carId = $_GET['del'];
    $sql = "DELETE FROM cars WHERE id = :carId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':carId', $carId, PDO::PARAM_INT);
    $query->execute();

    if ($query->rowCount() > 0) {
        $msg = "Car deleted successfully.";
    } else {
        $error = "Error deleting car.";
    }
    }

    // Get the total number of cars in the database
    $countQuery = "SELECT COUNT(*) as total FROM cars";
    $countResult = $dbh->query($countQuery);
    $countRow = $countResult->fetch(PDO::FETCH_ASSOC);
    $totalCars = $countRow['total'];

    // Calculate the total number of pages
    $totalPages = ceil($totalCars / $limit);

    // Fetch cars based on the pagination limits
    $sql = "SELECT * FROM cars LIMIT $start, $limit";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
}
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

    <title>Online Rental Portal | Manage Cars</title>

    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <!-- Bootstrap social button library -->
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <!-- Bootstrap file input -->
    <link rel="stylesheet" href="css/fileinput.min.css">
    <!-- Awesome Bootstrap checkbox -->
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <!-- Admin Stye -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap{
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
    </style>
</head>

<body>
    <!-- Body content -->
    <?php include('includes/header.php');?>
    <div class="ts-main-content">
        <!-- Main content section -->
        <?php include('includes/leftbar.php');?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Manage Cars</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Car List</div>
                                    <?php if($error) {?>
                                    <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?> </div>
                                    <?php } else if($msg) {?>
                                    <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?> </div>
                                    <?php }?>
                                    <div class="panel-body">
                                        <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>SNo</th>
                                                    <th>Brand</th>
                                                    <th>Overview</th>
                                                    <th>Price Per Day</th>
                                                    <th>Fuel Type</th>
                                                    <th>Model Year</th>
                                                    <th>Chasis No</th>
                                                    <th>Reg No</th>
                                                    <th>Seating Capacity</th>
                                                    <th>Image 1</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $cnt = ($page - 1) * $limit + 1;
                                                if($query->rowCount() > 0) {
                                                    foreach($results as $result) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo htmlentities($cnt);?></td>
                                                            <td><?php echo htmlentities($result->CarsBrand);?></td>
                                                            <td><?php echo htmlentities($result->CarsOverview);?></td>
                                                            <td><?php echo htmlentities($result->PricePerDay);?></td>
                                                            <td><?php echo htmlentities($result->FuelType);?></td>
                                                            <td><?php echo htmlentities($result->ModelYear);?></td>
                                                            <td><?php echo htmlentities($result->chasis_no);?></td>
                                                            <td><?php echo htmlentities($result->reg_no);?></td>
                                                            <td><?php echo htmlentities($result->SeatingCapacity);?></td>
                                                            <td><img src="img/carimages/<?php echo htmlentities($result->Cimage1);?>" style="width:200px; border-radius: 5px;"></td>
                                                            
                                                            <td>
                                                                <a href="edit-car.php?id=<?php echo $result->id; ?>" class="btn btn-primary btn-xs">Edit</a>
                                                                <a href="manage-cars.php?del=<?php echo $result->id; ?>" onclick="return confirm('Are you sure you want to delete this car?');" class="btn btn-danger btn-xs">Delete</a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $cnt++;
                                                    }
                                                }?>
                                            </tbody>
                                        </table>
                                        <!-- Pagination -->
                                        <ul class="pagination">
                                            <?php if($totalPages > 1): ?>
                                                <?php if($page > 1): ?>
                                                    <li><a href="?page=<?php echo $page - 1; ?>">&laquo;</a></li>
                                                <?php endif; ?>

                                                <?php for($i = 1; $i <= $totalPages; $i++): ?>
                                                    <li<?php echo ($i == $page) ? ' class="active"' : ''; ?>><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                                <?php endfor; ?>

                                                <?php if($page < $totalPages): ?>
                                                    <li><a href="?page=<?php echo $page + 1; ?>">&raquo;</a></li>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include('includes/footer.php');?>
            <!-- Loading Scripts -->
            <script src="js/jquery.min.js"></script>
            <script src="js/bootstrap-select.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/jquery.dataTables.min.js"></script>
            <script src="js/dataTables.bootstrap.min.js"></script>
            <script src="js/Chart.min.js"></script>
            <script src="js/fileinput.js"></script>
            <script src="js/chartData.js"></script>
            <script src="js/main.js"></script>
        </body>
    </html>