<?php include VIEWPATH.'layout_header.php'; ?>
<?php include VIEWPATH.'layout_left.php'; ?>


  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div id="body-container">
		<h2>后台用户 - 编辑</h2>

			<div class="toolbar layui-btn-container">
				<button type="button" class="layui-btn" id="toolBtnSubmit" data-type="save" data-value="1">保存</button>
				<button type="button" class="layui-btn layui-btn-primary" data-type="save_close" data-value="2">保存&返回</button>
				<button type="button" class="layui-btn layui-btn-primary" data-type="save_new" data-value="3">保存&新增</button>
				<button type="button" class="layui-btn layui-btn-primary" data-type="cancel">取消</button>
			</div>

			<?php if(validation_errors()):?>
			<div class="layui-alert alert-error">
				<button type="button" class="close">×</button>
				<?php echo validation_errors(); ?>
			</div>
			<?php endif; ?>

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




			<?php echo form_open('', array('id'=>'form','class'=>'layui-form','lay-filter'=>'form')); ?>

				<input type="hidden" name="_follow-action">

				<div class="layui-form-item">
					<label class="layui-form-label">账号</label>
					<div class="layui-input-inline">
						<input type="text" name="username" autocomplete="off" class="layui-input layui-disabled" value="<?php echo set_value('username', $user['username']); ?>" disabled>
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">密码</label>
					<div class="layui-input-inline">
						<input type="password" name="password" autocomplete="off" class="layui-input" value="<?php echo set_value('password'); ?>">
					</div>
				</div>
        <div class="layui-form-item">
          <label class="layui-form-label">状态</label>
          <div class="layui-input-inline">
						<?php echo form_hidden('state', '0');?>
            <input type="checkbox" name="state" lay-skin="switch" lay-text="启用|停用" value="1" <?php echo set_checkbox('state', '1', $user['state']==='1'?TRUE:FALSE); ?>>
          </div>
        </div>
				<div class="layui-form-item layui-hide">
					<div class="layui-input-block">
						<button type="submit" class="layui-btn" lay-submit lay-filter="*">提交</button>
						<button type="reset" class="layui-btn layui-btn-primary">重置</button>
					</div>
				</div>
			<?php echo form_close(); ?>

		</div>
  </div>

	<script>
layui.config({
  base: '<?php echo mybase_url()?>assets/layui/component/' //假设这是你存放拓展模块的根目录
}).extend({ //设定模块别名
  alert: 'alert/alert'
});

layui.use(['form','alert'], function(){
	var form = layui.form,
			$ = layui.jquery;

  //事件
  var active = {
		save: function() {
			var value = $(this).data('value');
			$('#form input[name="_follow-action"]').val(value);
			$('#form button[lay-submit]').trigger('click');
		},
		save_close: function() {
			var value = $(this).data('value');
			$('#form input[name="_follow-action"]').val(value);
			$('#form button[lay-submit]').trigger('click');
		},
		save_new: function() {
			var value = $(this).data('value');
			$('#form input[name="_follow-action"]').val(value);
			$('#form button[lay-submit]').trigger('click');
		},
		cancel: function() {
			location.href = "<?php echo mysite_url('index');?>";
		}
  };

  $('.toolbar .layui-btn').on('click', function(){
    var type = $(this).data('type');
    active[type] ? active[type].call(this) : '';
  });

  //监听提交
  form.on('submit(*)', function(data){

    return true;
  });
});
</script>


<?php include VIEWPATH.'layout_footer.php'; ?>
