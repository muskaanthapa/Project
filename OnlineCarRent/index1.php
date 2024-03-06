
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
?>

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

    	
    	<div class="content">
    	<h2><b>Smart</b>Recondition House Pvt.Ltd</h2><br>
    	<p><p><p>Welcome to our website<br>It is located at chabhil.</br>satisfies the customers.<br>provide the cars to the customers</br></p></p>	
    	</p>	
    </div>

    <div class="photo">
    	<img src="car.webp">
    </div>

    <div class="font">
    	<ul>
    		<li><a href="#"><i class="fa fa-facebook"></i></a></li>
    		<li><a href="#"><i class="fa fa-twitter"></i></a></li>
    		<li><a href="#"><i class="fa fa-instagram"></i></a></li>
    		
    		
    	</ul>
    </div>



<div class="button">
	<a href="#" class="btn">Read more</a>
</div>
    	


</body>
</html>