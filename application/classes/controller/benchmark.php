<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Benchmark extends Controller {
	
	public function action_index($benchmark = '')
	{
		$data = array();
		$class = 'Phbench_'.ucfirst($benchmark);
		
		if (class_exists($class, TRUE) === TRUE)
		{
			$token = Profiler::start('phbench', $benchmark);
			$class::run();
			Profiler::stop($token);
			$data['output']['success'] = TRUE;
			$data['output']['result'] = Profiler::total($token);
			$data['output']['result'][0] = round($data['output']['result'][0] * 1000);
			Profiler::delete($token);
		}
		else
		{
			$data['output']['success'] = FALSE;
			$data['output']['result'] = array();
		}
		
		$this->request->headers['Content-Type'] = 'application/json';
		$this->request->response = View::factory('json', $data);
	}
	
} // End Benchmark
