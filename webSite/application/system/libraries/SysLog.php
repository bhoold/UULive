<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class SysLog {


	public function __construct()
	{
		$CI =& get_instance();

		$CI->load->helper('system');

		$CI->load->model('SystemLogModel', 'logModel');
	}

	public function add($content)
	{
		// Don't add empty messages.
		if (is_string($content) && trim($content) === '')
		{
			return;
		}

		$CI =& get_instance();

		//$keys = ['username', 'content', 'useragent', 'ip'];
		if(is_array($content)){
			if(!$content['content']){
				return;
			}
			$data = array(
				'username' => $content['username'] ? $content['username'] : currentUser('username'),
				'content' => $content['content'],
				'module' => $content['module'] ? $content['module'] : $CI->router->class,
				'useragent' => $content['useragent'] ? $content['useragent'] : $CI->input->user_agent(),
				'ip' => $content['ip'] ? $content['ip'] : $CI->input->ip_address()
			);
		}else{
			$data = array(
				'username' => currentUser('username'),
				'content' => $content,
				'useragent' => $CI->input->user_agent(),
				'ip' => $CI->input->ip_address()
			);
		}

		$CI->logModel->insert($data);

	}

}
