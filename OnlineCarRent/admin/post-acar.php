<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    if (isset($_POST['submit'])) {
        $CarsBrand = $_POST['CarsBrand'];
        $CarsOverview = $_POST['CarsOverview'];
        $PricePerDay = $_POST['PricePerDay'];
        $FuelType = $_POST['Fueltype'];
        $ModelYear = $_POST['ModelYear'];
        $chassis_no = strtoupper($_POST['chasis_no']);
        $reg_no = $_POST['reg_no'];
        $SeatingCapacity = $_POST['SeatingCapacity'];
        $Cimage1 = $_FILES["img1"]["name"];

        // Regular expression pattern for the desired format
        $reg_pattern = "/^[a-zA-Z]{2}-\d{2}-[a-zA-Z]{2,3}-\d{4}$/";
        $chassis_pattern = "/^[a-zA-Z0-9]{10,17}$/";

        if (!preg_match($reg_pattern, $reg_no)) {
            $error = "Please enter a valid registration number in the format: ba-02-kha-9878";
        } elseif (!preg_match($chassis_pattern, $chassis_no)) {
            $error = "Please enter a valid chassis number with 10 to 17 alphanumeric characters";
        } else {
            // Check if the registration number and chassis number already exist
            $checkRegNoSql = "SELECT COUNT(*) as count FROM cars WHERE reg_no = :reg_no";
            $checkChassisNoSql = "SELECT COUNT(*) as count FROM cars WHERE chasis_no = :chassis_no";
            $checkRegNoQuery = $dbh->prepare($checkRegNoSql);
            $checkChassisNoQuery = $dbh->prepare($checkChassisNoSql);
            $checkRegNoQuery->bindParam(':reg_no', $reg_no, PDO::PARAM_STR);
            $checkChassisNoQuery->bindParam(':chassis_no', $chassis_no, PDO::PARAM_STR);
            $checkRegNoQuery->execute();
            $checkChassisNoQuery->execute();
            $regRow = $checkRegNoQuery->fetch(PDO::FETCH_ASSOC);
            $chassisRow = $checkChassisNoQuery->fetch(PDO::FETCH_ASSOC);

            if ($regRow['count'] > 0) {
                $error = "Registration number already exists. Please enter a unique registration number.";
            } elseif ($chassisRow['count'] > 0) {
                $error = "Chassis number already exists. Please enter a unique chassis number.";
            } else {
                // Registration number and chassis number are unique, proceed with insertion
                move_uploaded_file($_FILES["img1"]["tmp_name"], "img/carimages/" . $_FILES["img1"]["name"]);

                $sql = "INSERT INTO cars(CarsBrand,CarsOverview,PricePerDay,FuelType,ModelYear,chasis_no,reg_no,SeatingCapacity,Cimage1) VALUES(:CarsBrand,:CarsOverview,:PricePerDay,:FuelType,:ModelYear,:chasis_no,:reg_no,:SeatingCapacity,:Cimage1)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':CarsBrand', $CarsBrand, PDO::PARAM_STR);
                $query->bindParam(':CarsOverview', $CarsOverview, PDO::PARAM_STR);
                $query->bindParam(':PricePerDay', $PricePerDay, PDO::PARAM_STR);
                $query->bindParam(':FuelType', $FuelType, PDO::PARAM_STR);
                $query->bindParam(':ModelYear', $ModelYear, PDO::PARAM_STR);
                $query->bindParam(':chasis_no', $chassis_no, PDO::PARAM_STR);
                $query->bindParam(':reg_no', $reg_no, PDO::PARAM_STR);
                $query->bindParam(':SeatingCapacity', $SeatingCapacity, PDO::PARAM_STR);
                $query->bindParam(':Cimage1', $Cimage1, PDO::PARAM_STR);

                $query->execute();
                $lastInsertId = $dbh->lastInsertId();

                if ($lastInsertId) {
                    $msg = "Car posted successfully";
                } else {
                    $error = "Something went wrong. Please try again";
                }
            }
        }
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
    <title>Online Rental Portal | Owner Post Car</title>
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
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }

        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }
    </style>
</head>

<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Post A Car</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Basic Info</div>
                                    <?php if ($error) { ?>
                                    <div class="errorWrap"><strong>ERROR</strong>:
                                        <?php echo htmlentities($error); ?>
                                    </div>
                                    <?php } else if ($msg) { ?>
                                    <div class="succWrap"><strong>SUCCESS</strong>:
                                        <?php echo htmlentities($msg); ?>
                                    </div>
                                    <?php } ?>
                                    <div class="panel-body">
                                        <form method="post" class="form-horizontal" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Select Brand<span
                                                        style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <select class="selectpicker" name="CarsBrand" required>
                                                        <option value="">Select</option>
                                                        <?php
                                                            $ret = "SELECT  BrandName FROM tblbrands";
                                                            $query = $dbh->prepare($ret);
                                                            $query->execute();
                                                            $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                            if ($query->rowCount() > 0) {
                                                                foreach ($results as $result) {
                                                        ?>
                                                        <option value="<?php echo htmlentities($result->BrandName); ?>">
                                                            <?php echo htmlentities($result->BrandName); ?>
                                                        </option>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="hr-dashed"></div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Car Overview<span
                                                        style="color:red">*</span></label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" name="CarsOverview" rows="3"
                                                        required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Price Per Day<span
                                                        style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="PricePerDay" class="form-control" required>
                                                </div>
                                                <label class="col-sm-2 control-label">Select Fuel Type<span
                                                        style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <select class="selectpicker" name="Fueltype" required>
                                                        <option value="">Select</option>
                                                        <option value="Petrol">Petrol</option>
                                                        <option value="Diesel">Diesel</option>
                                                        <option value="CNG">CNG</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Model Year<span
                                                        style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="ModelYear" class="form-control" required>
                                                </div>
                                                <label class="col-sm-2 control-label">Chassis Number<span
                                                        style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="chasis_no" class="form-control" required
                                                        pattern="[a-zA-Z0-9]{10,17}"
                                                        title="Chassis number should be 10 to 17 characters alphanumeric">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Registration Number<span
                                                        style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="reg_no" class="form-control" required
                                                        pattern="[a-zA-Z]{2}-\d{2}-[a-zA-Z]{2,3}-\d{4}"
                                                        oninput="formatRegistrationNumber(this)"
                                                        placeholder="Format: ba-02-kha-9878">
                                                </div>
                                                <label class="col-sm-2 control-label">Seating Capacity<span
                                                        style="color:red">*</span></label>
                                                <div class="col-sm-4">
                                                    <input type="text" name="SeatingCapacity" class="form-control"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="hr-dashed"></div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <h4><b>Upload Images</b></h4>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-4">
                                                    Image 1<span style="color:red">*</span><input type="file"
                                                        name="img1" required>
                                                </div>
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
    <script>
        function formatRegistrationNumber(inputField) {
            // Get the current input value
            let inputValue = inputField.value;

            // Remove any existing hyphens and non-alphanumeric characters
            inputValue = inputValue.replace(/[^a-zA-Z\d]/g, '');

            // Format the input value
            let formattedValue = '';
            for (let i = 0; i < inputValue.length; i++) {
                if (i === 2 || i === 4 || i === 7) {
                    formattedValue += '-';
                }
                formattedValue += inputValue[i];
            }

            // Update the input field's value
            inputField.value = formattedValue;
        }
    </script>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
<?php } ?>
