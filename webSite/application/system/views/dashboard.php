<?php include VIEWPATH.'layout_header.php'; ?>
<?php include VIEWPATH.'layout_left.php'; ?>


<div class="layui-body">
    <!-- 内容主体区域 -->
    <div id="body-container">
		<h2>首页</h2>
			<div class="layui-card">
				<div class="layui-card-header">系统信息</div>
				<div class="layui-card-body">
					<p>cms系统版本: <?php echo MOCMS_VERSION;?></p>
					<p>ci框架版本: <?php echo CI_VERSION;?></p>
					<p>php运行环境: <?php echo php_uname('s');echo ' + ';echo 'php'.PHP_VERSION;?></p>
				</div>
			</div>
		</div>
	</div>


<?php include VIEWPATH.'layout_footer.php'; ?>
