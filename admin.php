<?php
session_start();
require_once('config/connect.php');

if(!isset($_SESSION['email'])){
  header("location:index");
}else{

  $admin = $_SESSION['email'];
  $query = $conn->query("Select * from staff Where Email='$admin'");

  $show = mysqli_fetch_array($query);

}

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="vendor/bootstrap-4.3.1/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="vendor/css/animate.css">
<link rel="stylesheet" type="text/css" href="vendor/fontawesome/css/all.css">
 <link rel="stylesheet" href="vendor/owlcarousel/owl.carousel.css">
<link rel="icon" href="favicon.png" />
<title>Pay your tax</title>

<style type="text/css">
	.profile-p{
	width:100px; 
    margin:auto; 
    margin-top: 3px;
    margin-bottom: 3px;
    height:100px;
    border-radius:50%; 
    background-size: cover;
    background-repeat: no-repeat;
    position: relative;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
	}

</style>
</head>
<body>

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

<div class="row">
	<div class="col-md-3">
		<div class="card" style="width: 17rem;">
  <div class="card-header">
    STAFF DASHBOARD
  </div>
  <ul class="list-group list-group-flush" id="myTab" role="tablist">
  	<div class="profile-p" style="background-image: url('profile/angwa.jpg');"></div>
    <li class="list-group-item" ><a data-toggle="tab" href="#home" role="tab">Profile</a></li>
    <li class="list-group-item" ><a data-toggle="tab" href="#rent" role="tab">Add rent type</a></li>
    <li class="list-group-item"><a data-toggle="tab" href="#defaulters" role="tab">Check defaulters</a></li>
    <li class="list-group-item"><a data-toggle="tab" href="#users" role="tab">Users from LGA</a></a></li>
    <li class="list-group-item"><a data-toggle="tab" href="#staff" role="tab">Add new staff</a></li>
    <li class="list-group-item"><a data-toggle="tab" href="#Update" role="tab">Update profile</a></li>
   
  
  </ul>





</div>
	</div>
	<div class="col-md-9">


<div class="tab-content">
  <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">




		
 <ul class="list-group">
 	
  <li class="list-group-item" style="background-color: rgb(235, 238, 242);">Staff personal details <i class="fa fa-user-tie"></i></li>
  <li class="list-group-item"><b>Name:</b> <span ><?php echo $show['Firstname']." ".$show['Lastname']; ?></span></li>
  <li class="list-group-item"><b>Email:</b> <span ><?php echo $show['Email']; ?></span></li>
  <li class="list-group-item"><b>Gender:</b> <span ><?php echo $show['Sex']; ?></span></li>
  <li class="list-group-item"><b>Age:</b> <span ><?php echo $show['DOB']; ?></span></li> 
  <li class="list-group-item"><b>LGA:</b> <span ><?php echo $show['LGA']; ?></span></li> 

</ul>



  </div>
  <div class="tab-pane" id="rent" role="tabpanel" aria-labelledby="home-tab">

    <?php 

    function prepare($data){
    $data = htmlspecialchars($data);
    $data = stripcslashes($data);
    $data = trim($data);
    return $data;
  }
  $msg="";


    if(isset($_POST['submit'])){

      $type = prepare($_POST['type']);
      $price = prepare($_POST['price']);

      $sql =$conn->query("Insert into rents (RentTYpe, Price) values('$type','$price')");

      if($sql==false){


        $msg = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Can not insert rent type. Try again.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
      }else{

             $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> New rent type has been added successfully.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';

      }


    }
  }

    ?>

    <h3>#Rent types</h3>

    <table class="table table-bordered table-striped">
      <tr>
        <th>Id</th>
        <th>Type</th>
        <th>Price</th>
        <th>Action</th>
      </tr>

      <?php 

      if(isset($_POST['delete'])){
        $id= prepare($_POST['id']);

          $delete = $conn->query("Delete from rents where Id='$id' ");

          if($delete==true){
            echo "<script>alert('Rent type has been removed successfully');</script>";
          
        }
      }




      $rents = $conn->query("select * from rents ");
      $sn =0;
      while($all_rents = mysqli_fetch_array($rents)){
        $sn++;

      ?>
      <tr>
        <td><?php echo $sn; ?></td>
        <td><?php echo $all_rents['RentType']; ?></td>
        <td><?php echo $all_rents['Price']; ?></td>
        <td>

        <form action="" method="POST">
          <input type="hidden" name="id" value="<?php echo $all_rents['Id']; ?>">
          <input type="submit" name="delete" value="Delete" class="btn btn-sm btn-danger">
        </form>


        </td>
      </tr>
      <?php
    }
      ?>
    </table>

    <h3>#Add new rent type</h3>
    <?php echo $msg; ?>
    <form action="" method="POST">


      <p>Enter rent type</p>
      <input type="text" name="type" class="form-control" required="">
      <p> Enter price</p>
      <input type="number" name="price" class="form-control" required="">
      <br />
      <input type="submit" name="submit" class="btn btn-primary">
     </form>


  </div>





  <div class="tab-pane" id="defaulters" role="tabpanel" aria-labelledby="messages-tab">
    

    <h3>Defaulters from <?php echo $show['LGA'];   ?></h3>

     <table class="table table-bordered table-striped">
      <tr>
        <th>Id</th>
        <th>Firstname</th>
        <th>Othernames</th>
        <th>phone </th>
        <th>Address </th>
        <th>Status </th>
      </tr>
<?php
$month = date('M Y');


$lg = $show['LGA'];
$default = $conn->query("SELECT * from users u LEFT JOIN transaction t ON u.Tin =  t.Tin where u.LGA='$lg' ") or die(mysqli_error($conn));
      $sn =0;
      while($all_users = mysqli_fetch_array($default)){
        $sn++;

        if($all_users['Month'] != "$month"){
        
      ?>
      <tr>
        <td><?php echo $sn; ?></td>
        <td><?php echo $all_users['Firstname']; ?></td>
        <td><?php echo $all_users['Lastname']; ?></td>
        <td> <?php echo $all_users['Phone']; ?></td>
        <td> <?php echo $all_users['Address']; ?></td>
        <td> <button class="btn btn-danger">Owing</button></td>
      </tr>
      <?php
    }
    }
      ?>
    </table>


  </div>









  <div class="tab-pane" id="users" role="tabpanel" aria-labelledby="settings-tab">

<h3>#Users From <?php echo $show['LGA'];   ?></h3>
 <table class="table table-bordered table-striped">
      <tr>
        <th>Id</th>
        <th>Firstname</th>
        <th>Othernames</th>
        <th>phone </th>
        <th>DOB </th>
      </tr>
<?php
$lg = $show['LGA'];
$user = $conn->query("select * from users where LGA='$lg' ");
      $sn =0;
      while($all_users = mysqli_fetch_array($user)){
        $sn++;

      ?>
      <tr>
        <td><?php echo $sn; ?></td>
        <td><?php echo $all_users['Firstname']; ?></td>
        <td><?php echo $all_users['Lastname']; ?></td>
        <td> <?php echo $all_users['Phone']; ?></td>
        <td> <?php echo $all_users['DOB']; ?></td>
      </tr>
      <?php
    }
      ?>
    </table>


  </div>




  <div class="tab-pane" id="staff" role="tabpanel" aria-labelledby="settings-tab">

<h3>Add New staff</h3>


 

<form action="" method="post" enctype="multipart/form-data">

  <?php
  if(isset($_POST['newstaff'])){

    $email = prepare($_POST['email']);
    $fname = prepare($_POST['fname']);
    $lname = prepare($_POST['lname']);
    $lg = prepare($_POST['lga']);
    $sex = prepare($_POST['sex']);
    $role = prepare($_POST['role']);
    $dob = prepare($_POST['dob']);

    $pass = sha1(123);


$path= "profile/staff/";

$file = $path .basename($_FILES['photo']['name']);

$fileType= pathinfo($file, PATHINFO_EXTENSION);
$allowType= array('jpg', 'png', 'jpeg');
 
if(in_array($fileType, $allowType)){
if(move_uploaded_file($_FILES['photo']['tmp_name'], $file) ){

$insert = $conn->query("insert into staff (Email, Firstname, Lastname, LGA, Sex, Role, DOB, Password, Photo) values('$email', '$fname','$lname','$lg', '$sex', '$role','$dob', '$pass', '$file')");

if($insert==true){
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> New staff has been added successfully. Thank you!
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}else{
   echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> This email has been used by another user. Try again!
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}
}
}

  }
  ?>

  <div class="row">
    <div class="col-md-6">
  
  <p>Enter staff Email</p>
  <input type="email" name="email" class="form-control" required="">  
  <p>Enter First name</p>
  <input type="text" name="fname" class="form-control" required="">  
  <p>Enter Lastname</p>
  <input type="text" name="lname" class="form-control" required="">  
  <p>Select LGA</p>

  <select name="lga" class="form-control" required=""> 
  <option value="">--Select LGA--</option> 
       <option value="Oju">Oju</option>
        <option value="Buruku">Buruku</option>
        <option value="Konshisha">Konshsia</option>
        <option value="Makurdi">Makurdi</option>
        <option value="Otukpo">Otukpo</option>
        <option value="Obi">Obi</option>
        <option value="Kwande">Kwande</option>
        <option value="Ado">Ado</option>
        <option value="Apa">Apa</option>
        <option value="Gboko">Gboko</option>
        <option value="Guma">Guma</option>
        <option value="Gwer-East">Gwer-East</option>
       <option value="Gwer-West">Gwer-West</option>
       <option value="Kastina-Ala">Kastina-Ala</option>
        <option value="Logo">Logo</option>
      <option value="Ogbadibo">Ogbadibo</option>
      <option value="Okpokwu">Okpokwu</option>
      <option value="Ohimini">Ohimini</option>
      <option value="Oturkpo">Oturkpo</option>
      <option value="Tarka">Tarka</option>
     <option value="Ukum">Ukum</option>
     <option value="Ushongo">Ushongo</option>
      <option value="Vandeikya">Vandeikya</option>
      <option value="Vandeikya">tis end local ovt.</option>
     </select>

</div>
<div class="col-md-6">

 <p>Select Gender</p>
      <select name="sex"  class="form-control" required="required">
        <option value="Male">Male</option>
        <option value="Female">Female</option>
      </select>



 <p>Select Role</p>
      <select name="role"  class="form-control" required="required">
        <option value="Admin">Admin</option>
        <option value="Staff">Staff</option>
      </select>


  <p>Enter Date of Birthday</p>
  <input type="date" name="dob" class="form-control" required="">  
  <p>Select Photo</p>
  <input type="file" name="photo" class="form-control" required="">  


  </div>
</div>
<input type="submit" name="newstaff" class="btn btn-primary btn-block" style="margin-top: 8px">
</form>


</div>



	</div>
</div>
<br />
</div>

















<script type="text/javascript" src="vendor/js/wow.js"></script>
<script type="text/javascript" src="vendor/bootstrap-4.3.1/js/jquery-3.4.1.js"></script>
<script type="text/javascript" src="vendor/bootstrap-4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="vendor/owlcarousel/owl.carousel.js"></script>
<script type="text/javascript" src="vendor/owlcarousel/home.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#myTab a[href="' + activeTab + '"]').tab('show');
    }
});


</script>


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
