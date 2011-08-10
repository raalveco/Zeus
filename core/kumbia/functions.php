<?php
	if (!function_exists('get_called_class')){
		function get_called_class() 
		{ 
			$bt = debug_backtrace(); 
			$lines = file($bt[1]['file']); 
			preg_match('/([a-zA-Z0-9\_]+)::'.$bt[1]['function'].'/', 
				$lines[$bt[1]['line']-1], 
				$matches
			); 
			return $matches[1]; 
		} 
	}
?>
