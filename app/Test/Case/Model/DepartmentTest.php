<?php
/* Department Test cases generated on: 2011-12-01 13:57:26 : 1322769446*/
App::uses('Department', 'Model');

/**
 * Department Test Case
 *
 */
class DepartmentTestCase extends CakeTestCase {
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

		$this->Department = ClassRegistry::init('Department');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Department);

		parent::tearDown();
	}

}
