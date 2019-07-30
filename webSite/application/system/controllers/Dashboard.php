<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

		if($this->session->isLogined) {
			myredirect('/Login/index');
		}
	}

	/**
	 * 显示控制台界面
	 */
	public function index()
	{
		$this->load->view('/dashboard');
	}
}
