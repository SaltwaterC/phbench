<?php defined('SYSPATH') or die('No direct script access.');

class Phbench_Sha extends Phbench {
	
	public static $description = 'Generates sha1, sha256, sha512 hashes by using 
		the hash library.';
	
	public static function run()
	{
		$instance = new self();
		$instance->loop('sha1');
		$instance->loop('sha256');
		$instance->loop('sha512');
	}
	
	public function loop($algo = '')
	{
		for ($i = 0; $i < $this->loops; $i++)
		{
			hash($algo, $i);
		}
	}
	
} // End Sha
