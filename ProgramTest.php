<?php

require_once 'Program.php';
require_once 'PHPUnit/Framework/TestSuite.php';

class ProgramTest extends PHPUnit_Framework_TestCase {

	/**
	 *
	 * @var Program
	 */
	public $program = null;
	public $version = '0.0.1';
	public $default = 'feta';

	public function setup() {
		$this->program = new Program();
		$this->program->version($this->version);
		$this->program->option('-c, --cheese', 'Choose favorite kind of cheese', $this->default);
	}

	public function testVersionShouldGetStored() {
		$this->assertEquals($this->program->version, $this->version);
	}

	public function testOptionParameterShouldGetStored() {
		$this->program->option('-p, --peppers', 'Tastes damn good');
		$this->assertInstanceOf('Option', $this->program->options->peppers);
	}

	public function testOptionCanHandleDefaultParameter() {

		$this->assertEquals($this->program->options->cheese->default, $this->default);
	}

	public function testOptionShortNameShouldGetStored() {}

	/**
	 * @expectedException ParameterDoesNotExistException
	 */
	public function testParameterDoesNotExist() {
		$this->program->parse(array(0 => 'app.php', 1 => '-m', 2 => '12'));
	}

	public function testForParamValue() {
		$this->program->parse(array(0 => 'app.php', 1 => '-c', 2 => '12'));
		$this->assertEquals($this->program->cheese, '12');
	}

}