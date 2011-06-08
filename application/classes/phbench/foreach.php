<?php defined('SYSPATH') or die('No direct script access.');

class Phbench_Foreach extends Phbench {
	
	public static $description = 'foreach() on array / object while executing some
		math functions.';
	
	protected $array;
	
	protected $object;
	
	public function __construct()
	{
		parent::__construct();
		
		$array = array();
		
		for ($i = 0; $i < $this->loops; $i++)
		{
			$array[] = $i;
		}
		
		$this->array = $array;
		$this->object = (object) $array;
	}
	
	public static function run()
	{
		$instance = new self();
		$instance->loop('array');
		$instance->loop('array', TRUE);
		$instance->loop('object');
		$instance->loop('object', TRUE);
	}
	
	public function loop($property, $use_key = FALSE)
	{
		if ($use_key === FALSE)
		{
			foreach ($this->{$property} as $value)
			{
				$value = dechex($value);
			}
		}
		else
		{
			foreach ($this->{$property} as $key => $value)
			{
				$value = log($key) + log10($value);
			}
		}
	}
	
} // End Loop