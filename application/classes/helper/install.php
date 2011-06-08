<?php defined('SYSPATH') or die('No direct script access.');

class Helper_Install {
	
	public static function check()
	{
		$failed = FALSE;
		$failures = array();
		$extensions = Kohana::config('phbench.extensions');
		
		foreach ($extensions as $extension => $function)
		{
			if ( ! function_exists($function))
			{
				$failed = TRUE;
				$failures[] = $extension;
			}
		}
		
		return array(
			'failed'   => $failed,
			'failures' => $failures,
		);
	}
	
} // End Install
