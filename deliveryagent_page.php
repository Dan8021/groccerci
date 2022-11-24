<?php

@include 'config.php';

session_start();

$did = $_SESSION['did'];

if(!isset($did)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Delivery Agent page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'delivery_header.php'; ?>

<section class="dashboard">

   <h1 class="title">dashboard</h1>

   <div class="box-container">

   <div class="box">
      <?php //DisplayStatus()
         $total_requests = 0;
         $total_requested = $conn->prepare("SELECT * FROM `orders` WHERE status = ? and did=?");
         $total_requested->execute(['accepted',$did]);
         while($fetch_requested = $total_requested->fetch(PDO::FETCH_ASSOC)){
            $total_requests = $total_requested->rowCount();
         };
      ?>
      <h3><?= $total_requests; ?></h3>
      <p>current orders</p>
      <a href="current_orders.php" class="btn">see current order</a>
      </div>

      <div class="box">
      <?php //Dileiver() 
         $total_requests = 0;
         $total_requested = $conn->prepare("SELECT * FROM `orders` WHERE status = ? and did=?");
         $total_requested->execute(['completed',$did]);
         while($fetch_requested = $total_requested->fetch(PDO::FETCH_ASSOC)){
            $total_requests = $total_requested->rowCount();
         };
      ?>
      <h3><?= $total_requests; ?></h3>
      <p>total completed orders</p>
      <a href="delivery_orders.php" class="btn">see past orders</a>
      </div>
   </div>

</section>
<script src="js/script.js"></script>

</body>
</html>