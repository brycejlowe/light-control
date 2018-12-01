<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');

function GetOutlets() {
	$config = GetConfig();
	return $config['outlet'];
}

function SetOutletState($id, $state, &$response = NULL) {
	$id = (int)$id;
	
	$exit_code = -1;
	exec("/usr/bin/perl /usr/local/bin/light-pi/light-pi.pl --outlet $id --action $state", $response, $exit_code);
	
	return $exit_code;

}

function GetOutletState($id, &$state = NULL) {
	$id = (int)$id;
	
	$exit_code = -1;
	$stdout = NULL;
	exec("/usr/bin/perl /usr/local/bin/light-pi/light-pi.pl --outlet $id --action status", $stdout, $exit_code);
	$state = json_decode($stdout[0]);

	return $exit_code;
}

function ToggleLightState($id) {
	// get the current state of the outlet requested
	$current_state = GetLightState($id);
	if ($current_state == "ON") {
		
	}
	return 0;
}
