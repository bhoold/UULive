<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * @Author: Raven
 * @Date: 2019-07-30 01:33:58
 * @Last Modified by: Raven
 * @Last Modified time: 2019-07-30 02:29:05
 */



/**
 * 首页控制器
 */
class Home extends MY_Controller {


	/**
	 * 默认页面
	 *
	 * @return void
	 */
	public function index() {
		$this->load->view('home');

	}



	public function test($a ,$b ,$c) {
		echo 22;
		echo 234;
	}


}
