<?php
require_once 'includes/security.php';
require_once 'includes/outletcollection.php';

$start = microtime(true);
$outlets = OutletCollection::getAll();
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/js/index.css">
<link rel="stylesheet" href="//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<script src="/js/index.js"></script>
</head>
<body>

<div data-role="page">
  <div data-role="header">
    <h1>Light Control</h1>
  </div>

  <div data-role="main" class="ui-content">
	<div class="center-wrapper">
	<?php
	foreach ($outlets as $outlet) {
		print '
		<label for="outlet-' . $outlet->getId() . '">' . $outlet->getName() . ':</label>
		<select name="slider" id="outlet-' . $outlet->getId() . '" class="outlet" data-role="slider">
			<option value="off"' . (($outlet->isOff()) ? ' selected="SELECTED" ' : '' )  . '>Off</option>
			<option value="on"' . (($outlet->isOn()) ? ' selected="SELECTED" ' : '' )  . '>On</option>
		</select>';
	}
	print '
		<a href="#all-on" class="ui-btn all-button">All On</a>
		<a href="#all-off" class="ui-btn all-button">All Off</a>';
	?>
	</div>
  </div>

  <div data-role="footer">
    <h2>Load Time: <?php print round(microtime(true) - $start, 3); ?></h2>
  </div>
</div> 
</body>
</html>
