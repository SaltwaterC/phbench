<?php defined('SYSPATH') or die('No direct script access.');

class Phbench_Prime extends Phbench {
	
	public static $description = 'Computes if the input is a prime number.';
	
	public static function run()
	{
		$instance = new self();
		$instance->loop();
	}
	
	public function loop()
	{
		for ($i = 0; $i < $this->loops; $i++)
		{
			self::is_prime($i);
		}
	}
	
	public static function is_prime($i)
	{
		if ($i % 2 != 1)
		{
			return FALSE;
		}
		
		$d = 3;
		$x = sqrt($i);
		while ($i % $d != 0 AND $d < $x)
		{
			$d += 2;
		}
		
		return (($i % $d == 0 AND $i != $d) * 1) == 0 ? TRUE : FALSE;
	}
	
} // End Prime
