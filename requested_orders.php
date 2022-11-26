<?php

@include 'config.php';

session_start();

$vid = $_SESSION['vid'];

if(!isset($vid)){
   header('location:login.php');
};

if(isset($_GET['yes']))
{
   $yes = $_GET['yes'];
   $get_pincode = $conn->prepare("SELECT pincode FROM orders WHERE id=? ");
   $get_pincode->execute([$yes]);
      while($row = $get_pincode->fetch(PDO::FETCH_ASSOC)){
      $pincode= $row['pincode'];
      }
include ('allotdelivery.php');
$new = new App\allotdelivery();
$agentid = $new -> firstagent($pincode);
$did = $agentid;

if($did == 0)
{
   echo '<script>alert("No delivery Agent Found In Area Please Try Again Later")</script>';
}

else{
   $yes = $_GET['yes'];
   $accept_orders = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
   $accept_orders->execute(['accepted',$yes]);
   $allot_orders = $conn->prepare("UPDATE `orders` SET did=? WHERE id = ?");
   $allot_orders->execute([$did,$yes]);
   $change_status = $conn->prepare("UPDATE `delivery_agent` SET status='unavailable' WHERE did = ?");
   $change_status->execute([$did]);

   $order_details = $conn->prepare("SELECT * FROM orders where vid=?");
         $order_details->execute([$vid]);
         
         if($order_details->rowCount() > 0){
            while($fetch_orders = $order_details->fetch(PDO::FETCH_ASSOC)){
      
     
         $cid = $fetch_orders['cid']; 
         $placed_on= $fetch_orders['placed_on']; 
         $name= $fetch_orders['name']; 
         $email= $fetch_orders['email']; 
         $number= $fetch_orders['number']; 
         $address= $fetch_orders['address']; 
         $total_products= $fetch_orders['total_products']; 
         $total_price= $fetch_orders['total_price']; 
            }
   $block_orders = $conn->prepare("UPDATE `orders` SET status = ? WHERE name=? and number=? and email=? and address=? and total_products=? and total_price=? and placed_on=? and status='requested' ");
   $block_orders->execute(['blocked',$name,$number,$email,$address,$total_products,$total_price,$placed_on]);
         }}
}

if(isset($_GET['delete'])){

   $reject_id = $_GET['delete'];
   $reject_orders = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
   $reject_orders->execute(['rejected',$reject_id]);
   header('location:requested_orders.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body style = "background-image:none">
   
<?php include 'vendor_header.php'; ?>

<section class="placed-orders">

   <h1 class="title">requested orders</h1>

   <div class="box-container">

      <?php
         $select_orders = $conn->prepare("SELECT * FROM orders WHERE vid=? and status='requested'");
         $select_orders->execute([$vid]);
         
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box">
         <p> user id : <span><?= $fetch_orders['cid']; ?></span> </p>
         <p> placed on : <span><?= $fetch_orders['placed_on']; ?></span> </p>
         <p> name : <span><?= $fetch_orders['name']; ?></span> </p>
         <p> email : <span><?= $fetch_orders['email']; ?></span> </p>
         <p> number : <span><?= $fetch_orders['number']; ?></span> </p>
         <p> address : <span><?= $fetch_orders['address']; ?></span> </p>
         <p> total products : <span><?= $fetch_orders['total_products']; ?></span> </p>
         <p> total price : <span>₹<?= $fetch_orders['total_price']; ?>/-</span> </p>
         <p> status : <span style="color:red"><?= $fetch_orders['status']; ?></span> </p>   

         
         
            <div class="flex-btn">
               <a href="requested_orders.php?yes=<?= $fetch_orders['id']; ?>" class="delete-btn" style="background-color:green" onclick="return confirm('accept this order?');">ACCEPT</a>
               <a href="requested_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('reject this order?');">REJECT</a>
            </div>
         
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no new requests!</p>';
      }
      ?>

   </div>

</section>

<script src="js/script.js"></script>

</body>
</html>