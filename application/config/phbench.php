<?php defined('SYSPATH') or die('No direct script access.');

return array(
	
	'version'      => '0.2',
	'iterations'   => 10,
	'loops'        => 2500,
	'squares'      => 250,
	'gap'          => 1000,
	// Runtime check for proper extensions
	// extension => function
	'extensions'   => array(
		'gd'   => 'gd_info',
		'hash' => 'hash',
		'json' => 'json_encode',
		'date' => 'date',
		'pcre' => 'preg_replace',
	),
	// These go straight to the test layout table
	'runtime_keys' => array(
		'iterations' => 'Execution times for each test.',
		'loops'      => 'Number of loops within linear scaling tests.',
		'squares'    => 'Number of loops within quadratic scaling tests.',
		'gap'        => 'Time gap in miliseconds between each test execution.',
	),
	
);
