<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 用户控制器
 */
class Person extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('StreamerModel');
		$this->load->model('StreamRoomModel');
	}

	/**
	 * 显示个人主页界面
	 */
	public function index()
	{
		$displayData = array();


		$msgList = $this->message->getMessageQueue();
		$displayData['msgList'] = $msgList;

		$this->load->view('/dashboard', $displayData);
	}


	/**
	 * 申请直播入驻
	 */
	public function regStream()
	{
		$displayData = array();

		$user = $this->streamerModel->get(array('userid' => currentUser('id')));
		if($user['state'] === '-1'){
			$this->message->enqueueMessage('您已经提交申请，请耐心等待审核!', 'error');
		}elseif($user['state'] === '0'){
			$this->message->enqueueMessage('您的申请已经被拒绝!', 'error');
		}elseif($user['state'] === '1'){
			$this->message->enqueueMessage('您的申请已经通过!', 'success');
		}

		if(!$user && $this->input->method() == 'post'){
			$post = $this->input->post(array('input_pic1', 'input_pic2'));

			$this->form_validation->reset_validation();
			if($this->form_validation->run() !== FALSE){

				$postData = array();
				$postData['regip'] = $this->input->ip_address();
				$postData['idcardpic1'] = $post['input_pic1'];
				$postData['idcardpic2'] = $post['input_pic2'];
				$postData['userid'] = currentUser('id');
				$postData['username'] = currentUser('username');

				if($userId = $this->streamerModel->insert($postData)){
					$this->message->enqueueMessage('成功提交申请!', 'success');

					myredirect('index', 'location');
					return;
				}else{
					$this->message->enqueueMessage('保存数据失败!', 'error');
				}
			}else{
				$this->message->enqueueMessage('表单验证失败!', 'error');
			}
		}


		$msgList = $this->message->getMessageQueue();
		$displayData['msgList'] = $msgList;

		$this->load->view('regStream', $displayData);
	}


	/**
	 * 开始开播
	 */
	public function startStream()
	{
		$displayData = array();

		$user = $this->streamerModel->get(array('userid' => currentUser('id')));
		if($user['state'] !== '1'){
			$this->message->enqueueMessage('您还没有主播权限!', 'error');
		}else{
			$streamRoom = $this->streamRoomModel->get(array(
				'userid' => $user['userid'],
				'streamerid' => $user['id']
			));
			if($streamRoom){
				if($streamRoom['state'] === '1'){
					$this->message->enqueueMessage('您的直播码: '.$streamRoom['code'].' , 推流地址: rtmp://www.huangshaoshu.com/live , 房间网址: '.mysite_url('/StreamRoom/room/'.$streamRoom['id']), 'success');
				}else{
					$this->message->enqueueMessage('您的房间已被锁定,请联系管理员!', 'error');
				}
			}

			if($this->input->method() == 'post'){

				$streamCodeFlag = 'site:streamCode';

				$follow_action = $this->input->post('_follow-action');
				if($follow_action === '1'){//开播
					if($streamRoom){
						$this->message->enqueueMessage('您已经开始直播了,不能重复开播!', 'error');
					}else{
						$post = $this->input->post(array('title', 'notice'));

						$this->form_validation->reset_validation();
						if($this->form_validation->run() !== FALSE){

							$streamCode = $user['id'].'uu'.$user['userid']; //todo:算法
							if(getRedis()->sIsMember($streamCodeFlag, $streamCode)){
								//todo:重新生成streamcode
							}

							$postData = array();
							$postData['ip'] = $this->input->ip_address();
							$postData['title'] = $post['title'];
							$postData['notice'] = $post['notice'];
							$postData['userid'] = $user['userid'];
							$postData['username'] = $user['username'];
							$postData['streamerid'] = $user['id'];
							$postData['code'] = $streamCode;

							if($userId = $this->streamRoomModel->insert($postData)){

								//redis存储直播码
								getRedis()->sAdd($streamCodeFlag, $streamCode);

								$this->message->enqueueMessage('开播成功!', 'success');

								myredirect('index', 'location');
								return;
							}else{
								$this->message->enqueueMessage('保存数据失败!', 'error');
							}
						}else{
							$this->message->enqueueMessage('表单验证失败!', 'error');
						}
					}
				}elseif($follow_action === '2'){//关播
					if($streamRoom){
						if($streamRoom['state'] === '1'){
							if($this->streamRoomModel->delete($streamRoom['id'])){

								//redis删除直播码
								getRedis()->sRem($streamCodeFlag, $streamRoom['code']);

								$this->message->enqueueMessage('关播成功!', 'success');
							}else{
								$this->message->enqueueMessage('关播失败!', 'error');
							}
						}else{
							$this->message->enqueueMessage('锁定的房间不能关播,请联系管理员!', 'error');
						}
					}else{
						$this->message->enqueueMessage('您未开播!', 'error');
					}
				}
			}
		}



		$msgList = $this->message->getMessageQueue();
		$displayData['msgList'] = $msgList;

		$this->load->view('startStream', $displayData);
	}

}
