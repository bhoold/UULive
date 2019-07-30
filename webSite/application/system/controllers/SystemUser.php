<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 用户控制器
 */
class SystemUser extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('password');

		$this->load->model('SystemUserModel', 'userModel');

	}


	/**
	 * 显示用户列表界面
	 */
	public function index()
	{
		$displayData = array();

		$formAction = $this->input->get('_action');
		if($formAction){
			$gets = $this->input->get();
			switch($formAction){
				case 'delete':
					if($delIds = $this->input->get('_action_id')){
						$this->_delete($delIds);
						unset($gets['_action_id']);
					}
					break;
				case 'state':
					$stateIds = $this->input->get('_action_id');
					$state = $this->input->get('_action_state');
					if($state == 'block'){
						$this->_setState($stateIds, 0);
					}elseif($state == 'unblock'){
						$this->_setState($stateIds, 1);
					}
					unset($gets['_action_id']);
					unset($gets['_action_state']);
			}
			unset($gets['_action']);
			if(empty($gets)){
				myredirect('index', 'location');
			}else{
				myredirect('index?'.http_build_query($gets), 'location');
			}
		}



		//return;
		$pageNum = $this->input->get('pageNum');
		$pageSize = $this->input->get('pageSize');

		if(!($pageNum > 0)) {
			$pageNum = 1;
		}
		if(!($pageSize > 0)) {
			$pageSize = 10;
		}

		$whereInit = array(
			'where' => array(
				'id' => $this->input->get('filter[id]')
			),
			'like' => array(
				'username' => $this->input->get('filter[username]')
			)
		);
		$where = array();
		$filter = array();
		foreach($whereInit as $key => $arr) {
			foreach($arr as $key2 => $val2) {
				$filter[$key2] = $val2;
				if(trim($val2) === '' || trim($val2) === null){
					unset($arr[$key2]);
				}
			}
			if(!empty($arr)){
				$where[$key] = $arr;
			}
		}

		$result = $this->userModel->list($where, $pageNum, $pageSize);
		$displayData['list'] = $result['list'];
		$displayData['pager'] = array(
			'count' => $result['count'],
			'pageNum' => $pageNum,
			'pageSize' => $pageSize
		);
		$displayData['filter'] = $filter;

		$msgList = $this->message->getMessageQueue();
		$displayData['msgList'] = $msgList;


		$this->load->view('list', $displayData);
	}

	/**
	 * 显示用户添加界面
	 */
	public function add()
	{
		$displayData = array();

		if($this->input->method() == 'post'){
			$post = $this->input->post(array('username', 'password', 'state'));

			$this->form_validation->reset_validation();
			if($this->form_validation->run() !== FALSE){
				if($this->userModel->get(array('username'=>$post['username']))){
					$this->message->enqueueMessage('账号重复!', 'error');
				}else{
					$post['password'] = password($post['password']);
					$post['regip'] = $this->input->ip_address();
					if($userId = $this->userModel->insert($post)){
						$this->message->enqueueMessage('新增成功!', 'success');

						$follow_action = $this->input->post('_follow-action');
						if($follow_action === '3'){
							myredirect('add', 'location');
						}elseif($follow_action === '2'){
							myredirect('index', 'location');
						}else{
							myredirect('edit/'.$userId, 'location');
						}
						return;
					}else{
						$this->message->enqueueMessage('保存数据失败!', 'error');
					}
				}
			}else{
				$this->message->enqueueMessage('表单验证失败!', 'error');
			}
		}


		$msgList = $this->message->getMessageQueue();
		$displayData['msgList'] = $msgList;

		$this->load->view('', $displayData);
	}

	/**
	 * 显示用户编辑界面
	 */
	public function edit($uid = 0)
	{
		$displayData = array();
		$displayData['user'] = array();

		if($uid){
			if($user = $this->userModel->get(array('id'=>$uid))){
				$displayData['user'] = $user;


				if($this->input->method() == 'post'){
					$post = $this->input->post(array('password', 'state'));

					$this->form_validation->reset_validation();
					if($this->form_validation->run() !== FALSE){
						$post['password'] = trim($post['password']);
						if($post['password'] !== ''){
							$post['password'] = password($post['password']);
						}else{
							unset($post['password']);
						}

						$where = array('id'=>$uid);
						if($userId = $this->userModel->update($where, $post)){
							$this->message->enqueueMessage('编辑成功!', 'success');

							$follow_action = $this->input->post('_follow-action');
							if($follow_action === '3'){
								myredirect('add', 'location');
							}elseif($follow_action === '2'){
								myredirect('index', 'location');
							}else{
								myredirect('edit/'.$userId, 'location');
							}
							return;
						}else{
							$this->message->enqueueMessage('保存数据失败!', 'error');
						}
					}else{
						$this->message->enqueueMessage('表单验证失败!', 'error');
					}

				}


			}else{
				$this->message->enqueueMessage('用户不存在!', 'error');
			}
		}else{
			$this->message->enqueueMessage('用户不存在!', 'error');
		}


		$msgList = $this->message->getMessageQueue();
		$displayData['msgList'] = $msgList;

		$this->load->view('', $displayData);
	}

	/**
	 * 删除用户
	 */
	private function _delete($idsStr)
	{
		if($this->userModel->delete($idsStr)){
			$this->message->enqueueMessage('ID:' . $idsStr . ' ' . '删除成功!', 'success');
		}else{
			$this->message->enqueueMessage('ID:' . $idsStr . ' ' . '删除失败!', 'error');
		}
	}

	/**
	 * 设置用户状态
	 */
	private function _setState($idsStr, $state)
	{
		if($this->userModel->setState($idsStr, $state)){
			$this->message->enqueueMessage('ID:' . $idsStr . ' ' . ($state ? '启用成功!' : '停用成功!'), 'success');
		}else{
			$this->message->enqueueMessage('ID:' . $idsStr . ' ' . ($state ? '启用失败!' : '停用失败!'), 'error');
		}
	}


}
