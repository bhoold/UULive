<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 登录控制器
 */
class Login extends CI_Controller {

	private $_userFlag = 'application.system.currentLoginUser';

	public function __construct()
	{
		parent::__construct();
		//$this->load->model('login_model');
		$this->load->helper(array('url','form'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('message');
		$this->load->library('syslog');
	}

	/**
	 * 登录界面
	 */
	public function index()
	{
		if($this->session->userdata($this->_userFlag)) {
			myredirect('/Dashboard/index', 'location');
		}

		$displayData = array();

		$this->form_validation->set_rules('username', '账号', 'trim|required', array('required' => '请输入%s.'));
		$this->form_validation->set_rules('password', '密码', 'trim|required', array('required' => '请输入%s.'));

		if($this->form_validation->run() === FALSE OR $this->_checkout($this->input->post('username'),$this->input->post('password')) === FALSE) {

			$msgList = $this->message->getMessageQueue();
			$displayData['msgList'] = $msgList;

			$this->load->view('login', $displayData);
		} else {
			$this->syslog->add(array(
				'username' => $this->session->userdata($this->_userFlag)['username'],
				'content' => '登录'
			));
			myredirect('/Dashboard/index', 'location');

		}
	}

	/**
	 * 登出
	 */
	public function logout()
	{

		$this->syslog->add(array(
			'username' => $this->session->userdata($this->_userFlag)['username'],
			'content' => '登出'
		));
		$this->session->unset_userdata($this->_userFlag);
		myredirect('index', 'location');
	}



	/**
	 * 检测账号和密码是否和数据库数据匹配
	 */
	private function _checkout($username, $password)
	{

		$this->load->helper('password');
		$this->load->model('SystemUserModel', 'userModel');

		$flag = FALSE;

		if($user = $this->userModel->get(array('username'=>$username))){
			if($user['password'] === password($password)){
				if($user['state']){
					$flag = TRUE;
					unset($user['password']);
					$this->session->set_userdata($this->_userFlag, $user);
				}else{
					$this->message->enqueueMessage('用户被停用!', 'error');
				}
			}else{
				$this->message->enqueueMessage('密码错误!', 'error');
			}
		}else{
			$this->message->enqueueMessage('无此用户!', 'error');
		}

		return $flag;
	}
}
