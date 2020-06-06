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

  $fname = prepare($_POST['fname']);
  $lname = prepare($_POST['lname']);
  $address = prepare($_POST['address']);
  $lg = prepare($_POST['lga']);
  $dob = prepare($_POST['dob']);
  $sex = prepare($_POST['sex']);

  $phone = prepare($_POST['phone']);

  $password= prepare($_POST['password']);



  //$salt = "Bishop Cipher";
  $password = sha1($password);

  $tin = rand(0000000001, 999999999);


$path= "profile/";

$file = $path .basename($_FILES['photo']['name']);

$fileType= pathinfo($file, PATHINFO_EXTENSION);
$allowType= array('jpg', 'png', 'jpeg');
 
if(in_array($fileType, $allowType)){
if(move_uploaded_file($_FILES['photo']['tmp_name'], $file) ){

  $check = mysqli_num_rows($conn->query("select * from users where Phone ='$phone' "));

  if($check>0){

    $msg = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Warning!</strong> This phone number has been used before. try to register a new user. Thank you!
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';

  }else{



  $sql = $conn->query("insert into users (Tin, Firstname, Lastname, Address, Phone, LGA, DOB, Gender, Password, photo) values('$tin', '$fname', '$lname', '$address', '$phone', '$lg', '$dob', '$sex', '$password', '$file')") or die(mysqli_error($conn));

  if($sql==true){

    $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Congratulation!</strong> Your account has been successfully created. click <a href="login.php">here </a> to login now
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';

  }
}
}

}
else{

  $msg ="<div class='alert alert-warning'><strong>Warning:</strong> YOur profile picture you selected is not the right format. Please select jpg, png or jpeg file</div>";
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
<title>Tax - Registration</title>


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
	<li class="nav-item" ><a href="#" class="nav-link">Create account</a></li>
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
			<li class="nav-item" ><a href="index.php" style="color:#787878" class="nav-link">HOME</a></li>
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
<div class="register animated fadeInUp slow">
<div class="mytit">
  <h4>TIN REGISTRATION</h4>
</div>

  <div class="cover">
<?php echo $msg; ?>
    <form action="" method="POST" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-6">
      <p>Enter your First Name</p>
      <input type="text" name="fname"  class="form-control" required="required">


      <p>Enter your Last Name</p>
      <input type="text" name="lname"  class="form-control" required="required">


      <p>Select Gender</p>
      <select name="sex"  class="form-control" required="required">
        <option value="Male">Male</option>
        <option value="Female">Female</option>
      </select>





      <p>Select your date of birth</p>
      <input type="date" name="dob"  class="form-control" required="required">

         <p>Enter your phone</p>
        <input type="number" name="phone"  class="form-control" required="required">

        

      <p>Select your local government</p>
      <select name="lga"  class="form-control" required="required">
        <option value="Oju">Oju</option>
        <option value="Buruku">Buruku</option>
        <option value="Konshisha">Konshsia</option>
        <option value="Makurdi">Makurdi</option>
        <option value="Otukpo">Otukpo</option>
        <option value="Obi">Obi</option>
        <option value="Kwande">Kwande</option>
      </select>

      
    </div>
    <div class="col-md-6">

   

      <p>Create your password</p>
        <input type="password" name="password"  class="form-control" required="required">


      <p>Select your photo</p>
        <input type="file" name="photo"  class="form-control" required="required">

        <p>Enter your address</p>

        <textarea class="form-control" name="address" style="height: 130px;" required="required"></textarea>
        <br />
        <input type="submit" name="submit" class="btn btn-success btn-block">

    </div>
    </div>
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
