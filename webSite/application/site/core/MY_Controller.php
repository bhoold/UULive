<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台基础控制器
 */
class MY_Controller extends CI_Controller {

	private $_userFlag = 'application.site.currentLoginUser';

	public function __construct()
	{
		parent::__construct();

		$this->load->library('session');
		$this->load->library('message');
		$this->load->library('form_validation');

		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('system');

		if(!$this->_isLogined()){
			myredirect('/Login/index', 'location');
		}
	}

	/**
	 * 获取当前登录的用户信息
	 */
	public function getCurrentUser()
	{
		return $this->session->userdata($this->_userFlag);
	}

	/**
	 * 判断是否已经登录
	 */
	private function _isLogined()
	{
		$currentUser = $this->session->userdata($this->_userFlag);
		return $currentUser ? TRUE : FALSE;
	}

}
