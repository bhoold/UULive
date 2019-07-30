<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 直播房间控制器
 */
class StreamRoom extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('StreamRoomModel');
	}


	/**
	 * 房间列表界面
	 */
	public function index()
	{
		$displayData = array();


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
				'username' => $this->input->get('filter[username]'),
				'title' => $this->input->get('filter[title]')
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

		$result = $this->streamRoomModel->list($where, $pageNum, $pageSize);
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
	 * 房间
	 */
	public function room($id = '')
	{
		if(!$id){
			return;
		}

		$displayData = array();

		if($streamRoom = $this->streamRoomModel->get(array('id' => $id))){
			$displayData['room'] = $streamRoom;
		}else{
			$displayData['room'] = array();
		}

		//用于websocket验证
		$wsHash = time(); //$this->security->get_random_bytes(10);//todo: 随机数
		$displayData['wsHash'] = $wsHash;
		getRedis()->set('site:wsChatHash:init:'.$wsHash, currentUser('id').':'.$streamRoom['id'], 60);


		$msgList = $this->message->getMessageQueue();
		$displayData['msgList'] = $msgList;

		$this->load->view('room', $displayData);
	}

}
