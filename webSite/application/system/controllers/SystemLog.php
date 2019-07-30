<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 用户控制器
 */
class SystemLog extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('SystemLogModel', 'logModel');

	}


	/**
	 * 显示日志列表界面
	 */
	public function index()
	{
		$displayData = array();

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

		$result = $this->logModel->list($where, $pageNum, $pageSize);
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


		$msgList = $this->message->getMessageQueue();
		$displayData['msgList'] = $msgList;

		$this->load->view('', $displayData);
	}



}
