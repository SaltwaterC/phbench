<?php defined('SYSPATH') or die('No direct script access.');

class Phbench_Lookup extends Phbench {
	
	public static $description = 'Lookup table test (non indexed search, 50% 
		valid entries).';
	
	public static function run()
	{
		$instance = new self();
		$instance->loop();
	}
	
	public function loop()
	{
		$needles = array();
		$haystack = array();
		
		for ($i = 0; $i < $this->loops; $i++)
		{
			$haystack[] = $i;
			if ($i % 2 === 0)
			{
				$needles[] = $i;
			}
		}
		
		foreach ($needles as $needle)
		{
			array_search($needle, $haystack);
		}
	}
	
} // End Lookup
