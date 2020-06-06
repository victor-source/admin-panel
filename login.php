<?php
session_start();

require_once('config/connect.php');

$msg="";

  function prepare($data){
    $data = htmlspecialchars($data);
    $data = stripcslashes($data);
    $data = trim($data);
    return $data;
  }


if(isset($_POST['submit'])){

  $tin = prepare($_POST['tin']);
  $password = prepare($_POST['password']);

  //$salt = "Bishop Cipher";
  $password = sha1($password);

  $sql = $conn->query("SELECT  * FROM users WHERE (Tin='$tin' || Phone='$tin') && Password='$password'") or die(mysqli_error($conn));

  $exist = mysqli_num_rows($sql);
  if($exist>0){

  	$_SESSION['tin']=$tin;

  	header("location:dashboard.php");
  }else{

  	    $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Tin number and password do not march.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
  }

}

  ?>

  <!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="vendor/bootstrap-4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="vendor/css/style.css">
<link rel="stylesheet" type="text/css" href="vendor/css/animate.css">
<link rel="stylesheet" type="text/css" href="vendor/fontawesome/css/all.css">
 <link rel="stylesheet" href="vendor/owlcarousel/owl.carousel.css">
<link rel="icon" href="favicon.png" />
<title>Pay your tax</title>


</head>
<body>

<nav class="navbar navbar-expand-sm navbar-light" style="background-color: #19b048">
	<a href="#" class="navbar-brand"><i class="fa fa-chart-line"></i> Tax Service</a>
  <button class="navbar-toggler mr-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" >
    <span class="navbar-toggler-icon"></span>
  </button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="nav navbar-nav mr-auto">
	<li class="nav-item" ><a href="index.php" class="nav-link">Home</a></li>
	<li class="nav-item" ><a href="login.php" class="nav-link">Login</a></li>
	<li class="nav-item" ><a href="register.php" class="nav-link">Create account</a></li>
	<li class="nav-item" ><a href="#" class="nav-link">About us</a></li>
</ul>


<ul class="nav navbar-nav mr-right">
	<li class="social-item" style="margin-right: 15px; font-size: 20px;"><a href="#" style="color: #fff"><i  class="fab fa-facebook"></i></a></li>	
	<li class="social-item" style="margin-right: 15px; font-size: 20px;"><a href="#" style="color: #fff"><i class="fab fa-twitter"></i></i></a></li>	
	<li class="social-item" style="margin-right: 15px; font-size: 20px;"><a href="#" style="color: #fff"><i class="fab fa-instagram"></i></a></li>	
	<li class="social-item" style="margin-right: 15px; font-size: 20px;"><a href="#" style="color: #fff"><i class="fab fa-youtube"></i></a></li>	
	<li class="social-item" style="margin-right: 15px; font-size: 20px;"><a href="#" style="color: #fff"><i class="fab fa-whatsapp"></i></a></li>

	<li class="social-item" style="margin-right: 15px; font-size: 20px;"><a href="#" style="color: #fff"><i class="fab fa-pinterest"></i></a></li>	
</ul>

</div>
</nav>
<div class="container">
<div class="row">
	<div class="col-md-4 col-6">.
		<img src="images/logo.png" width="80px" style="margin-top:10px;">
	</div>

	<div class="col-md-8 col-6">
		<ul class="nav nav-pills  mr-right" style="margin-top: 30px;">
			<li class="nav-item" ><a href="#" style="color:#787878" class="nav-link">HOME</a></li>
			<li class="nav-item" ><a href="#" style="color:#787878"  class="nav-link">PAY TAX</a></li>
			<li class="nav-item" ><a href="#" style="color:#787878"  class="nav-link"><i class="fa fa-ribbon"></i> CHECK REVENUE </a></li>
			<li class="nav-item" ><a href="#" style="color:#787878"  class="nav-link"> CONTACT US</a></li>
			<li class="nav-item" ><a href="#" style="color:#787878"  class="nav-link">REPORT ISSUES</a></li>
			<li class="nav-item" ><a href="#" style="color:#787878"  class="nav-link"><i class="fa fa-hashtag"></i>FAQ</a></li>
			
		</ul>
	

	</div>
</div>
</div>

<hr style="border:1px solid  rgb(220, 98, 99)" />
<br/>


<div class="container">
<div class="login animated fadeInUp slow">
<div class="mytit">
  <h4>USER LOGIN</h4>
</div>

<?php echo $msg; ?>
  <div class="cover">
  <form action="" method="post">
    <p>Enter your TIN/Phone number</p>
    <div class="input-group mb-3">
        
        <div class="input-group-prepend">
           <span class="input-group-text"><i class="fa fa-user"></i></span>
        </div>
            <input type="text" name="tin" placeholder="E.g: 132345623" class="form-control">
      
                        
    </div>

    <p>Enter your Password</p>
    <div class="input-group mb-3">
        
        <div class="input-group-prepend">
           <span class="input-group-text"><i class="fa fa-lock"></i></span>
        </div>
            <input type="Password" name="password" placeholder="*******" class="form-control">
      
                        
    </div>
<input type="submit" name="submit" class="btn btn-md btn-success mr-auto" style="margin: 0 auto" value="Login">


  </form>
  </div>




</div>
</div>

<br />

















<div class="footer">
	<br />
	<div class="col-md-6 offset-3">
	<div class="input-group mb-3">
  <input type="text" class="form-control" placeholder="Subscribe to email!" aria-label="Recipient's username" aria-describedby="basic-addon2">
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon2">@example.com</span>
  </div>
</div>
</div>

<div class="container-fluid">

<div class="row">

	<div class="col-md-4">
		<h3>Quick Access</h3>
		<ul>
			<li><a href="#">Search information</a></li>
			<li><a href="#">pay tax</a></li>
			<li><a href="#">Report issue</a></li>
			<li><a href="#">Others</a></li>
		</ul>
	</div>
	
	<div class="col-md-4">
		<h3>Short Links</h3>
			<ul>
			<li><a href="#">Terms & Conditions</a></li>
			<li><a href="#">About us</a></li>
			<li><a href="#">Contact us</a></li>
			<li><a href="#">Privacy policy</a></li>
		</ul>
	</div>
	
	<div class="col-md-4">
		<h3>Disclaimer</h3>
		<p>We are not responsible for any external link that goes out of this website. Browsing anything out of this web site with any link from here is at your own risk.. Copyright &copy; 2020 | All rights reserved </p>
	</div>

</div>

</div>
<p class="techrald">Website Designed and coded by <strong><a href="#"><font color="#fff">Patrick Sule <i class="fa fa-external-link-alt"></i></font></a></strong></p>


</div>




<script type="text/javascript" src="vendor/js/wow.js"></script>
<script type="text/javascript" src="vendor/bootstrap-4.3.1/js/jquery-3.4.1.js"></script>
<script type="text/javascript" src="vendor/bootstrap-4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="vendor/owlcarousel/owl.carousel.js"></script>
<script type="text/javascript" src="vendor/owlcarousel/home.js"></script>


<script>
    new WOW().init();

$(function() {
    $(".preload").fadeOut(2000, function() {
        $(".content").fadeIn(1000);        
    });
});

</script>

</body>
</html> 
