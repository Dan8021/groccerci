<?php

@include 'config.php';
session_start();
$vid = $_SESSION['vid'];

if(!isset($vid)){
   header('location:login.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Vendor page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body style = "background-image:none">
   
<?php include 'vendor_header.php'; ?>

<section class="dashboard">

   <h1 class="title">dashboard</h1>

   <div class="box-container">

   <div class="box">
      <?php
         $total_requests = 0;
         $total_requested = $conn->prepare("SELECT * FROM `orders` WHERE status = ? and vid=?");
         $total_requested->execute(['requested',$vid]);
         while($fetch_requested = $total_requested->fetch(PDO::FETCH_ASSOC)){
            $total_requests = $total_requested->rowCount();
         };
      ?>
      <h3><?= $total_requests; ?></h3>
      <p>requested orders</p>
      <a href="requested_orders.php" class="btn">see orders</a>
      </div>

      <div class="box">
      <?php
         $total_requests = 0;
         $total_requested = $conn->prepare("SELECT * FROM `orders` WHERE status = ? and vid=?");
         $total_requested->execute(['completed',$vid]);
         while($fetch_requested = $total_requested->fetch(PDO::FETCH_ASSOC)){
            $total_requests = $total_requested->rowCount();
         };
      ?>
      <h3><?= $total_requests; ?></h3>
      <p>total orders</p>
      <a href="vendor_orders.php" class="btn">see orders</a>
      </div>

      

      <div class="box">
      <?php
         $select_products = $conn->prepare("SELECT * FROM `products` where vid=?");
         $select_products->execute([$vid]);
         $number_of_products = $select_products->rowCount();
      ?>
      <h3><?= $number_of_products; ?></h3>
      <p>products</p>
      <a href="vendor_products.php" class="btn">see products</a>
      </div>

</section>
<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>