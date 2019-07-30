<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * @Author: Raven
 * @Date: 2019-07-30 01:53:43
 * @Last Modified by: Raven
 * @Last Modified time: 2019-07-30 01:56:47
 */



$config['socket_type'] = 'tcp'; //`tcp` or `unix`
//$config['socket'] = '/var/run/redis.sock'; // in case of `unix` socket type
$config['host'] = '172.18.22.50';
$config['password'] = NULL;
$config['port'] = 6379;
$config['timeout'] = 0;
