<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 用户控制器
 */
class GlobalConfig extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

	}


	/**
	 * 显示全局配置界面
	 */
	public function index()
	{
		$this->load->view();
	}

}
