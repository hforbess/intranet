<?php
/* Departments Test cases generated on: 2011-12-01 14:02:25 : 1322769745*/
App::uses('DepartmentsController', 'Controller');

/**
 * TestDepartmentsController *
 */
class TestDepartmentsController extends DepartmentsController {
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
 * DepartmentsController Test Case
 *
 */
class DepartmentsControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.department');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Departments = new TestDepartmentsController();
		$this->Departments->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Departments);

		parent::tearDown();
	}

}
