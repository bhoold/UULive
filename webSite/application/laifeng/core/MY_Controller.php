<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * @Author: Raven
 * @Date: 2019-07-30 02:00:05
 * @Last Modified by: Raven
 * @Last Modified time: 2019-07-30 12:46:12
 */


/**
 * 控制器基类
 */
class MY_Controller extends CI_Controller {


	public function __construct() {
		parent::__construct();

		$this->load->library('session');

		$this->load->helper('url');
		$this->load->helper('util');

	}



}
