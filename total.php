<?php
namespace App;

class total{
   public function discount($total)
   {
      return (($total*10)/100);
   }

   public function grand($discount,$total)
   {
      return $total-$discount;
   }
}
?>