<?php
class Outlet {
	private $outlet_id;
	private $outlet;

	// constants representing an outlet state
	const OUTLET_ON = 0;
	const OUTLET_OFF = 1;

	// the executable path for wiring pi
	private static $GPIO_PATH = '/usr/local/bin/gpio';

	public function __construct($outlet_id) {
		// validate the outlet exists
		$config = Config::getInstance();
		
		// set class level variables
		$this->outlet_id = (int)$outlet_id;
		$this->outlet = $config->getOutlet($this->outlet_id);
	}

	public function getId() {
		return $this->outlet_id;
	}

	public function getName() {
		return $this->outlet['name'];
	}

	public function getPin() {
		return $this->outlet['pin'];
	}

	public function isOn() {
		return ($this->getState() == self::OUTLET_ON);
	}

	public function isOff() {
		return ($this->getState() == self::OUTLET_OFF);
	}

	private function getState() {
		return $this->doGpioCommand(sprintf("read %s", $this->outlet['pin']));
	}

	public function turnOff() {
		return $this->setState(self::OUTLET_OFF);
	}

	public function turnOn() {
		return $this->setState(self::OUTLET_ON);
	}

	private function setState($state) {
		// set the mode to output
		$this->doGpioCommand(sprintf("mode %s output", $this->outlet['pin']));

		// execute the command to change the state
		$this->doGpioCommand(sprintf("write %s %s", $this->outlet['pin'], $state));

		return $this->getState();
	}

	private function doGpioCommand($command) {
		// build the gpio command
		$command = sprintf("%s %s", self::$GPIO_PATH, $command);
		
		// execute the command or throw an exception if an error ocurred
		$stdout = null;
		$stderr = null;
		if ($this->doCommand($command, $stdout, $stderr) == 0) {
			return $stdout;
		}
		else {
			throw new \Exception(sprintf("Command Failed with Error - %s", rtrim($stderr, "\n")));
		}

	}

	private function doCommand($command, &$stdout = null, &$stderr = null) {
		$pipes = null;

		$proc = proc_open($command, [
			1 => ['pipe','w'],
			2 => ['pipe','w'],
	    	], $pipes);

		$stdout = stream_get_contents($pipes[1]);
		fclose($pipes[1]);

		$stderr = stream_get_contents($pipes[2]);
		fclose($pipes[2]);

		$result = proc_close($proc);
    		return $result;
	}

}
