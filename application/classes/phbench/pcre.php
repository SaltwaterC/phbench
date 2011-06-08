<?php defined('SYSPATH') or die('No direct script access.');

class Phbench_Pcre extends Phbench {
	
	public static $description = 'PCRE benchmark (match / replace).';
	
	protected $array;
	
	public function __construct()
	{
		parent::__construct();
		for ($i = 0; $i < $this->loops; $i++)
		{
			$this->array[] = sha1($i);
		}
	}
	
	public static function run()
	{
		$instance = new self();
		$instance->match();
		$instance->replace();
	}
	
	public function match()
	{
		for ($i = 0; $i < $this->loops; $i++)
		{
			$match = NULL;
			preg_match('/[a-f]+/i', $this->array[$i], $match);
		}
	}
	
	public function replace()
	{
		for ($i = 0; $i < $this->loops; $i++)
		{
			$result = NULL;
			$result = preg_replace('/[\d]+/', '', $this->array[$i]);
		}
	}
	
} // End Pcre
