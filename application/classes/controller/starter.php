<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Starter extends Controller {

	public function action_index()
	{
		$this->request->response = View::factory(
			'pages/starter',
			(array) Kohana::config('phbench')
		);
	}
	
} // End Starter