<?php include VIEWPATH.'layout_header.php'; ?>
<?php include VIEWPATH.'layout_left.php'; ?>


  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div id="body-container">
		<h2>主播入驻</h2>

			<div class="toolbar layui-btn-container">
				<button type="button" class="layui-btn" id="toolBtnSubmit" data-type="save" data-value="1">申请</button>
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

				<input type="hidden" name="input_pic1" id="input_pic1">
				<input type="hidden" name="input_pic2" id="input_pic2">


				<div class="layui-form-item">
					<label class="layui-form-label">身份证正面</label>
					<div class="layui-input-inline">
						<button type="button" class="layui-btn" id="btn_pic1"><i class="layui-icon">&#xe67c;</i>上传图片</button><img id="pic1" src="" alt="">
					</div>
				</div>
				<div class="layui-form-item">
					<label class="layui-form-label">身份证反面</label>
					<div class="layui-input-inline">
						<button type="button" class="layui-btn" id="btn_pic2"><i class="layui-icon">&#xe67c;</i>上传图片</button><img id="pic2" src="" alt="">
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

layui.use(['form','alert', 'upload'], function(){
	var form = layui.form,
			$ = layui.jquery;
	var upload = layui.upload;

  //事件
  var active = {
		save: function() {
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



  upload.render({
    elem: '#btn_pic1' //绑定元素
    ,url: "<?php echo mysite_url('/Upload/post');?>" //上传接口
    ,done: function(res){
      if(res.code){
				$('#pic1').attr('src', '<?php echo base_url();?>' + res.data.src);
				$('#input_pic1').val(res.data.src);
			}else{
				$('#pic1').hide().attr('src', '');
				$('#input_pic1').val();
			}
    }
    ,error: function(){
			$('#pic1').hide().attr('src', '');
      $('#input_pic1').val();
    }
  });
  upload.render({
    elem: '#btn_pic2' //绑定元素
    ,url: "<?php echo mysite_url('/Upload/post');?>" //上传接口
    ,done: function(res){
      if(res.code){
				$('#pic2').attr('src', '<?php echo base_url();?>' + res.data.src);
				$('#input_pic2').val(res.data.src);
			}else{
				$('#pic2').hide().attr('src', '');
				$('#input_pic2').val();
			}
    }
    ,error: function(){
			$('#pic2').hide().attr('src', '');
      $('#input_pic2').val();
    }
  });
});
</script>


<?php include VIEWPATH.'layout_footer.php'; ?>
