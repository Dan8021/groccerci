<?php

@include 'config.php';

session_start();

$vid = $_SESSION['vid'];

if(!isset($vid)){
   header('location:login.php');
};

if(isset($_GET['yes'])){

   $yes = $_GET['yes'];
   $accept_orders = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
   $accept_orders->execute(['accepted',$yes]);
   header('location:vendor_orders.php');

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

   <h1 class="title">all orders</h1>

   <div class="box-container">

      <?php
         $select_orders = $conn->prepare("SELECT orders.cid,orders.name,orders.number,orders.email,orders.address,orders.total_products,orders.total_price,orders.placed_on,orders.status, delivery_agent.name, delivery_agent.phno FROM orders,delivery_agent WHERE orders.did=delivery_agent.did;");
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
         <p> delivery agent id : <span>₹<?= $fetch_orders['did']; ?></span> </p>
         <p> delivery agent name : <span>₹<?= $fetch_orders['name']; ?></span> </p>
         <p> delivery agent phone number : <span>₹<?= $fetch_orders['phno']; ?></span> </p>
              
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
      ?>

   </div>

</section>

<script src="js/script.js"></script>

</body>
</html>