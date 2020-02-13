<?php
	function __autoload($class_name) {
		require_once 'lib/'.$class_name .'.php';  
	}
	require_once('lib/CONFIG.php');
	require_once('lib/lib_debug.php');
?>