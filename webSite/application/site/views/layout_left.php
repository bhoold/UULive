<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php
	$uriArr = explode('/', uri_string());
	$layoutLeft = array(
		'uri' => array(
			'action' => $uriArr[0],
			'method' => $uriArr[1]
		)
	);
	unset($uriArr);

?>
<div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree"  lay-filter="test">
				<li class="layui-nav-item <?php echo $layoutLeft['uri']['action']=='StreamRoom'?' layui-this ':'';?>"><a href="<?php echo mysite_url('/StreamRoom/index');?>">房间</a></li>
				<li class="layui-nav-item <?php echo $layoutLeft['uri']['action']=='Person'?' layui-this ':'';?>"><a href="<?php echo mysite_url('/Person/index');?>">我的主页</a></li>
			</ul>
    </div>
  </div>
