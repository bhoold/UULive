<?php include VIEWPATH.'layout_header.php'; ?>
<?php include VIEWPATH.'layout_left.php'; ?>


<div class="layui-body">
    <!-- 内容主体区域 -->
    <div id="body-container">
			<h2>我的主页</h2>

			<div class="toolbar layui-btn-container">
				<button type="button" class="layui-btn layui-btn-primary" data-type="regStream">主播入驻</button>
				<button type="button" class="layui-btn layui-btn-primary" data-type="startStream">我要开播</button>
			</div>


		<?php
			$alert = array('error' => 'alert-error', 'warning' => '', 'notice' => 'alert-info', 'message' => 'alert-success');
		?>
		<?php if (isset($msgList) && is_array($msgList) && $msgList) : ?>
		<?php foreach ($msgList as $msg) : ?>
				<div class="layui-alert <?php echo isset($alert[$msg['type']]) ? $alert[$msg['type']] : 'alert-' . $msg['type']; ?>">
					<button type="button" class="close">&times;</button>
					<?php echo $msg['message']; ?>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>


		</div>
	</div>

<script>
layui.config({
  base: '<?php echo mybase_url()?>assets/layui/component/' //假设这是你存放拓展模块的根目录
}).extend({ //设定模块别名
  alert: 'alert/alert'
});

layui.use(['form', 'table','laypage','layer','alert'], function(){
	var $ = layui.$
	,layer = layui.layer
	,form = layui.form
	,table = layui.table
	,laypage = layui.laypage;

  //事件
  var active = {
		regStream: function() {
			location.href = "<?php echo mysite_url('/Person/regStream');?>";
		},
		startStream: function() {
			location.href = "<?php echo mysite_url('/Person/startStream');?>";
		}
  };


  $('.toolbar .layui-btn').on('click', function(){
    var type = $(this).data('type');
    active[type] ? active[type].call(this) : '';
  });

});
</script>

<?php include VIEWPATH.'layout_footer.php'; ?>
