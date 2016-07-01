<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\CoreHelper;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>留言板</title>
	<link rel="stylesheet" href="css/base.css" />
	<link rel="stylesheet" href="css/guestbook.css" />
	<script>
		var maxLength = '<?= $maxLength ?>';
		var pagesize = '<?= $pagesize ?>';
	</script>
	<script type="text/javascript" src='js/jquery-1.7.2.min.js'></script>
	<script type="text/javascript" src="js/base.js"></script>
	<script type="text/javascript" src='js/guestbook.js'></script>
</head>
<body>

	<div id='top'>
		<span id='send'></span>
	</div>

	<div id='main'>

	<?php foreach($messages as $key => $message): ?>

		<dl class="paper a<?= $key % 5 + 1 ?>">
			<dt>
				<span class="username"><?= Html::encode($message["nickname"]) ?></span>
				<span class="num">No.<?= CoreHelper::zeroFill($message["id"]) ?></span>
			</dt>
			<dd class="content"><?= $message["content"] ?></dd>
			<dd class="bottom">
				<span class="time"><?= CoreHelper::formatTimestamp($message["addtime"]) ?></span>
				<a onclick class="close"></a>
			</dd>
		</dl>

	<?php endforeach ?>

	</div>

	<div id='send-form'>
		<p class='title'><span>来了就说点什么吧</span><a href="" id='close'></a></p>
		<form name='wish'>
			<p>
				<label for="nickname">昵称：</label>
				<input type="text" name='nickname' id='nickname'/>
			</p>
			<p>
				<label for="content">留言：(您还可以输入<span id='font-num'><?= $maxLength ?></span>个字)</label>
				<textarea name="content" id='content'></textarea>
				<div id='phiz'>
					<?php foreach($ubb as $k => $v): ?>
						<img src="/images/phiz/<?= $k ?>.gif" alt="<?= Html::encode($v) ?>" />
					<?php endforeach ?>
				</div>
			</p>
			<span id='send-btn'></span>
		</form>
	</div>

	<div id="go-home">
		<a title="回到首页" href="<?= Url::home() ?>"><i></i></a>
	</div>

<!--[if IE 6]>
    <script type="text/javascript" src="/js/iepng.js"></script>
    <script type="text/javascript">
        DD_belatedPNG.fix('#send,#close,.close','background');
    </script>
<![endif]-->

	<script>

		$(function () {

			$( '#main' ).height( $( window ).height() - $( '#top' ).height() - 45);

			var paper = $( '.paper' );
			var FW = $( window ).width();
			var FH = $( '#main' ).height();
			for (var i = 0; i < paper.length; i++) {
				var obj = paper.eq(i);
				obj.css( {
					left : parseInt(Math.random() * (FW - obj.width())) + 'px',
					top : parseInt(Math.random() * (FH - obj.height())) + 'px'
				} );
				drag(obj, $( 'dt', obj ));
			}

			paper.click( function () {
				$( this ).css( 'z-index', 1 ).siblings().css( 'z-index', 0 );
			} );

			$( '.close' ).click( function () {
				$( this ).parents( 'dl' ).fadeOut('slow');
				return false;
			} );

			$( '#send' ).click( function () {
				$.ajax({
					url : '<?= Url::to(['/message/get-nickname'])?>',
					type : 'POST',
					data : {_csrf : '<?= Yii::$app->request->csrfToken ?>'},
					dataType : 'JSON',
					timeout : 10000,
					success : function(rt){
						if(rt.err_code > 0){
							error(rt.msg);
							return false;
						} else {
							var data = rt.data;
							$( '<div id="windowBG"></div>' ).css( {
								width : $(document).width(),
								height : $(document).height(),
								position : 'absolute',
								top : 0,
								left : 0,
								zIndex : 998,
								opacity : 0.3,
								filter : 'Alpha(Opacity = 30)',
								backgroundColor : '#000000'
							} ).appendTo( 'body' );

							var obj = $( '#send-form' );
							obj.find('#nickname').val(data.nickname);
							obj.css( {
								left : ( $( window ).width() - obj.width() ) / 2,
								top : $( document ).scrollTop() + ( $( window ).height() - obj.height() ) / 2
							} ).fadeIn();
						}
					},
					complete : function(xhr, status){
						if(status == "timeout"){
							error('网络异常，请稍后再试');
							return false;
						}
					}
				});
			} );

			$( '#close' ).click( function () {
				$( '#send-form' ).fadeOut( 'slow', function () {
					$( '#windowBG' ).remove();
				} );
				return false;
			} );

			//实时显示文本长度
			var showTextLength = function () {
				var content = $('textarea[name=content]').val();
				var lengths = check(content);  //调用check函数取得当前字数
				maxLength = maxLength ? maxLength : 100;

				//最大允许输入50个字
				if (lengths[0] >= maxLength) {
					$('textarea[name=content]').val(content.substring(0, Math.ceil(lengths[1])));
				}

				var num = maxLength - Math.ceil(lengths[0]);
				var msg = num < 0 ? 0 : num;
				//当前字数同步到显示提示
				$( '#font-num' ).html( msg );
			};

			$( 'textarea[name=content]' ).keyup( showTextLength );

			$( '#phiz img' ).click( function () {
				var phiz = '[' + $( this ).attr('alt') + ']';
				var obj = $( 'textarea[name=content]' );
				obj.val(obj.val() + phiz);

				showTextLength();    //显示文本长度
			} );

		});


		$('#send-btn').click(function(){
			var nickname = $.trim($('#nickname').val());
			if(nickname == ''){
				error('请填写昵称');
				return false;
			}
			var content = $('#content').val();
			if(content == ''){
				error('请填写留言内容');
				return false;
			}
			$.ajax({
				url : '<?= Url::to(['/message/add']) ?>',
				type : 'POST',
				data : {
					_csrf : '<?= Yii::$app->request->csrfToken ?>',
					nickname : nickname,
					content : content
				},
				dataType : 'JSON',
				timeout : 10000,
				success : function(rt){
					if(rt.err_code > 0){
						error(rt.msg);
						return false;
					}else{
						var data = rt.data;
						$('#send-form').hide();
						$('#send-form input[type="text"],#send-form textarea').val('');
						$('#windowBG').remove();
						var lastDL = $('#main dl:last').attr('class').match(/\d+$/);
						if(lastDL){
							var lastIndex = parseInt(lastDL.pop()) + 1;
							if(lastIndex > 5){
								lastIndex = 1;    //超过5从1重新计算
							}
							var dlClass = $('#main dl:last').attr('class').replace(/\d+$/, lastIndex);
						}else{
							var dlClass = 'paper a1';
						}

						var str = '<dl class="' + dlClass + '">';
						str += '<dt>';
						str += '<span class="username">' + data.nickname + '</span>';
						str += '<span class="num">No.' + data.id + '</span>';
						str += '</dt>';
						str += '<dd class="content">' + data.content + '</dd>';
						str += '<dd class="bottom">';
						str += '<span class="time">' + data.addtime + '</span>';
						str += '<a onclick class="close"></a>';
						str += '</dd>';
						str += '</dl>';
						var FW = $( window ).width();
						var FH = $( '#main' ).height();
						var _this = $(str);
						_this.appendTo('#main');
						_this.css({
							left : parseInt(Math.random() * (FW - _this.width())) + 'px',
							top : parseInt(Math.random() * (FH - _this.height())) + 'px',
							display : 'none'
						});
						_this.fadeIn(1000);
						if($('#main dl').length > pagesize){
							$('#main dl:first').remove();
						}
						drag(_this, $('dt', _this));
						success('添加留言成功');
					}
				},
				complete : function(xhr, status){
					if(status == 'timeout'){
						error('网络异常，请稍后再试');
						return false;
					}
				}
			});
		});
	</script>
</body>
</html>