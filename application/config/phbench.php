<?php defined('SYSPATH') or die('No direct script access.');

return array(
	
	'version'      => '0.2.1',
	'iterations'   => 10,
	'loops'        => 2500,
	'squares'      => 250,
	'gap'          => 1000,
	
	// These go straight to the test layout table
	'runtime_keys' => array(
		'iterations' => 'Execution times for each test.',
		'loops'      => 'Number of loops within linear scaling tests.',
		'squares'    => 'Number of loops within quadratic scaling tests.',
		'gap'        => 'Time gap in miliseconds between each test execution.',
	),
	
);
