<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Codebench — A benchmarking module.
 *
 * @package    Kohana
 * @author     Kohana Team
 * @copyright  (c) 2009 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
?>
<?php defined('SYSPATH') or die('No direct script access.') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv="content-type" content="text/html; charset=<?php echo Kohana::$charset ?>" />
	<title><?php if ($class !== '') echo $class, ' · ' ?>Codebench</title>
	<?php echo HTML::style('includes/css/style.min.css') ?>
</head>
<body>
	<?php echo View::factory('widgets/menu') ?>
	<form id="runner" method="post" action="<?php echo URL::site('codebench') ?>">
		<h1>
			<input name="class" type="text" value="<?php echo ($class !== '') ? $class : 'Bench_' ?>" size="25" title="Name of the Codebench library to run" />
			<input type="submit" value="Run" />
			<?php if ( ! empty($class)) { ?>
				<?php if (empty($codebench)) { ?>
					<strong class="alert">Library not found</strong>
				<?php } elseif (empty($codebench['benchmarks'])) { ?>
					<strong class="alert">No methods found to benchmark</strong>
				<?php } ?>
			<?php } ?>
		</h1>
	</form>

	<?php if ( ! empty($codebench)) { ?>

		<?php if (empty($codebench['benchmarks'])) { ?>

			<p>
				<strong>
					Remember to prefix the methods you want to benchmark with “bench”.<br />
					You might also want to overwrite <code>Codebench->method_filter()</code>.
				</strong>
			</p>

		<?php } else { ?>

			<ul id="bench">
			<?php foreach ($codebench['benchmarks'] as $method => $benchmark) { ?>
				<li>

					<h2 title="<?php printf('%01.6f', $benchmark['time']) ?>s">
						<span class="grade-<?php echo $benchmark['grade']['time'] ?>" style="width:<?php echo $benchmark['percent']['slowest']['time'] ?>%">
							<span class="method"><?php echo $method ?></span>
							<span class="percent">+<?php echo (int) $benchmark['percent']['fastest']['time'] ?>%</span>
						</span>
					</h2>

					<div>
						<table>
							<caption>Benchmarks per subject for <?php echo $method ?></caption>
							<thead>
								<tr>
									<th style="width:50%">subject → return</th>
									<th class="numeric" style="width:25%" title="Total method memory"><?php echo Text::bytes($benchmark['memory'], 'MB', '%01.6f%s') ?></th>
									<th class="numeric" style="width:25%" title="Total method time"><?php printf('%01.6f', $benchmark['time']) ?>s</th>
								</tr>
							</thead>
							<tbody>

							<?php foreach ($benchmark['subjects'] as $subject_key => $subject) { ?>
								<tr>
									<td>
										<strong class="help" title="(<?php echo gettype($codebench['subjects'][$subject_key]) ?>) <?php echo HTML::chars(var_export($codebench['subjects'][$subject_key], TRUE)) ?>">
											[<?php echo HTML::chars($subject_key) ?>] →
										</strong>
										<span class="quiet">(<?php echo gettype($subject['return']) ?>)</span>
										<?php echo HTML::chars(var_export($subject['return'], TRUE)) ?>
									</td>
									<td class="numeric">
										<span title="+<?php echo (int) $subject['percent']['fastest']['memory'] ?>% memory">
											<span style="width:<?php echo $subject['percent']['slowest']['memory'] ?>%">
												<span><?php echo Text::bytes($subject['memory'], 'MB', '%01.6f%s') ?></span>
											</span>
										</span>
									</td>
									<td class="numeric">
										<span title="+<?php echo (int) $subject['percent']['fastest']['time'] ?>% time">
											<span style="width:<?php echo $subject['percent']['slowest']['time'] ?>%">
												<span><?php printf('%01.6f', $subject['time']) ?>s</span>
											</span>
										</span>
									</td>
								</tr>
							<?php } ?>

							</tbody>
						</table>
					</div>

				</li>
			<?php } ?>
			</ul>

		<?php } ?>

		<?php if ( ! empty($codebench['description'])) { ?>
			<?php echo Text::auto_p(Text::auto_link($codebench['description']), FALSE) ?>
		<?php } ?>

		<?php // echo '<h2>Raw output:</h2>', Kohana::debug($codebench) ?>

	<?php } ?>

	<p id="footer">
		Page executed in <strong><?php echo round(microtime(TRUE) - KOHANA_START_TIME, 2) ?>&nbsp;s</strong>
		using <strong><?php echo Text::widont(Text::bytes(memory_get_usage(), 'MB')) ?></strong> of memory.<br />
		<a href="http://github.com/kohana/codebench">Codebench</a>, a <a href="http://kohanaframework.org/">Kohana</a> module
		by <a href="http://www.geertdedeckere.be/article/introducing-codebench">Geert De Deckere</a>.
	</p>
	
	<?php echo HTML::script('includes/js/codebench.min.js') ?>
</body>
</html>
