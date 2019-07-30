<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * @Author: Raven
 * @Date: 2019-07-30 12:41:03
 * @Last Modified by: Raven
 * @Last Modified time: 2019-07-30 12:45:06
 */


/**
 * 扩展系统CI_Security类
 */
class MY_Security extends CI_Security {


	public function __construct() {
		parent::__construct();

	}



	/**
	 * csrf验证方法，增加对ajax不验证
	 *
	 * @return void
	 */
	public function csrf_verify() {
		if(( ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')){
			return $this;
		}

		return parent::csrf_verify();
	}

}
