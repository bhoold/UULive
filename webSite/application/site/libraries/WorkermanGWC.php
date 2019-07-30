<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__.'/GatewayClient-3.0.13/Gateway.php';
use GatewayClient\Gateway;

class WorkermanGWC {


	protected $_regAddr = '127.0.0.1:1238';


	public function __construct()
	{
		Gateway::$registerAddress = $this->_regAddr;
	}


	/**
	 * 绑定
	 */
	public function bind($clientid, $uid, $roomid)
	{
		Gateway::bindUid($clientid, $uid);
		// 加入某个群组（可调用多次加入多个群组）
		Gateway::joinGroup($clientid, $roomid);
	}


	/**
	 * 发信息
	 */
	public function send($uid, $message)
	{
		Gateway::sendToUid($uid, $message);
	}


	/**
	 * 发组信息
	 */
	public function sendToGroup($gid, $message, $exclude_client_id = null)
	{
		Gateway::sendToGroup($gid, $message, $exclude_client_id);
	}
}
