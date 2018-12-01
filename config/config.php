<?php
class Config {
	private $file = 'config/config-file.php';
	private $config;

	private static $INSTANCE;

	public static function getInstance() {
		if (!is_object(self::$INSTANCE)) {
			self::$INSTANCE = new self;
		}

		return self::$INSTANCE;
	}

	public static function setInstance(Config $config) {
		self::$INSTANCE = $config;
		return self::getInstance();
	}

	public function __construct($file = null) {
		if (!is_null($file)) {
			$this->file = $file;
		}

		include $this->file;
		$this->config = $config;		
	}

	public function getConfig($key) {
		if (!isset($this->config[$key])) {
			throw new \InvalidArgumentException("Unknown Configuration Key '$key'");
		}

		return $this->config[$key];
	}


	public function getOutlet($id = null) {
		// retrieve the outlet section of the configuration
		$config = $this->getConfig('outlet');
		if (is_null($id)) {
			return $config;
		}

		// validate the provided id matches an outlet
		if (!isset($config[$id])) {
			throw new \InvalidArgumentException("Unknown Outlet '$id'");
		}

		return $config[$id];
	}
}
