<?php defined('SYSPATH') or die('No direct script access.');

class Phbench_Datastructure extends Phbench {
	
	public static $description = 'Stack / Queue on top of array(). Tests the 
		basic math operations as well.';
	
	public static function run()
	{
		$instance = new self();
		$instance->stack();
		$instance->queue();
	}
	
	public function stack()
	{
		$stack = array();
		
		for ($i = 0; $i < $this->loops; $i++)
		{
			$j = ($i - 1) * ($i + 1);
			array_push($stack, $j);
		}
		
		for ($i = 0; $i < $this->loops; $i++)
		{
			array_pop($stack);
		}
	}
	
	public function queue()
	{
		$queue = array();
		
		for ($i = 0; $i < $this->loops; $i++)
		{
			$j = ($i - 1) / ($i + 1);
			array_unshift($queue, $j);
		}
		
		for ($i = 0; $i < $this->loops; $i++)
		{
			array_shift($queue);
		}
	}
	
} // End Datastructure
