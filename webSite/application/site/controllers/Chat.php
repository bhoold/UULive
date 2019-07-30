<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 上传控制器
 */
class Chat extends MY_Controller {


	/**
	 * 绑定
	 */
	public function bind()
	{
		$this->load->library('workermanGWC');

		$res = array(
			'code' => 1,
			'msg' => '成功进入房间!'
		);

		$clientId = $this->input->post('clientId');
		$hash = $this->input->post('hash');


		if($clientId && $hash && $anyId = getRedis()->get('site:wsChatHash:ack:'.$hash)){
			getRedis()->del('site:wsChatHash:ack:'.$hash);
			$idArr = explode(":", $anyId);
			$userId = $idArr[0];
			$roomId = $idArr[1];
			if($userId == currentUser('id')){

				$this->workermangwc->bind($clientId, currentUser('id'), $roomId);

				$this->workermangwc->sendToGroup($roomId, json_encode(array(
					'type' => 'msg',
					'roomId' => $roomId,
					'msgType' => 'in', //in/out/speak/gift
					'fromId' => '',
					'fromUsername' => '',
					'message' => currentUser('username')
				)), $clientId);
			}else{
				$res = array(
					'code' => 0,
					'msg' => '用户id异常!'
				);
			}

		}else{
			$res = array(
				'code' => 0,
				'msg' => '无法获取hash信息!'
			);
		}


		echo json_encode($res);
	}

	/**
	 * 发送聊天信息
	 */
	public function send()
	{
		$this->load->library('workermanGWC');

		$res = array(
			'code' => 1,
			'msg' => '发送成功!'
		);

		$roomId = $this->input->post('roomId');
		$message = $this->input->post('message');

		if($roomId && $message){

			$this->workermangwc->sendToGroup($roomId, json_encode(array(
				'type' => 'msg',
				'roomId' => $roomId,
				'msgType' => 'speak', //in/out/speak/gift
				'fromId' => currentUser('id'),
				'fromUsername' => currentUser('username'),
				'message' => $message
			)));

		}


		echo json_encode($res);


	}

}
