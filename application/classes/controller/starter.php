<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Starter extends Controller {

	public function action_index()
	{
		$view = '';
		$data = array();
		$install = Install::check();
		
		if ($install['failed'] !== FALSE)
		{
			$view = 'error/install';
			$data['failures'] = $install['failures'];
		}
		else
		{
			$view = 'pages/starter';
			$data = (array) Kohana::config('phbench');
		}
		
		$this->request->response = View::factory($view, $data);
	}
	
} // End Starter
