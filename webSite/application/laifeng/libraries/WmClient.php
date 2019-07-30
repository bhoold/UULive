<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * @Author: Raven
 * @Date: 2019-07-30 02:16:41
 * @Last Modified by: Raven
 * @Last Modified time: 2019-07-30 12:47:23
 */



require_once __DIR__.'/GatewayClient-3.0.13/Gateway.php';

use GatewayClient\Gateway;



/**
 * 与workman通信类
 */
class WmClient {

	public function __construct() {
		Gateway::$registerAddress = getUrl('workmanSvr');
	}



	/**
	 * 绑定websocket、用户、房间的关联
	 *
	 * @param string $clientid
	 * @param string $uid
	 * @param string $roomid
	 * @return void
	 */
	public function bind($clientid, $uid, $roomid) {
		Gateway::bindUid($clientid, $uid);
		// 加入某个群组（可调用多次加入多个群组）
		Gateway::joinGroup($clientid, $roomid);
	}



	/**
	 * 给用户发消息
	 *
	 * @param string $uid
	 * @param string $message
	 * @return void
	 */
	public function send($uid, $message) {
		Gateway::sendToUid($uid, $message);
	}



	/**
	 * 组群发消息
	 *
	 * @param string $gid
	 * @param string $message
	 * @param string $exclude_client_id //排除的
	 * @return void
	 */
	public function sendToGroup($gid, $message, $exclude_client_id = null) {
		Gateway::sendToGroup($gid, $message, $exclude_client_id);
	}
}
