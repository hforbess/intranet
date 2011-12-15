<?php
/* Employees Test cases generated on: 2011-12-01 14:02:47 : 1322769767*/
App::uses('EmployeesController', 'Controller');

/**
 * TestEmployeesController *
 */
class TestEmployeesController extends EmployeesController {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * EmployeesController Test Case
 *
 */
class EmployeesControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.employee', 'app.group', 'app.department', 'app.time_clock');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Employees = new TestEmployeesController();
		$this->Employees->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Employees);

		parent::tearDown();
	}

}
