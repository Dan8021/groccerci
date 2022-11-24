<?php


class testvendor extends \PHPUnit\Framework\TestCase{
   public function testvendor()
   {
        $dis = new App\checkvendor; 
        $res = $dis->checkv(400000);
        $this->assertGreaterthan(0,$res);
   }
}
?>