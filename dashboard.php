<?php
session_start();
require_once('config/connect.php');

  function prepare($data){
    $data = htmlspecialchars($data);
    $data = stripcslashes($data);
    $data = trim($data);
    return $data;
  }



if(!isset($_SESSION['tin'])){
  header("location:index");
}else{

  $user = $_SESSION['tin'];
 
  $query = $conn->query("Select * from users Where Tin='$user' || Phone='$user' ");

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
			<li class="nav-item" ><a href="#" style="color:#787878" class="nav-link">HOME</a></li>
			<li class="nav-item" ><a href="#" style="color:#787878"  class="nav-link">PAY TAX</a></li>
			<li class="nav-item" ><a href="#" style="color:#787878"  class="nav-link"><i class="fa fa-ribbon"></i> CHECK REVENUE </a></li>
			<li class="nav-item" ><a href="#" style="color:#787878"  class="nav-link"> CONTACT US</a></li>
			<li class="nav-item" ><a href="#" style="color:#787878"  class="nav-link">REPORT ISSUES</a></li>
			<li class="nav-item" ><a href="logout.php" style="color:#787878"  class="nav-link"><i class="fa fa-hashtag"></i>LOGOUT</a></li>
			
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
    USER DASHBOARD
    <p style="color: green;"> <strong><?php
    echo "Welcome "  . $show['Firstname'];
    ?>
  </strong></p>
  </div>
  <ul class="list-group list-group-flush" id="myTab" role="tablist">
    <div class="profile-p" style="background-image: url(<?php echo $show['Photo'] ?>);"></div>
    
    
    <div style="padding:7px">
    <img src="images/pay.jpg" style="width:100%; height:90px;">
   

      <?php 

        $tin = $show['Tin'];


        $init_biz =$conn->query("select * from business  WHERE  Tin='$tin' ");

        $sum =0;

        while($all_bizi=mysqli_fetch_array($init_biz)){

          $biz_name = $all_bizi['Type'];

          $biz_name;

          $renter = $conn->query("Select * from rents WHERE RentType='$biz_name' ");

          while($all=mysqli_fetch_array($renter)){

            $sum += $all['Price'];

            
          }


        }
        $month = date('M Y');

$paid="";

      if(isset($_POST['pay'])){

        
        $payer = $conn->query("insert into transaction (Tin, Amount, Month) values('$tin','$sum', '$month')") or die(mysqli_error($conn)); 

        if($payer == true){

          $paid = '<div class="alert alert-info alert-dismissible fade show" role="alert">
  <strong>Payment Successful!</strong> Your payment was processed successfully. Thank you for paying your tax.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
        }


      }

      $select = $conn->query("select * from transaction where Tin='$tin' && Month='$month' ");

  
      if(mysqli_num_rows($select)>0){

      ?>


      
      <input type="text" readonly="" value="Total Tax: 0" style="margin-top: 7px;" class="form-control">
<?php
}else{


?>
 
      <input type="text" readonly="" value="Total Tax: <?php echo $sum; ?>" style="margin-top: 7px;" class="form-control">

      <?php

    }

    ?>

      <p>Select Payment method</p>
       <select class="form-control">
        <option value="Card">Card payment</option>
        <option value="Card">Cash payment</option>
      </select>
      <p>Confirm password</p>
       <input type="password" name="amount" class="form-control">
     <?php 


      if(mysqli_num_rows($select)>0){

      ?>
      <button type="button" onclick="alert('You are not owing tax for this month')" name="pay" readonly class="btn btn-block btn-info" style="margin-top: 7px;">Pay now</button>
      <?php
    }else{

      ?>
       <form action="" method="POST">
 <input type="submit" name="pay" class="btn btn-block btn-info" value="Pay now" style="margin-top: 7px;">
 </form>
      <?php
    }

    ?>
    
</div>
 

   
  
  </ul>





</div>
</div>

<div class="col-md-9">

<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profile</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">#My Business</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Transaction</a>
  </li>
</ul>
<br />
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">


    <?php echo $paid; ?>
 
 <div class="alert alert-success"><strong>Tax Identification Number:</strong> <?php echo $show['Tin']; ?></div>

 <div class="row">
    <div class="col">
      <input type="text" readonly="" value="Firstname: <?php echo $show['Firstname']; ?>" class="form-control" placeholder="First name">
    </div>
    <div class="col">
      <input type="text" readonly="" value="Lastname: <?php echo $show['Lastname']; ?>" class="form-control" placeholder="Last name">
    </div>
  </div>
    

<br />
<div class="form-row">
    <div class="col-4">
      <input type="text" readonly="" value="Phone: <?php echo $show['Phone']; ?>"  class="form-control" placeholder="City">
    </div>
    <div class="col">
      <input type="text" readonly="" value="Date of Birth: <?php echo $show['DOB']; ?>"  class="form-control" placeholder="State">
    </div>
    <div class="col">
      <input type="text" readonly="" value="LGA: <?php echo $show['LGA']; ?>"  class="form-control" placeholder="Zip">
    </div>
  </div>

  <br />



<br />

 <div class="row">
    <div class="col">
      <input type="text" readonly="" value="Gender: <?php echo $show['Gender']; ?>" class="form-control" placeholder="First name">
    </div>
    <div class="col">
      <input type="text" readonly="" value="Date of Registration: <?php echo $show['DateReg']; ?>" class="form-control" placeholder="Last name">
    </div>
  </div>

  <br />
  <textarea class="form-control" style="height:190px;" readonly="">Address: <?php echo $show['Address']; ?></textarea>






  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    
    <h3>#Register Business</h3>
    

    <?php
//Register new business
  

    if(isset($_POST['add_biz'])){

      $biz_name=prepare($_POST['name']);
      $biz_type=prepare($_POST['type']);

      $add = $conn->query("Insert into business(Tin, Name, Type) values('$tin', '$biz_name', '$biz_type')");

      if($add>0){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Your Business has been registered successfully.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
      }
      else{
     echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Try again some other time.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';

      }
    }


    ?>

    <form action="" method="POST">
      <p>Select Business type</p>
      <select name="type" class="form-control" >

        <option value="">--Select--</option>
        <?php 
        $type = $conn->query("Select * from rents");
        while($all_types = mysqli_fetch_array($type)){
        $name = $all_types['RentType'];
        echo "<option value='$name'>$name</option>";

      }
        ?>
      </select>
        <p>Enter name of Business</p>
        <textarea  name="name" class="form-control" style="height:100px"></textarea>

      </select>
      
      <input type="submit" name="add_biz" style="margin-top: 7px;" class="btn btn-info" value="Submit">
    </form>

<br />


     <table class="table table-bordered table-striped">
      <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Type</th>
        <th>Tax Amount</th>
        <th>Action</th>
      </tr>

      <?php 

      if(isset($_POST['delete'])){
        $id= prepare($_POST['id']);

          $delete = $conn->query("Delete from business where Id='$id' ");

          if($delete==true){
            echo "<script>alert('Business has been removed successfully');</script>";
          
        }
      }


      

      $biz = $conn->query("select * from business Where Tin='$tin' ");
      $sn =0;
      while($all_biz = mysqli_fetch_array($biz)){
        $sn++;
        $type =  $all_biz['Type'];
        $tax_ql=$conn->query("Select Price from rents Where RentType='$type' ");
        $fetch = mysqli_fetch_array($tax_ql);

       $tax = (10/100)*$fetch['Price'];
      ?>
      <tr>
        <td><?php echo $sn; ?></td>
        <td><?php echo $all_biz['Name']; ?></td>
        <td><?php echo $all_biz['Type']; ?></td>
        <td><?php echo $tax; ?></td>
        <td>

        <form action="" method="POST">
          <input type="hidden" name="id" value="<?php echo $all_biz['Id']; ?>">
          <input type="submit" name="delete" value="Delete" class="btn btn-sm btn-danger">
        </form>


        </td>
      </tr>
      <?php
    }
      ?>
    </table>

    




  </div>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">


     <table class="table table-bordered table-striped">
      <tr>
        <th>Id</th>
        <th>TIN</th>
        <th>Amount</th>
        <th>Date</th>
        <th>#Print</th>
      </tr>

      <?php 

      if(isset($_POST['delete'])){
        $id= prepare($_POST['id']);

          $delete = $conn->query("Delete from business where Id='$id' ");

          if($delete==true){
            echo "<script>alert('Business has been removed successfully');</script>";
          
        }
      }


      

      $trans = $conn->query("select * from transaction Where Tin='$tin' ");
      $sn =0;
      while($all_trans = mysqli_fetch_array($trans)){
        $sn++;
               
      ?>
      <tr>
        <td><?php echo $sn; ?></td>
        <td><?php echo $tin; ?></td>
        <td><?php echo $all_trans['Amount']; ?></td>
        <td><?php echo $all_trans['Date']; ?></td>
       
        <td>

          <button type="button" class="btn btn-sm btn-info"><i class="fa fa-print"></i></button>
      


        </td>
      </tr>
      <?php
    }
      ?>
    </table>

  </div>
</div>
</div>
</div>




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
