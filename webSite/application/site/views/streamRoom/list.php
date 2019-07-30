<?php include VIEWPATH.'layout_header.php'; ?>
<?php include VIEWPATH.'layout_left.php'; ?>


  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div id="body-container">
		<h2>房间 - 列表</h2>

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


    <div class="layui-form layui-card-header layuiadmin-card-header-auto" lay-filter="layadmin-useradmin-formlist">
		<?php echo form_open('', array('method'=>'get','id'=>'form-filter','class'=>'layui-form','lay-filter'=>'form')); ?>

			<?php echo form_hidden('pageNum', $pager['pageNum']);?>
			<?php echo form_hidden('pageSize', $pager['pageSize']);?>

      <div class="layui-form-item">
        <div class="layui-inline">
          <label class="layui-form-label">用户</label>
          <div class="layui-input-block">
            <input type="text" name="filter[username]" placeholder="" autocomplete="off" class="layui-input" value="<?php echo $filter['username'];?>">
          </div>
        </div>
        <div class="layui-inline">
          <label class="layui-form-label">房间标题</label>
          <div class="layui-input-block">
            <input type="text" name="filter[title]" placeholder="" autocomplete="off" class="layui-input" value="<?php echo $filter['title'];?>">
          </div>
        </div>
        <div class="layui-inline">
					<button type="submit" class="layui-btn" lay-submit lay-filter="search">搜索</button>
        </div>
      </div>
		<?php echo form_close(); ?>
		</div>
		<ul id="roomList">
			<?php foreach ($list as $item):?>
			<li><a href="<?php echo mysite_url('/StreamRoom/room/'.$item['id']);?>">
				<div class="preview">
				<img alt="<?php echo $item['title'];?>" src="https://u4.iqiyipic.com/xiuchang/20190719/ae/8c/xiuchang_5d30a982d2999d0922ffae8c_640_640.jpg">
				</div>
				<div class="text">
					<p class="title"><?php echo $item['title'];?></p>
					<p class="user"><?php echo $item['username'];?></p>
				</div>
				</a>
			</li>
			<?php endforeach;?>
		</ul>
		<div id="pager"></div>
		<script type="text/html" id="tableOpts">
			<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
			<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
		</script>
		</div>
  </div>

<style>
#roomList{
	margin: 10px -10px;
	overflow:hidden;
}
#roomList li{
	float: left;
	margin: 15px 10px;
	/*height: 212px;*/
	width: 240px;
	transition: all .3s ease-in;
	height: 298px;
}
#roomList li img{
	display: block;
	width: 100%;
	height: 100%;
	transition: all .3s ease;
	background: #eaeaea no-repeat 50%;
}
#roomList li .text{
	position: relative;
	padding: 6px 10px 8px;
	line-height: 25px;
	background: #f8f8f8;
}
#roomList li .text .title{
	color: #333;
	overflow: hidden;
	white-space: nowrap;
	text-overflow: ellipsis;
	font-size: 15px;
}
#roomList li .text .user{
	overflow: hidden;
	white-space: nowrap;
	text-overflow: ellipsis;
	font-size: 13px;
}
</style>
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

  //监听提交
  form.on('submit(search)', function(data){
		if($(data.form).data('isSavePage')){
			$(data.form).data('isSavePage', false);
		}else{
			$(data.form).find('input[name=pageNum]').val(1);
		}
		return true;
	});

  //监听操作
  table.on('tool(listTable)', function(obj){
    var data = obj.data;
    if(obj.event === 'detail'){
      layer.msg('ID：'+ data.id + ' 的查看操作');
    } else if(obj.event === 'del'){
      layer.confirm('确定删除吗？', function(index){
        obj.del();
        layer.close(index);
      });
    } else if(obj.event === 'edit'){
      layer.alert('编辑行：<br>'+ JSON.stringify(data))
    }
	});


  //事件
  var active = {
		add: function() {
			location.href = "<?php echo mysite_url('add');?>";
		},
		edit: function() {
			var checkStatus = table.checkStatus('listTable');
			if(checkStatus.data.length){
				var id = checkStatus.data[0].id;
				location.href = "<?php echo mysite_url('edit/" + id + "');?>";
			}else{
				layer.msg('请从列表中选择', {icon: 5, shift: 6});
			}
		},
		del: function() {
			var checkStatus = table.checkStatus('listTable');
			if(checkStatus.data.length){
				layer.confirm('确定要删除吗？', function() {
					var ids = [];
					layui.each(checkStatus.data, function(index, item){
						ids.push(item.id);
					});

					$('#form-filter').prepend('<input type="hidden" name="_action" value="delete" /><input type="hidden" name="_action_id" value="'+ids.join(',')+'" />');

					$('#form-filter').data('isSavePage', true);
					$('#form-filter button[lay-submit]').trigger('click');
				});
			}else{
				layer.msg('请从列表中选择', {icon: 5, shift: 6});
			}
		},
		block: function() {
			var checkStatus = table.checkStatus('listTable');
			if(checkStatus.data.length){
				var ids = [];
				layui.each(checkStatus.data, function(index, item){
					ids.push(item.id);
				});

				$('#form-filter').prepend('<input type="hidden" name="_action" value="state" /><input type="hidden" name="_action_state" value="block" /><input type="hidden" name="_action_id" value="'+ids.join(',')+'" />');

				$('#form-filter').data('isSavePage', true);
				$('#form-filter button[lay-submit]').trigger('click');
			}else{
				layer.msg('请从列表中选择', {icon: 5, shift: 6});
			}
		},
		unblock: function() {
			var checkStatus = table.checkStatus('listTable');
			if(checkStatus.data.length){
				var ids = [];
				layui.each(checkStatus.data, function(index, item){
					ids.push(item.id);
				});

				$('#form-filter').prepend('<input type="hidden" name="_action" value="state" /><input type="hidden" name="_action_state" value="unblock" /><input type="hidden" name="_action_id" value="'+ids.join(',')+'" />');

				$('#form-filter').data('isSavePage', true);
				$('#form-filter button[lay-submit]').trigger('click');
			}else{
				layer.msg('请从列表中选择', {icon: 5, shift: 6});
			}
		}
  };

  $('.toolbar .layui-btn').on('click', function(){
    var type = $(this).data('type');
    active[type] ? active[type].call(this) : '';
  });




	//转换静态表格
	table.init('listTable', {
		//height: 315 //设置高度
		//,limit: 10 //注意：请务必确保 limit 参数（默认：10）是与你服务端限定的数据条数一致
		//支持所有基础参数
		page: false
	});

  laypage.render({
		elem: 'pager',
		layout: ['prev', 'page', 'next', 'count', 'limit', 'skip'],
		count: <?php echo $pager['count'];?>,
		curr: <?php echo $pager['pageNum'];?>,
		limit: <?php echo $pager['pageSize'];?>,
		//limits: [10,12],
		jump: function(obj, first){
			//首次不执行
			if(!first){
				$('#form-filter input[name="pageNum"]').val(obj.curr);
				$('#form-filter input[name="pageSize"]').val(obj.limit);
				$('#form-filter').data('isSavePage', true);
				$('#form-filter button[lay-submit]').trigger('click');
			}
		}
  });


});


</script>


<?php include VIEWPATH.'layout_footer.php'; ?>
