<?php 

    require_once './app/binCaid.php';
    
    class binCaidTest extends \PHPUnit\Framework\TestCase {
        public function testAdd(){
            $bincaid = new binCaid();
            $result = $bincaid->add("bin15","caid15",0,"add bin caid15","AD");

            $this->assertEquals(true, $result);

        }

        public function testMerchantAdd(){
            $bincaid = new binCaid();
            $result = $bincaid->merchantAdd(5,5);

            $this->assertEquals(true, $result);

        }

        public function testEnable(){
            $bincaid = new binCaid();
            $result = $bincaid->enable(5);

            $this->assertEquals(true, $result);
        }

        public function testIsEnable(){
            $bincaid = new binCaid();
            $result = $bincaid->isEnable(5);

            $this->assertEquals(true, $result);

        }
    }
?>