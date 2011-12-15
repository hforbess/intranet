<?php
/* Employee Test cases generated on: 2011-12-01 14:00:22 : 1322769622*/
App::uses('Employee', 'Model');

/**
 * Employee Test Case
 *
 */
class EmployeeTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.employee', 'app.group', 'app.department', 'app.group', 'app.time_clock');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Employee = ClassRegistry::init('Employee');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Employee);

		parent::tearDown();
	}

}
