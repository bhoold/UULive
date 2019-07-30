<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class MyRedis {

	protected $_redis;

	public function __construct()
	{
		$CI =& get_instance();
		$config = array();

		if ($CI->config->load('redis', TRUE, TRUE))
		{
			$config = $CI->config->item('redis');
		}else{
			log_message('error', '未定义redis配置');
			return;
		}

		$this->_redis = new Redis();

		try
		{
			if ($config['socket_type'] === 'unix')
			{
				$success = $this->_redis->connect($config['socket']);
			}
			else // tcp socket
			{
				$success = $this->_redis->connect($config['host'], $config['port'], $config['timeout']);
			}

			if ( ! $success)
			{
				log_message('error', 'redis连接失败, 请检查配置');
			}

			if (isset($config['password']) && ! $this->_redis->auth($config['password']))
			{
				log_message('error', 'redis认证失败');
			}
		}
		catch (RedisException $e)
		{
			log_message('error', 'redis连接失败 ('.$e->getMessage().')');
		}

	}

	public function instance()
	{
		return $this->_redis;
	}

}
