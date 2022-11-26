<?php
namespace App;

class allotdelivery{
   public function firstagent($pincode)
   {
    $conn = mysqli_connect('localhost', 'root', '','shop_db');
    $query = "SELECT did FROM delivery_agent where {$pincode} and status='available' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_num_rows($result);
    if($row!=0)
    {
    $result = $result->fetch_array();
    $result = intval($result[0]);
    }
    else{
      $result = 0;
    }
    return $result;
   }
}
?>