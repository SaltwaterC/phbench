<?php defined('SYSPATH') or die('No direct script access.') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=<?php echo Kohana::$charset ?>" />
		<title>phbench v<?php echo $version ?></title>
		<?php echo HTML::style('includes/css/style.css') ?>
	</head>
	<body>
		<?php echo View::factory('widgets/menu') ?>
		<button onclick="phbench.start_tests(tests_iterations, tests_gap)" disabled="disabled" id="start_tests">Start Tests</button><button onclick="phbench.stop_tests()" disabled="disabled" id="stop_tests">Stop Tests</button> Remaining tests: <span id="remaining_tests">0</span>; Status: <span id="status"></span>
		<br />
		<br />
		<table class="tests">
			<tr>
				<th>Key</th>
				<th>Value</th>
				<th>Description</th>
			</tr>
			<?php foreach ($runtime_keys as $key => $description) : ?>
			<tr>
				<td><?php echo $key ?></td>
				<td><?php echo ${$key} ?></td>
				<td><?php echo $description ?></td>
			</tr>
			<?php endforeach ?>
		</table>
		<br />
		<table class="tests" id="tests">
			<tr>
				<th>Test</th>
				<th>Description</th>
				<th>Time</th>
				<th>Mean</th>
				<th>Standard Deviation</th>
			</tr>
		</table>
		<br />
		<table class="tests">
			<tr>
				<th>Total Time</th>
				<th>Mean</th>
				<th>Standard Deviation</th>
			</tr>
			<tr>
				<td><span id="time">0 s</span></td>
				<td><span id="mean">0 s</span></td>
				<td><span id="stddev">0 s</span></td>
			</tr>
		</table>
		<br />
		<div id="log"><p>Log:</p></div>
		<p id="footer">
			Page executed in <strong><?php echo round(microtime(TRUE) - KOHANA_START_TIME, 2) ?>&nbsp;s</strong>
			using <strong><?php echo Text::widont(Text::bytes(memory_get_usage(), 'MB')) ?></strong> of memory.<br />
			<a href="http://code.google.com/p/phbench/">phbench</a>, a <a href="http://php.net/">PHP</a> benchmark 
			test by <a href="http://www.saltwaterc.net/">SaltwaterC</a>.
		</p>
		
		<?php
		echo HTML::script('includes/js/jquery.js');
		echo HTML::script('includes/js/inflection.js');
		echo HTML::script('includes/js/convert.js');
		echo HTML::script('includes/js/phbench.js');
		?>
		<script type="text/javascript">
			var tests_url = '<?php echo URL::site('tests') ?>';
			var tests_iterations = <?php echo Kohana::config('phbench.iterations') ?>;
			var tests_gap = <?php echo Kohana::config('phbench.gap') ?>;
		</script>
	</body>
</html>
