<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html dir="ltr" lang="zh-cn">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>优优直播</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="format-detection" content="telephone=no">

  <link rel="stylesheet" href="<?php echo mybase_url()?>assets/layui/css/layui.css"  media="all">
</head>
<body class="layui-layout-body">
<div id="form-box">
<h1>优优直播</h1>
<div class="form-error-msg-block">
<?php echo validation_errors(); ?>
<?php
if(isset($msgList) && is_array($msgList) && $msgList){
	foreach ($msgList as $msg){
		echo '<p>'.$msg['message'].'</p>';
	}
}
?>

</div>
<?php echo form_open('/Login/index', array('class'=>'layui-form','lay-filter'=>'form')); ?>
  <div class="layui-form-item">
    <label class="layui-form-label">账号</label>
    <div class="layui-input-inline">
      <input type="text" name="username" required  lay-verify="required" placeholder="请输入账号" autocomplete="off" class="layui-input" value="<?php echo set_value('username'); ?>">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">密码</label>
    <div class="layui-input-inline">
      <input type="password" name="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input" value="<?php echo set_value('password'); ?>">
    </div>
  </div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="*">登录</button>
    </div>
  </div>
<?php echo form_close(); ?>
</div>
<style>
	.layui-layout-body{
		background: url('<?php echo mybase_url()?>assets/images/loginbackground.jpg') no-repeat #009688;
	}
	#form-box{
		position: absolute;
		width: 440px;
		height: 238px;
		left: 50%;
		top: 50%;
		margin-left: -220px;
		margin-top: -169px;
		padding-top: 100px;
		border: 1px solid #ccc;
		background: #fff;
	}
	h1{
		position: absolute;
		top: -50px;
		width: 100%;
		text-align: center;
		color: #fff;
	}
	.form-error-msg-block{
		position: absolute;
		top: 30px;
		width: 100%;
		text-align: center;
		color: red;
	}
</style>
<script src="<?php echo mybase_url()?>assets/layui/layui.js" charset="utf-8"></script>
<script>
//Demo
layui.use('form', function(){
  var form = layui.form;

  //监听提交
  form.on('submit(*)', function(data){

    //layer.msg(JSON.stringify(data.field));
    return true;
  });
});
</script>
</body>
</html>
