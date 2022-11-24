<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['cid'];

class Customer{
   public function UpdateDetails($conn){

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['update_profile'])){
   $old_pass = $_POST['old_pass'];
   $update_pass = md5($_POST['update_pass']);
   $update_pass = filter_var($update_pass, FILTER_SANITIZE_STRING);
   $new_pass = md5($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = md5($_POST['confirm_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   if(!empty($update_pass) AND !empty($new_pass) AND !empty($confirm_pass)){
      if($update_pass != $old_pass){
         $message[] = 'old password not matched!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'confirm password not matched!';
      }else{
         $update_pass_query = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
         $update_pass_query->execute([$confirm_pass, $user_id]);
         $message[] = 'password updated successfully!';
      }
   }

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $emailId = $_POST['email'];
   $emailId = filter_var($emailId, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $pincode = $_POST['pincode'];
   $pincode = filter_var($pincode, FILTER_SANITIZE_STRING);
   $phoneNumber = $_POST['phno'];
   $phoneNumber = filter_var($phoneNumber, FILTER_SANITIZE_STRING);

   $update_profile = $conn->prepare("UPDATE `users` SET  email = ? WHERE id = ?");
   $update_profile->execute([$emailId, $user_id]);
   $update_profile = $conn->prepare("UPDATE `customer` SET  name = ?, address = ?, pincode = ? , phno =? WHERE cid = ?");
   $update_profile->execute([$name, $address, $pincode ,$phoneNumber, $user_id]);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;
   $old_image = $_POST['old_image'];

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image = $conn->prepare("UPDATE `customer` SET image = ? WHERE cid = ?");
         $update_image->execute([$image, $user_id]);
         if($update_image){
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('uploaded_img/'.$old_image);
            $message[] = 'image updated successfully!';
         };
      };
   };
}
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update user profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/components.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="update-profile">

   <h1 class="title">update profile</h1>

   <form action="" method="POST" enctype="multipart/form-data">
      <img src="uploaded_img/<?= $fetch_profile['image']; ?>" alt="">
      <div class="flex">
         <div class="inputBox">
            <span>username :</span>
            <input type="text" name="name" value="<?= $fetch_profile['name']; ?>" placeholder="update username" required class="box">
            <span>email :</span>
            <input type="email" name="email" value="<?= $fetch_profile1['email']; ?>" placeholder="update email" required class="box">
            <span>update pic :</span>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box">
            <input type="hidden" name="old_image" value="<?= $fetch_profile['image']; ?>">
            <span>pincode :</span>
            <input type="tel" name="pincode" class = "box" value="<?= $fetch_profile['pincode']; ?>" placeholder="enter your pincode" maxlength="6" required>
            <span>address: :</span>
            <textarea name="address" class="box" value="<?= $fetch_profile['address']; ?>"required placeholder="enter your address" cols="30" rows="03"></textarea>
         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="<?= $fetch_profile1['password']; ?>">
            <span>old password :</span>
            <input type="password" name="update_pass" placeholder="enter previous password" class="box">
            <span>new password :</span>
            <input type="password" name="new_pass" placeholder="enter new password" class="box">
            <span>confirm password :</span>
            <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
            <span>phone number :</span>
            <input type="tel" name="phno" class = "box" value="<?= $fetch_profile['phno']; ?>" placeholder="enter your phone number" maxlength="10" required>
         </div>
      </div>
      <div class="flex-btn">
         <input type="submit" class="btn" value="update profile" name="update_profile">
         <a href="home.php" class="option-btn">go back</a>
      </div>
   </form>

</section>

<?php include 'footer.php'; ?>


<script src="js/script.js"></script>

</body>
</html>