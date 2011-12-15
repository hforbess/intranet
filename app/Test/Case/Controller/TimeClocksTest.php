<?php
/* TimeClocks Test cases generated on: 2011-12-01 14:04:14 : 1322769854*/
App::uses('TimeClocks', 'Controller');

/**
 * TestTimeClocks *
 */
class TestTimeClocks extends TimeClocks {
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
 * TimeClocks Test Case
 *
 */
class TimeClocksTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.group', 'app.employee', 'app.department', 'app.time_clock', 'app.timeclock');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->TimeClocks = new TestTimeClocks();
		$this->->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TimeClocks);

		parent::tearDown();
	}

}
