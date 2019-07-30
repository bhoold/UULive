<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 上传控制器
 */
class Upload extends MY_Controller {


	/**
	 * 显示上传列表界面
	 */
	public function index()
	{
		$this->load->view('/dashboard');
	}


	/**
	 * 上传
	 */
	public function post()
	{
		$res = array(
			'code' => 1,
			'msg' => '上传成功!',
			'data' => array()
		);


		$config['upload_path']      = $this->config->config['uploadFolder'];
		$config['allowed_types']    = 'gif|jpg|png';
		//$config['max_size']     = 100;
		//$config['max_width']        = 1024;
		//$config['max_height']       = 768;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('file'))
		{
			$res['code'] = 0;
			$res['msg'] = '上传失败';

			//print_r( $error = array('error' => $this->upload->display_errors()) );

		}else{
			$res['data'] = array(
				'src' => $config['upload_path'].$this->upload->data()['file_name']
			);
				//print_r( $data = array('upload_data' => $this->upload->data()) );

		}
		echo json_encode($res);
	}

}
