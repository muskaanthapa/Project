<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
{
    header('location:index.php');
}
else {
    if(isset($_GET['id'])) {
        $carId = $_GET['id'];
    } else {
        header('location:manage-cars.php');
    }

    if(isset($_POST['submit'])) {
        $CarsBrand = $_POST['CarsBrand'];
        $CarsOverview = $_POST['CarsOverview'];
        $PricePerDay = $_POST['PricePerDay'];
        $FuelType = $_POST['FuelType'];
        $ModelYear = $_POST['ModelYear'];
        $chasis_no = $_POST['chasis_no'];
        $reg_no = $_POST['reg_no'];
        $SeatingCapacity = $_POST['SeatingCapacity'];

        $sql = "UPDATE cars SET CarsBrand=:CarsBrand, CarsOverview=:CarsOverview,PricePerDay=:PricePerDay,FuelType=:FuelType,ModelYear=:ModelYear,chasis_no=:chasis_no,reg_no=:reg_no,SeatingCapacity=:SeatingCapacity WHERE id=:carId";
        $query = $dbh->prepare($sql);
        $query->bindParam(':CarsBrand', $CarsBrand, PDO::PARAM_STR);
        $query->bindParam(':CarsOverview', $CarsOverview, PDO::PARAM_STR);
        $query->bindParam(':PricePerDay', $PricePerDay, PDO::PARAM_STR);
        $query->bindParam(':FuelType', $FuelType, PDO::PARAM_STR);
        $query->bindParam(':ModelYear', $ModelYear, PDO::PARAM_STR);
        $query->bindParam(':chasis_no', $chasis_no, PDO::PARAM_STR);
        $query->bindParam(':reg_no', $reg_no, PDO::PARAM_STR);
        $query->bindParam(':SeatingCapacity', $SeatingCapacity, PDO::PARAM_STR);
        $query->bindParam(':carId', $carId, PDO::PARAM_INT);
        $query->execute();

        $msg = "Car details updated successfully";
    }

    // Fetch car details based on the provided car ID
    $sql = "SELECT * FROM cars WHERE id = :carId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':carId', $carId, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
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

    <title>Online Rental Portal | Edit Car</title>

    <!-- Font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <!-- Bootstrap select -->
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <!-- Awesome Bootstrap checkbox -->
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <!-- Admin Stye -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include('includes/header.php'); ?>

    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>

        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Edit Car</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <?php if(isset($msg)) {?>
                                <div class="alert alert-success">
                                    <strong>Success!</strong> <?php echo htmlentities($msg); ?>
                                </div>
                                <?php } ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">Car Info</div>
                                    <div class="panel-body">
                                        <form method="post" class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Car Brand<span
                                                        style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="CarsBrand" class="form-control"
                                                        value="<?php echo htmlentities($result->CarsBrand); ?>"
                                                        required>
                                                </div>
                                                <label class="col-sm-2 control-label">Car Overview<span
                                                        style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="CarsOverview" class="form-control"
                                                        value="<?php echo htmlentities($result->CarsOverview); ?>"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="hr-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Price Per Day<span
                                                        style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="PricePerDay" class="form-control"
                                                        value="<?php echo htmlentities($result->PricePerDay); ?>"
                                                        required>
                                                </div>
                                                <label class="col-sm-2 control-label">Fuel Type<span
                                                        style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="FuelType" class="form-control"
                                                        value="<?php echo htmlentities($result->FuelType); ?>"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="hr-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Model Year<span
                                                        style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="ModelYear" class="form-control"
                                                        value="<?php echo htmlentities($result->ModelYear); ?>"
                                                        required>
                                                </div>
                                                <label class="col-sm-2 control-label">Chasis Number<span
                                                        style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="chasis_no" class="form-control"
                                                        value="<?php echo htmlentities($result->chasis_no); ?>"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="hr-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Registration Number<span
                                                        style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="reg_no" class="form-control"
                                                        value="<?php echo htmlentities($result->reg_no); ?>" required>
                                                </div>
                                                <label class="col-sm-2 control-label">Seating Capacity<span
                                                        style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="SeatingCapacity" class="form-control"
                                                        value="<?php echo htmlentities($result->SeatingCapacity); ?>"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="hr-dashed"></div>
                                            <div class="form-group">
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    <button class="btn btn-primary" name="submit" type="submit">Save
                                                        changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/main.js"></script>

</body>

</html>
<?php } ?>

