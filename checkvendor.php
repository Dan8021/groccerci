<?php
namespace App;

class checkvendor{
   public function checkv($pincode)
   {
    $conn = mysqli_connect('localhost', 'root', '','shop_db');
    $query = "SELECT vid FROM vendor where pincode = $pincode";
    $result = mysqli_query($conn, $query);
    $row = mysqli_num_rows($result);
    return $row;
   }
}

?>