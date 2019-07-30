<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('mysite_url'))
{
	/**
	 * 扩展site_url函数
	 */
	function mysite_url($uri = '', $protocol = NULL)
	{
		/**
		 * $uri = '/test/test2'; 以/开头第一个是控制器
		 * $uri = 'test'; 没有/开头自动加上当前控制器
		 */
		$CI =& get_instance();
		if($uri){
			if(strpos($uri, '/') !== 0){
				$uri = $CI->router->class.'/'.$uri;
			}
		}

		return site_url($uri, $protocol);
	}
}

if ( ! function_exists('mybase_url'))
{
	/**
	 * 扩展site_url函数
	 */
	function mybase_url()
	{
		$CI =& get_instance();
		return $CI->config->config['base_url'];
	}
}

if ( ! function_exists('myredirect'))
{
	/**
	 * 扩展redirect函数
	 */
	function myredirect($uri = '', $method = 'auto', $code = NULL)
	{
		/**
		 * $uri = '/test/test2'; 以/开头第一个是控制器
		 * $uri = 'test'; 没有/开头自动加上当前控制器
		 */
		$CI =& get_instance();
		if($uri){
			if(strpos($uri, '/') !== 0){
				$uri = $CI->router->class.'/'.$uri;
			}
		}
		redirect($uri, $method, $code);
	}
}
