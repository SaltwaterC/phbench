<?php defined('SYSPATH') or die('No direct access allowed.');

require dirname(__FILE__).DIRECTORY_SEPARATOR.'sha256_crypt'.EXT;

class Bench_Crypt extends Codebench {
	
	public $description = 'Native vs pure PHP SHA256 crypt().';
	
	public $subjects = array();

	public $loops = 100;
	
	function __construct()
	{
		for ($i = 0; $i < 10; $i++)
		{
			$this->subjects[] = uniqid(NULL, TRUE);
		}
	}
	
	public function bench_php_crypt($pwd)
	{
		return crypt($pwd, '$5$rounds=1000$0123456789abcdef');
	}
	
	public function bench_native_crypt($pwd)
	{
		return crypt_sha256($pwd, '0123456789abcdef', 1000);
	}
	
}// End Crypt
