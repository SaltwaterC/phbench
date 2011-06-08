<?php defined('SYSPATH') or die('No direct script access.');

class Phbench_Uuid extends Phbench {
	
	public static $description = 'Type 4 (Random) UUID generation.';
	
	public static function run()
	{
		$instance = new self();
		$instance->loop();
	}
	
	public function loop()
	{
		for ($i = 0; $i < $this->loops; $i++)
		{
			self::random_uuid();
		}
	}
	
	public static function random_uuid()
	{
		return sprintf(
			'%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			mt_rand(0, 0xffff),
			mt_rand(0, 0xffff),
			mt_rand(0, 0xffff),
			mt_rand(0, 0x0fff) | 0x4000,
			mt_rand(0, 0x3fff) | 0x8000,
			mt_rand(0, 0xffff),
			mt_rand(0, 0xffff),
			mt_rand(0, 0xffff)
		);
	}
	
} // End Uuid
