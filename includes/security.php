<?php
require_once 'config/config.php';
$config = Config::getInstance();

if (!in_array($_SERVER['REMOTE_ADDR'], $config->getConfig('allowed_ip'))) {
	header('HTTP/1.0 403 Forbidden');
	exit();
}
