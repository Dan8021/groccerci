<?php

@include 'config.php';

session_start();

$did = $_SESSION['did'];

if(!isset($did)){
   header('location:login.php');
};

if(isset($_GET['yes'])){

   $yes = $_GET['yes'];
   $complete_orders = $conn->prepare("UPDATE `orders` SET status = ? WHERE id = ?");
   $complete_orders->execute(['completed',$yes]);

      $change_status = $conn->prepare("UPDATE `delivery_agent` SET status='available' WHERE did = ?");
      $change_status->execute([$did]);
   header('location:deliveryagent_page.php');


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
   
<?php include 'delivery_header.php'; ?>

<section class="placed-orders">

   <h1 class="title"> orders</h1>

   <div class="box-container">

      <?php
         $select_orders = $conn->prepare("SELECT * FROM orders WHERE did=? and status='accepted'");
         $select_orders->execute([$did]);
         
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
               <a href="current_orders.php?yes=<?= $fetch_orders['id']; ?>" class="delete-btn" style="background-color:green">COMPLETE</a>
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

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>