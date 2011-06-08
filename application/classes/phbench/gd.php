<?php defined('SYSPATH') or die('No direct script access.');

class Phbench_Gd extends Phbench {
	
	public static $description = 'Image creation with the GD library.';
	
	protected $image;
	
	public function __construct()
	{
		parent::__construct();
		$this->image = imagecreatetruecolor($this->squares, $this->squares);
	}
	
	public static function run()
	{
		$instance = new self();
		$instance->create_image();
	}
	
	public function create_image()
	{
		for ($i = 0; $i < $this->squares; $i++)
		{
			for ($j = 0; $j < $this->squares; $j++)
			{
				switch ($i + $j)
				{
					case ((($i + $j) % 3) === 0):
						$color = $this->color(255, 0, 0);
					break;
					
					case ((($i + $j) % 5) === 0):
						$color = $this->color(0, 255, 0);
					break;
					
					default:
						$color = $this->color(0, 0, 255);
					break;
				}
				
				$this->set_pixel($i, $j, $color);
			}
		}
		
		ob_start();
		imagepng($this->image);
		ob_end_clean();
	}
	
	protected function color($r, $g, $b)
	{
		return imagecolorallocate($this->image, $r, $g, $b);
	}
	
	protected function set_pixel($x, $y, $color)
	{
		return imagesetpixel($this->image, $x, $y, $color);
	}
	
} // End Gd
