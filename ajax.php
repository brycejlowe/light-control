<?php
require_once 'includes/security.php';
require_once 'includes/outletcollection.php';

// arguments
$outlet = (isset($_GET['outlet'])) ? explode(',', $_GET['outlet']) : array();
$state = (isset($_GET['state'])) ? strtolower($_GET['state']) : false;

// argument validation
$result = array();
// a valid state is required
if (!$state) {
	$result['status'] = 'ERROR';
	$result['message'] = 'Valid Outlet State is Required';
}
// at least one outlet is required
else if (count($outlet) == 0) {
	$result['status'] = 'ERROR';
	$result['message'] = 'Valid Outlet is Required';
}
// anything else passes the sniff test for validity
else {
	$outlets = NULL;
	if (in_array(0, $outlet)) {
		$outlets = OutletCollection::getAll();
	}
	else {
		$outlets = OutletCollection::getByIds($outlet);
	}

	$error = array();
	foreach ($outlets as $outlet_obj) {
		try {
			if ($state == 'on') {
				$outlet_obj->turnOn();
			}
			else {
				$outlet_obj->turnOff();
			}
		}
		catch (Exception $e) { 
			array_push($error, sprintf("Error Setting Outlet %s (%s) State to %s - '%s'", $outlet_obj->getName(), $outlet_obj->getId(), $state, $e->getMessage()));
		}		
	}

	if (count($error) == 0) {
		$result['status'] = 'OK';
		$result['message'] = 'Operation Completed Successfully';
	}
	else {
		$result['status'] = 'ERROR';
		$result['message'] = implode("\n", $error);
	}
}

header('Content-Type: application/json');
echo json_encode($result);
