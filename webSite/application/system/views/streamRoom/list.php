<?php include VIEWPATH.'layout_header.php'; ?>
<?php include VIEWPATH.'layout_left.php'; ?>


  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div id="body-container">
		<h2>房间 - 列表</h2>

		<div class="toolbar layui-btn-container">
			<button type="button" class="layui-btn layui-btn-primary" data-type="block">锁定</button>
			<button type="button" class="layui-btn layui-btn-primary" data-type="unblock">解锁</button>
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


    <div class="layui-form layui-card-header layuiadmin-card-header-auto" lay-filter="layadmin-useradmin-formlist">
		<?php echo form_open('', array('method'=>'get','id'=>'form-filter','class'=>'layui-form','lay-filter'=>'form')); ?>

			<?php echo form_hidden('pageNum', $pager['pageNum']);?>
			<?php echo form_hidden('pageSize', $pager['pageSize']);?>

      <div class="layui-form-item">
        <div class="layui-inline">
          <label class="layui-form-label">ID</label>
          <div class="layui-input-block">
            <input type="text" name="filter[id]" placeholder="" autocomplete="off" class="layui-input" value="<?php echo $filter['id'];?>">
          </div>
        </div>
        <div class="layui-inline">
          <label class="layui-form-label">主播</label>
          <div class="layui-input-block">
            <input type="text" name="filter[username]" placeholder="" autocomplete="off" class="layui-input" value="<?php echo $filter['username'];?>">
          </div>
        </div>
        <div class="layui-inline">
					<button type="submit" class="layui-btn" lay-submit lay-filter="search">搜索</button>
        </div>
      </div>
		<?php echo form_close(); ?>
    </div>
    <table class="layui-hide" id="listTable" lay-filter="listTable">
      <thead>
        <tr>
          <th lay-data="{type:'checkbox', fixed: 'left'}"></th>
					<th lay-data="{field:'id', width:80}">ID</th>
          <th lay-data="{field:'streamerid', width:80}">主播ID</th>
          <th lay-data="{field:'username', width:150}">主播</th>
          <th lay-data="{field:'state', width:100}">状态</th>
          <th lay-data="{field:'time', width:200}">开播时间</th>
					<th lay-data="{field:'ip', width:150}">开播IP</th>
          <th lay-data="{field:'title', width:150}">房间标题</th>
          <th lay-data="{field:'notice', width:300}">房间公告</th>
					<!--
          <th lay-data="{type:'space', width:150, fixed: 'right', align:'center', toolbar: '#tableOpts'}">操作</th>
					-->
        </tr>
      </thead>
      <tbody>
				<?php foreach ($list as $item):?>
				<tr>
					<td></td>
					<td><?php echo $item['id'];?></td>
					<td><?php echo $item['streamerid'];?></td>
					<td><?php echo $item['username'];?></td>
					<td><?php echo $item['state'] === '1' ? '正常' : '锁定';?></td>
					<td><?php echo $item['time'];?></td>
					<td><?php echo $item['ip'];?></td>
					<td><?php echo $item['title'];?></td>
					<td><?php echo $item['notice'];?></td>
					<td></td>
        </tr>
				<?php endforeach;?>
      </tbody>
    </table>
		<div id="pager"></div>
		<script type="text/html" id="tableOpts">
			<a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
			<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
		</script>
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
