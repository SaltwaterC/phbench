<?php defined('SYSPATH') or die('No direct access allowed.');

class Bench_Salt extends Codebench {
	
	public $description = 'Fastest bcrypt salt generator.';
	
	public $subjects;
	
	public function __construct()
	{
		$this->subjects[] = openssl_random_pseudo_bytes(16);
		$this->subjects[] = openssl_random_pseudo_bytes(16);
		$this->subjects[] = openssl_random_pseudo_bytes(16);
		$this->subjects[] = openssl_random_pseudo_bytes(16);
		$this->subjects[] = openssl_random_pseudo_bytes(16);
		$this->subjects[] = openssl_random_pseudo_bytes(16);
		$this->subjects[] = openssl_random_pseudo_bytes(16);
		$this->subjects[] = openssl_random_pseudo_bytes(16);
		$this->subjects[] = openssl_random_pseudo_bytes(16);
		$this->subjects[] = openssl_random_pseudo_bytes(16);
		$this->subjects[] = openssl_random_pseudo_bytes(16);
		$this->subjects[] = openssl_random_pseudo_bytes(16);
		$this->subjects[] = openssl_random_pseudo_bytes(16);
		$this->subjects[] = openssl_random_pseudo_bytes(16);
		$this->subjects[] = openssl_random_pseudo_bytes(16);
		$this->subjects[] = openssl_random_pseudo_bytes(16);
	}
	
	public function bench_phpass($input)
	{
		$itoa64 =
			'./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		$output = '';
		
		$i = 0;
		do
		{
			$c1 = ord($input[$i++]);
			$output .= $itoa64[$c1 >> 2];
			$c1 = ($c1 & 0x03) << 4;
			if ($i >= 16)
			{
				$output .= $itoa64[$c1];
				break;
			}
			
			$c2 = ord($input[$i++]);
			$c1 |= $c2 >> 4;
			$output .= $itoa64[$c1];
			$c1 = ($c2 & 0x0f) << 2;
			
			$c2 = ord($input[$i++]);
			$c1 |= $c2 >> 6;
			$output .= $itoa64[$c1];
			$output .= $itoa64[$c2 & 0x3f];
		}
		while (1);
		
		return $output;
	}
	
	public function bench_base64_str_replace_substr($input)
	{
		return substr(str_replace('+', '.', base64_encode($input)), 0, 22);
	}
	
	public function bench_base64_str_replace($input)
	{
		return str_replace('=', '', str_replace('+', '.', base64_encode($input)));
	}
	
	public function bench_base64_strtr($input)
	{
		return strtr(base64_encode($input), array('+' => '.', '=' => ''));
	}
	
} // End Salt