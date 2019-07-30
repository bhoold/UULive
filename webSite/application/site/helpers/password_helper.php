<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('password'))
{
	/**
	 * 加密密码
	 */
	function password($pass) {
		return md5(substr(md5(trim($pass)), 3, 26));
	}
}
