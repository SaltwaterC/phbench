<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tests extends Controller {
	
	public function action_index()
	{
		$data = array();
		$file_list = Kohana::list_files('classes/phbench');
		
		foreach ($file_list as $file)
		{
			$test_name = str_replace(
				EXT, '', str_replace(
					APPPATH.'classes'.DIRECTORY_SEPARATOR.
					'phbench'.DIRECTORY_SEPARATOR, '', $file
				)
			);
			
			$reflect = new ReflectionProperty(
				'phbench_'.$test_name, 'description'
			);
			
			$data['output'][$test_name] = array(
				'description' => $reflect->getValue(),
				'url'         => URL::site('benchmark/'.$test_name),
				'name'        => $test_name,
			);
		}
		
		$this->request->headers['Content-Type'] = 'application/json';
		$this->request->response = View::factory('json', $data);
	}
	
} // End Tests
