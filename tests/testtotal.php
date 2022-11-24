<?php
class testtotal extends \PHPUnit\Framework\TestCase {
    public function testdiscount() {
        $dis = new App\total;
        $res = $dis->discount(120);
        $this->assertEquals(13,$res);
    }
    public function testgrand() {
        $dis = new App\total;
        $res = $dis->grand(13,120);
        $this->assertEquals(108,$res);
    }
 }
?>