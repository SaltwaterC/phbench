<?php defined('SYSPATH') or die('No direct script access.');

class Phbench_Datetime extends Phbench {
	
	public static $description = 'Basic date/time operations.';
	
	public static function run()
	{
		$instance = new self();
		$instance->loop();
	}
	
	public function loop()
	{
		$timezone = date_default_timezone_get();
		date_default_timezone_set('UTC');
		for ($i = 0; $i < $this->loops; $i++)
		{
			$date = date(DATE_COOKIE, $i);
			strtotime($date);
		}
		date_default_timezone_set($timezone);
	}
	
} // End Datetime
