<?php

include 'config.php';
class DeliveryAgent{
   public function RegisterDeliveryAgent($conn){
if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $password = md5($_POST['pass']);
   $password = filter_var($password, FILTER_SANITIZE_STRING);
   $cpass = md5($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($cpass, FILTER_SANITIZE_STRING);
   $pin = $_POST['pin'];
   $working_hours = 8; 
   $status = 'working';
   $phoneNumber = $_POST['phone'];
   $currentOrderId = 'null';

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select->execute([$email]);

   if($select->rowCount() > 0){
      $message[] = 'user email already exist!';
   }else{
      if($password != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         $insert = $conn->prepare("INSERT INTO `users`(email, password, user_type) VALUES(?,?,?)");
         $insert->execute([$email, $password, 'delivery_agent']);
      }
   }

	$getuid = $conn->prepare("SELECT id FROM users WHERE email = ?;");
	$getuid->execute([$email]);

	if($getuid->rowCount()>0){
		while($row = $getuid -> fetch(PDO::FETCH_ASSOC)){
			$userid=$row['id'];         
         $insert = $conn->prepare("INSERT INTO delivery_agent(did,name,address,pincode,phno,image) VALUES(?,?,?,?,?,?);");
         $insert->execute([$userid, $name, $address,$pin,$phoneNumber,$image]);
         if($insert){
            if($image_size > 2000000){
               $message[] = 'image size is too large!';
            }else{
               move_uploaded_file($image_tmp_name, $image_folder);
               $message[] = 'registered successfully!';
               header('location:login.php');
            }

         }
			
	}
}}}       
      } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/components.css">

</head>
<body>

<?php

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?>
   
<section class="form-container">

   <form action="" enctype="multipart/form-data" method="POST">
      <h3>register now</h3>
      <input type="text" name="name" class="box" placeholder="enter your name" required>
      <input type="email" name="email" class="box" placeholder="enter your email" required>
      <input type="password" name="pass" class="box" placeholder="enter your password" required>
      <input type="password" name="cpass" class="box" placeholder="confirm your password" required>
      <input type="tel" name="pin" class = "box" placeholder="enter your pincode" maxlength="6" required>
      <input type="tel" name="phone" class = "box" placeholder="enter your phone number" maxlength="10" required>
      <textarea name="address" class="box" required placeholder="enter your address" cols="30" rows="03"></textarea>
      <input type="file" name="image" class="box" required accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="register now" class="btn" name="submit">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</section>


<script src="js/script.js"></script>
<?php 
$new = new DeliveryAgent();
$new-> RegisterDeliveryAgent($conn);
?>
</body>
</html>