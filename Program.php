<?php

/**
 * Description of Commander
 *
 * @author ole
 */
class Program {

	public $version = '';
	public $options = null;


	public function __construct() {
		$this->options = new stdClass();
	}

	public function version($version) {
		$this->version = $version;
	}

	public function option($options, $desc, $default = '') {
		$option = new Option($options, $desc, $default);
		$this->options->{$option->long_name} = $option;
	}

	public function parse($args) {
		$options = $this->parseCliOptions($args);
		foreach ($options as $option) {

		}
	}

	protected function parseCliOptions($args) {
		$matches = array();
		foreach ($args as $arg) {
			if (strstr($arg, '-') || strstr($arg, '--')) {
				$arg = preg_replace('/-/', '', $arg);
				$this->checkArg($arg);
				$matches[] = $arg;
			}
		}
		return $matches;
	}

	protected function checkArg($arg) {
		$found = false;
		foreach ($this->options as $long_name => $option) {
			if ($arg == $option->short_name) {
				$found = true;
			}
		}
		if (!$found) {
			throw new ParameterDoesNotExistException();
		}
	}

	public function __get($name) {
		return $this->options->$name->default;
	}

}

class Option {

	public $default = '';
	public $long_name = '';
	public $short_name = '';
	public $description = '';
	public $value = null;

	const ALLOWED_AMOUNT_OF_ARGUMENTS = 2;

	public function __construct($options, $description, $default) {
		$this->parse($options);
		$this->description = $description;
		$this->default = $default;
	}

	protected function parse($options) {
		$option_parts = array_map(function($part) {
					return preg_replace('/-/', '', trim($part));
				}, preg_split('/,/', $options));
		sort($option_parts);

		if (count($option_parts) > self::ALLOWED_AMOUNT_OF_ARGUMENTS) {
			throw new InvalidArgumentException(sprintf('Excepted no more than %d arguments', self::ALLOWED_AMOUNT_OF_ARGUMENTS));
		}

		$this->long_name = $option_parts[1];
		$this->short_name = $option_parts[0];
	}

}

class ParameterDoesNotExistException extends Exception {}