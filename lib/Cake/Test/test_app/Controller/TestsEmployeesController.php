<?php
require_once('/var/www/intranet/app/Controller/EmployeesController.php');
class EmployeesControllerTest extends PHPUnit_Framework_TestCase
{
  var $pay_period;
  public function setUp()
  {
     $this->pay_period = '2011-12-01';
  }
  public function tearDown(){ }
  public function testGetPayPeriod()
  {
    // test to ensure that the object from an fsockopen is valid
    $empObj = new EmployeesController();
    $this->assertTrue($empObj->getPayPeriod() == $this->pay_period);
  }
}
?>
