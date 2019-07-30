<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>优优直播</title>
  <link rel="stylesheet" href="<?php echo getUrl('base')?>assets/layui/css/layui.css"  media="all">
	<script src="<?php echo getUrl('base')?>assets/layui/layui.js" charset="utf-8"></script>
</head>
<body>

<div id="header">
	<div class="container">
		<h1 class="logo">优优直播</h1>
		<div class="nav"></div>
		<div class="search"></div>
		<div class="user"></div>
	</div>
</div>

<div id="body"></div>

<div id="footer"></div>

<script>
layui.use(['form'], function(){
	var $ = layui.jquery;
	console.log($)
});
</script>
</body>
</html>
