<?php defined('SYSPATH') or die('No direct script access.');

class Phbench {
	
	public $loops;
	
	public $squares;
	
	public static $description = 'This is a phbench class, testing a particular 
		behavior';
	
	public function __construct()
	{
		$this->loops = (int) Kohana::config('phbench.loops');
		$this->squares = (int) Kohana::config('phbench.squares');
	}
	
} // End Phbench
