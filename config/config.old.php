<?php
$config['allowed_ip'][] = '172.18.0.104';
$config['allowed_ip'][] = '192.168.122.108';
$config['allowed_ip'][] = '172.18.0.50';

$config['outlet'][1]['name'] = 'Lower Trees 1';
$config['outlet'][2]['name'] = 'Lower Tree 2';
$config['outlet'][3]['name'] = 'Upper Icicle';
$config['outlet'][4]['name'] = 'Lower Icicle';
$config['outlet'][5]['name'] = 'Front Door';
$config['outlet'][6]['name'] = 'Outlet 6';
$config['outlet'][7]['name'] = 'Outlet 7';
$config['outlet'][8]['name'] = 'Outlet 8';

function GetConfig() {
	global $config;
	return $config;
}
