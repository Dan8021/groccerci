<?php

@include 'config.php';

session_start();

$aid = $_SESSION['aid'];

if(!isset($aid)){
   header('location:login.php');
};


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
   
<?php include 'admin_header.php'; ?>

<section class="placed-orders">

   <h1 class="title">all orders</h1>

   <div class="box-container">

   <?php
      $select_orders = $conn->prepare("SELECT orders.name, orders.placed_on, orders.number, orders.email, orders.address, orders.total_products, orders.total_price, orders.status FROM orders");
      $select_orders->execute();
      $select_orders1 = $conn->prepare("SELECT vendor.name, vendor.phno, vendor.address FROM vendor");
      $select_orders1->execute();
      $fetch_orders1 = $select_orders1->fetch(PDO::FETCH_ASSOC);

      $select_orders2 = $conn->prepare("SELECT delivery_agent.name, delivery_agent.phno  FROM orders,delivery_agent WHERE orders.did=delivery_agent.did");
      $select_orders2->execute();
      $fetch_orders2 = $select_orders2->fetch(PDO::FETCH_ASSOC);

      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <div class="box">
      <p> placed on : <span><?= $fetch_orders['placed_on']; ?></span> </p>
      <p> customer name : <span><?= $fetch_orders['name']; ?></span> </p>
      <p> number : <span><?= $fetch_orders['number']; ?></span> </p>
      <p> email : <span><?= $fetch_orders['email']; ?></span> </p>
      <p> address : <span><?= $fetch_orders['address']; ?></span> </p>
     
      <p> your orders : <span><?= $fetch_orders['total_products']; ?></span> </p>
      <p> total price : <span>₹<?= $fetch_orders['total_price']; ?>/-</span> </p>
      <p> status : <span style="color:red"> <?= $fetch_orders['status']; ?> </span> </p>
      <p> vendor name : <span><?= $fetch_orders1['name']; ?></span> </p>
      <p> vendor number : <span><?= $fetch_orders1['phno']; ?></span> </p>
      <p> delivery agent name : <span><?= $fetch_orders2['name']; ?></span> </p>
      <p> delivery agent number : <span><?= $fetch_orders2['phno']; ?></span> </p>
      </div>
       <?php   }
       
      }
      else{
         echo '<p class="empty">no new requests!</p>';
      }
      ?>

   </div>

</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>