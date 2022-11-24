<?php
namespace App;

class preproduct{
   public function prepro($name)
   {
    $conn = mysqli_connect('localhost', 'root', '','shop_db');
    $query = "SELECT * FROM products WHERE name = '$name'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_num_rows($result);
    if($row > 0 )
    {
     $flag = false;
   }
    else{
     $flag = true;
    }
    return $flag;
   }
}

?>