<?php

// Sanity check, install should only be checked from index.php
defined('SYSPATH') or exit('Install tests must be loaded from within index.php!');

if (version_compare(PHP_VERSION, '5.3', '<'))
{
	// Clear out the cache to prevent errors. This typically happens on Windows/FastCGI.
	clearstatcache();
}
else
{
	// Clearing the realpath() cache is only possible PHP 5.3+
	clearstatcache(TRUE);
}

$tests = array(
	array(
		'name' => 'PHP Version',
		'eval' => version_compare(PHP_VERSION, '5.2.3', '>='),
		'fail' => 'phbench requires PHP 5.2.3 or newer, this version is '.PHP_VERSION,
	),
	
	array(
		'name' => 'System Directory',
		'eval' => is_dir(SYSPATH) AND is_file(SYSPATH.'classes/kohana'.EXT),
		'fail' => 'The configured '.SYSPATH.' directory does not exist or does not contain required files.',
	),
	
	array(
		'name' => 'Application Directory',
		'eval' => is_dir(APPPATH) AND is_file(APPPATH.'bootstrap'.EXT),
		'fail' => 'The configured '.APPPATH.' directory does not exist or does not contain required files.',
	),
	
	array(
		'name' => 'Cache Directory',
		'eval' => is_dir(APPPATH) AND is_dir(APPPATH.'cache') AND is_writable(APPPATH.'cache'),
		'fail' => 'The '.APPPATH.'cache directory is not writable.',
	),
	
	array(
		'name' => 'Logs Directory',
		'eval' => is_dir(APPPATH) AND is_dir(APPPATH.'logs') AND is_writable(APPPATH.'logs'),
		'fail' => 'The '.APPPATH.'logs directory is not writable.',
	),
	
	array(
		'name' => 'PCRE UTF-8',
		'eval' => @preg_match('/^.$/u', 'ñ'),
		'fail' => 'PCRE has not been compiled with UTF-8 support.',
	),
	
	array(
		'name' => 'PCRE Unicode property',
		'eval' => @preg_match('/^\pL$/u', 'ñ'),
		'fail' => 'PCRE has not been compiled with Unicode property support.',
	),
	
	array(
		'name' => 'SPL Enabled',
		'eval' => function_exists('spl_autoload_register'),
		'fail' => 'PHP SPL is either not loaded or not compiled in.',
	),
	
	array(
		'name' => 'Reflection Enabled',
		'eval' => class_exists('ReflectionClass'),
		'fail' => 'PHP is either not loaded or not compiled in.',
	),
	
	array(
		'name' => 'Filters Enabled',
		'eval' => function_exists('filter_list'),
		'fail' => 'The filter extension is either not loaded or not compiled in.',
	),
	
	array(
		'name' => 'Iconv Extension Loaded',
		'eval' => extension_loaded('iconv'),
		'fail' => 'The iconv extension is not loaded.',
	),
	
	array(
		'name' => 'Mbstring Extension Loaded',
		'eval' => extension_loaded('mbstring'),
		'fail' => 'The mbstring extension is not loaded.',
	),
	
	array(
		'name' => 'Mbstring Not Overloaded',
		'eval' =>  ! (ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING),
		'fail' => 'The mbstring extension is overloading PHP\'s native string functions.',
	),
	
	array(
		'name' => 'Character Type (CTYPE) Extension',
		'eval' => function_exists('ctype_digit'),
		'fail' => 'The ctype extension is not enabled.',
	),
	
	array(
		'name' => 'URI Determination',
		'eval' => isset($_SERVER['REQUEST_URI']) OR isset($_SERVER['PHP_SELF']) OR isset($_SERVER['PATH_INFO']),
		'fail' => 'Neither $_SERVER[\'REQUEST_URI\'], $_SERVER[\'PHP_SELF\'], or $_SERVER[\'PATH_INFO\'] is available.',
	),
	
	array(
		'name' => 'GD Extension Loaded',
		'eval' => function_exists('gd_info'),
		'fail' => 'The gd extension is not loaded.',
	),
	
	array(
		'name' => 'Hash Extension Loaded',
		'eval' => function_exists('hash'),
		'fail' => 'The hash extension is not loaded.',
	),
	
	array(
		'name' => 'Json Extension Loaded',
		'eval' => function_exists('json_encode'),
		'fail' => 'The json extension is not loaded.',
	),
	
	array(
		'name' => 'Date Extension Loaded',
		'eval' => function_exists('date'),
		'fail' => 'The date extension is not loaded.',
	),
	
);

$failures = array();
foreach ($tests as $test)
{
	if ( ! $test['eval'])
	{
		unset($test['eval']);
		$failures[] = $test;
	}
}

if (sizeof($failures) > 0) :
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
<head>
	<title>phbench installation</title>
	<style type="text/css">
	body { width: 42em; margin: 0 auto; font-family: sans-serif; background: #fff; font-size: 1em; }
	h1 { letter-spacing: -0.04em; }
	h1 + p { margin: 0 0 2em; color: #333; font-size: 90%; font-style: italic; }
	code { font-family: monaco, monospace; }
	table { border-collapse: collapse; width: 100%; }
		table th,
		table td { padding: 0.4em; text-align: left; vertical-align: top; }
		table th { width: 12em; font-weight: normal; }
		table tr:nth-child(odd) { background: #eee; }
		table td.pass { color: #191; }
		table td.fail { color: #911; }
	#results { padding: 0.8em; color: #fff; font-size: 1.5em; }
	#results.pass { background: #191; }
	#results.fail { background: #911; }
	</style>
</head>
<body>
	<h1>Failed Tests</h1>
	
	<table cellspacing="0">
	<?php foreach ($failures as $fail) : ?>
		<tr>
			<th><?php echo $fail['name'] ?></th>
			<td class="fail"><?php echo $fail['fail'] ?></td>
		</tr>
	<?php endforeach ?>
	</table>
	
	<p id="results" class="fail">✘ phbench won't work without the above list.</p>
</body>
</html>
<?php
	exit(1);
endif;
?>
