<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Message {

	protected $_messageFlag = 'application.system.messageQueue';

	public function __construct()
	{
		$CI =& get_instance();

		$CI->load->library('session');

	}

	public function enqueueMessage($msg, $type = 'message')
	{
		// Don't add empty messages.
		if (trim($msg) === '')
		{
			return;
		}

		$message = array('message' => $msg, 'type' => strtolower($type));

		$CI =& get_instance();
		$session = $CI->session;
		$messageQueue = $session->userdata($this->_messageFlag);

		if(!is_array($messageQueue)){
			$messageQueue = array();
		}
		if(!count($messageQueue) || !in_array($message, $messageQueue)){
			$messageQueue[] = $message;
		}

		$session->set_userdata($this->_messageFlag, $messageQueue);
	}


	public function getMessageQueue()
	{
		$CI =& get_instance();
		$session = $CI->session;
		$messageQueue = $session->userdata($this->_messageFlag);

		if(!is_array($messageQueue)){
			$messageQueue = array();
		}

		$session->unset_userdata($this->_messageFlag);

		return $messageQueue;
	}
}
