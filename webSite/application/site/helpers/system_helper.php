<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('currentUser'))
{
	/**
	 * 加密密码
	 */
	function currentUser($field = '') {
		$CI =& get_instance();
		$currentUser = $CI->getCurrentUser();
		if($field){
			return $currentUser[$field];
		}else{
			return $currentUser;
		}
	}
}

if ( ! function_exists('getRedis'))
{
	/**
	 * 加密密码
	 */
	function getRedis() {
		$CI =& get_instance();
		$CI->load->library('myRedis');
		return $CI->myredis->instance();
	}
}
