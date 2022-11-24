<?php

class testproduct extends \PHPUnit\Framework\TestCase{
   public function testproduct()
   {
        $dis = new App\preproduct; 
        $res = $dis->prepro('apple');
        $this->assertEquals(false,$res);
   }
}
?>