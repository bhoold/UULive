<?php

$config = array(
	'Person/regStream' => array(
		array(
			'field' => 'input_pic1',
			'label' => '身份证正面',
			'rules' => 'trim|required',
			'errors' => array('required' => '请上传%s.')
		),
		array(
			'field' => 'input_pic2',
			'label' => '身份证反面',
			'rules' => 'trim|required',
			'errors' => array('required' => '请上传%s.')
		)
	),
	'Person/startStream' => array(
		array(
			'field' => 'title',
			'label' => '房间标题',
			'rules' => 'trim|required',
			'errors' => array('required' => '请输入%s.')
		),
		array(
			'field' => 'notice',
			'label' => '房间公告'
		)
	)
);
