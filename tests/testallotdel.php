<?php
class testallotdel extends \PHPUnit\Framework\TestCase{
   public function testvendor()
   {
        $dis = new App\allotdelivery; 
        $res = $dis->firstagent(400000);
        $this->assertEquals(64,$res);
   }
}
?>