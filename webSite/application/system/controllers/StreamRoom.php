<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 主播控制器
 */
class StreamRoom extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('StreamRoomModel', 'roomModel');

	}


	/**
	 * 显示房间列表界面
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

		$result = $this->roomModel->list($where, $pageNum, $pageSize);
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
	 * 设置主播状态
	 */
	private function _setState($idsStr, $state)
	{
		if($this->roomModel->setState($idsStr, $state)){
			$this->message->enqueueMessage('ID:' . $idsStr . ' ' . ($state ? '解锁成功!' : '锁定成功!'), 'success');
		}else{
			$this->message->enqueueMessage('ID:' . $idsStr . ' ' . ($state ? '解锁失败!' : '锁定失败!'), 'error');
		}
	}


}
