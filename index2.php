<?php
include 'includes/outletcollection.php';

print "hi";

try {
	$outlet_collection = OutletCollection::getByIds(array(1,2));
	//$outlet_collection = OutletCollection::getAll();
	foreach ($outlet_collection as $outlet) {
		print $outlet->getName() . " is " . (($outlet->isOn()) ? "on" : "off");
	}
}
catch (Exception $e) {
	print "Error: " . $e->getMessage();
}
