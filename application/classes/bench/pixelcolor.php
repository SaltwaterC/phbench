<?php defined('SYSPATH') or die('No direct access allowed.');

class Bench_Pixelcolor extends Codebench {
	
	public $description = 'Find the fastest method for getting the RGB values for a given pixel coordinates.';
	
	public $subjects = array();
	
	protected $gd, $imagick;
	
	public function __construct()
	{
		$image = dirname(__FILE__).DIRECTORY_SEPARATOR.'img.png';
		$this->gd = imagecreatefrompng($image);
		$this->imagick = new Imagick($image);
		
		for ($i = 100; $i < 120; $i++) {
			for ($j = 100; $j < 120; $j++) {
				$this->subjects[] = array(
					'x' => $i,
					'y' => $j,
				);
			}
		}
	}
	
	public function bench_getpixel_gd_bitwise($coord)
	{
		$rgb = imagecolorat($this->gd, $coord['x'], $coord['y']);
		return array(
			'red'   => ($rgb >> 16) & 0xFF,
			'green' => ($rgb >> 8) & 0xFF,
			'blue'  => $rgb & 0xFF,
		);
	}
	
	public function bench_getpixel_gd_imagecolorsforindex($coord)
	{
		$rgb = imagecolorat($this->gd, $coord['x'], $coord['y']);
		return imagecolorsforindex($this->gd, $rgb);
	}
	
	public function bench_getpixel_imagick($coord)
	{
		$pixel = $this->imagick->getImagePixelColor($coord['x'], $coord['y']);
		// This is so fucking slow compared to imagecolorat + bitwise operations
		// that it doesn't worth converting the float value between 0 and 1 to
		// an int value between 0 and 255 in order to make the return value
		// to be the same.
		return array(
			'red'   => $pixel->getColorValue(imagick::COLOR_RED),
			'green' => $pixel->getColorValue(imagick::COLOR_GREEN),
			'blue'  => $pixel->getColorValue(imagick::COLOR_BLUE),
		);
	}
	
} // End Bench_Pixelcolor
