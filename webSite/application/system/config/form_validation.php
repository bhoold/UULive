<?php

$config = array(
	'SystemUser/add' => array(
		array(
			'field' => 'username',
			'label' => '账号',
			'rules' => 'trim|required',
			'errors' => array('required' => '请输入%s.')
		),
		array(
			'field' => 'password',
			'label' => '密码',
			'rules' => 'trim|required',
			'errors' => array('required' => '请输入%s.')
		),
		array(
			'field' => 'state',
			'label' => '状态'
		)
	),
	'SystemUser/edit' => array(
		array(
			'field' => 'password',
			'label' => '密码',
			'rules' => 'trim'
		),
		array(
			'field' => 'state',
			'label' => '状态'
		)
	),
	'User/add' => array(
		array(
			'field' => 'username',
			'label' => '账号',
			'rules' => 'trim|required',
			'errors' => array('required' => '请输入%s.')
		),
		array(
			'field' => 'password',
			'label' => '密码',
			'rules' => 'trim|required',
			'errors' => array('required' => '请输入%s.')
		),
		array(
			'field' => 'email',
			'label' => '电子邮箱',
			'rules' => 'trim|valid_email',
			'errors' => array('valid_email' => '请输入正确的%s.')
		),
		array(
			'field' => 'sex',
			'label' => '性别'
		),
		array(
			'field' => 'state',
			'label' => '状态'
		)
	),
	'User/edit' => array(
		array(
			'field' => 'password',
			'label' => '密码',
			'rules' => 'trim'
		),
		array(
			'field' => 'email',
			'label' => '电子邮箱',
			'rules' => 'trim|valid_email',
			'errors' => array('valid_email' => '请输入正确的%s.')
		),
		array(
			'field' => 'sex',
			'label' => '性别'
		),
		array(
			'field' => 'state',
			'label' => '状态'
		)
	)
);
