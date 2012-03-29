<?php

require_once 'Program.php';
require_once 'PHPUnit/Framework/TestSuite.php';

class OptionTest extends PHPUnit_Framework_TestCase {
	public function setup() {
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testMoreThanTwoOptionNameParameterShouldFail() {
		$option = new Option('-p, --peppers, ---peppppers', 'Tastes extra good', 'peppers');
	}
}
