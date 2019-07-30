<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 登录控制器
 */
class Login extends CI_Controller {

	private $_userFlag = 'application.site.currentLoginUser';
	private $_userInfo = array(); //正在登录的用户

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('url','form'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('message');

		$this->load->helper('system');

	}

	/**
	 * 获取当前登录的用户信息
	 */
	public function getCurrentUser()
	{
		return $this->session->userdata($this->_userFlag);
	}






	/**
	 * 登录界面
	 */
	public function index()
	{
		if($this->session->userdata($this->_userFlag)) {
			myredirect('/Person/index', 'location');
		}

		$displayData = array();

		$this->form_validation->set_rules('username', '账号', 'trim|required', array('required' => '请输入%s.'));
		$this->form_validation->set_rules('password', '密码', 'trim|required', array('required' => '请输入%s.'));

		$username = $this->input->post('username');
		$password = $this->input->post('password');

		if($this->form_validation->run() === FALSE OR $this->_checkUser($username, $password) === FALSE) {

			$msgList = $this->message->getMessageQueue();
			$displayData['msgList'] = $msgList;

			$this->load->view('login', $displayData);
		} else {
			$this->_storeUser();
			myredirect('/Person/index', 'location');

		}
	}

	/**
	 * 登出
	 */
	public function logout()
	{
		$this->_discardUser();
		myredirect('index', 'location');
	}



	/**
	 * 检测账号和密码是否和数据库数据匹配
	 */
	private function _checkUser($username, $password)
	{

		$this->load->helper('password');
		$this->load->model('UserModel', 'userModel');

		$flag = FALSE;

		if($user = $this->userModel->get(array('username'=>$username))){
			if($user['password'] === password($password)){
				if($user['state']){

					$flag = TRUE;

					unset($user['password']);
					$this->_userInfo = $user;

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



	/**
	 * session保存用户信息
	 */
	private function _storeUser()
	{
		if(!$this->_userInfo){
			return;
		}

		$user = $this->_userInfo;

		//redis统计用户
		getRedis()->incr('site:usersCount');

		//redis记录用户
		$userkey = 'site:onlineUser:'.$user['id'];
		if(!getRedis()->exists($userkey)){
			getRedis()->hMSet($userkey, $user);
		}
		getRedis()->hIncrBy($userkey, 'count', 1);
		getRedis()->hSet($userkey, 'time', time());

		//session存储用户信息
		$this->session->set_userdata($this->_userFlag, $user);
	}



	/**
	 * session删除用户
	 */
	private function _discardUser()
	{
		//redis登录计数减少
		if(getRedis()->get('site:usersCount') > 0){
			getRedis()->decr('site:usersCount');
		}

		//redis删除用户
		$userkey = 'site:onlineUser:'.currentUser('id');
		if($currentUserCount = getRedis()->hGet($userkey, 'count')){
			if($currentUserCount > 1){
				getRedis()->hSet($userkey, 'count', $currentUserCount - 1);
			}else{
				getRedis()->del($userkey);
			}
		}

		//session删除用户信息
		$this->session->unset_userdata($this->_userFlag);
	}
}
