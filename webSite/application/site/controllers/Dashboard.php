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
	 * 跳转到房间列表
	 */
	public function index()
	{
		myredirect('/StreamRoom/index');
	}
}
