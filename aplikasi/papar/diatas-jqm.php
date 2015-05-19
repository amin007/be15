<!DOCTYPE html>
<html>
<head>
<title><?php echo !isset($tajuk) ? 'Kosong':$tajuk; ?></title>
<?php
/*
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.5.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.js"></script>
*/
?>
<!-- Include meta tag to ensure proper rendering and touch zooming -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Include jQuery Mobile stylesheets -->
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<!-- Include the jQuery library -->
<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
<!-- Include the jQuery Mobile library -->
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
<div data-role="page" id="home">
	<div data-role="header">
		<h1><?php echo !isset($tajuk) ? 'Kosong':$tajuk; ?></h1>
	</div>
