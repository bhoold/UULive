<?php include VIEWPATH.'layout_header.php'; ?>
<?php include VIEWPATH.'layout_left.php'; ?>


<div class="layui-body">
    <!-- 内容主体区域 -->
    <div id="body-container">
			<h2><?php echo $room['username'];?>的直播 - <?php echo $room['title'];?></h2>

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

	<div class="layui-row">
    <div class="layui-col-md9"><video id="videoElement"></video></div>
    <div class="layui-col-md3">
			<div>
			<div id="notice" style="margin-bottom:10px;">
				<h3>公告</h3>
				<?php echo $room['notice'];?>
			</div>
			<h3>评论</h3>
			<ul id="messageBox" style="height: 400px;">

			</ul>
			<textarea id="msgField" class="layui-textarea"></textarea>
			<button id="btnMsgSender" class="layui-btn layui-btn-primary">发送</button>
			</div>
    </div>
  </div>



<script src="https://cdn.bootcss.com/flv.js/1.5.0/flv.min.js"></script>
<script>
	if (flvjs.isSupported()) {
			var videoElement = document.getElementById('videoElement');
			var flvPlayer = flvjs.createPlayer({
					type: 'flv',
					url: '<?php echo getUrl('flv').$room['code'].'.flv';?>'
			});
			flvPlayer.attachMediaElement(videoElement);
			flvPlayer.load();
			function clickEvent(){
				flvPlayer.play();
				document.removeEventListener('click',clickEvent)
			}
			document.addEventListener('click',clickEvent)
	}
</script>






		</div>
	</div>

<script>
layui.config({
  base: '<?php echo mybase_url()?>assets/layui/component/' //假设这是你存放拓展模块的根目录
}).extend({ //设定模块别名
  alert: 'alert/alert'
});

layui.use(['layer','alert'], function(){
	var $ = layui.$
	,layer = layui.layer
	,alert = layui.alert;
window.j = $;

$('#btnMsgSender').click('click', function(){
	var message = $('#msgField').val();
	if(message !== ''){
		$('#msgField').val('');
		$.post('<?php echo mysite_url('/Chat/send');?>', {
			message: message,
			roomId: roomid
		}, function(data){}, 'json');
	}
});


var uid = <?php echo currentUser('id');?>;
var roomid = <?php echo $room['id'];?>;
var wsServer = '<?php echo getWebSocket('url').'?hash='.$wsHash;?>';
var websocket = new WebSocket(wsServer);
websocket.onopen = function (evt) {
    console.log("Connected to WebSocket server.");
};

websocket.onclose = function (evt) {
    console.log("Disconnected");
};

websocket.onmessage = function (evt) {
	// json数据转换成js对象
	var data = eval("("+evt.data+")");
	var type = data.type || '';
	switch(type){
		case 'init':
			$.post('<?php echo mysite_url('/Chat/bind');?>', {
				clientId: data.client_id,
				hash: '<?php echo $wsHash;?>'
			}, function(data){}, 'json');
			break;
		case 'msg':
				if(roomid != data.roomId){
					return;
				}
			switch(data.msgType){
				case 'in':
					$('#messageBox').append('<li>' + data.message + '进来了</li>');
					break;
				case 'speak':
					$('#messageBox').append('<li>' + data.fromUsername + '说：' + data.message + '</li>');
					break;
				case 'gift':
					break;
			}
			break;
		default :
			console.log(evt.data);
	}
};

websocket.onerror = function (evt, e) {
    console.log('Error occured: ' + evt.data);
};




});
</script>

<?php include VIEWPATH.'layout_footer.php'; ?>
