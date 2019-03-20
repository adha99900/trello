<?php
	require_once('db.php');
	
	$sql="SELECT `title` FROM `boards` WHERE `id` = '{$_GET['id']}'";
	$title=get_data($db->query($sql))[0]['title'];
	
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/trello.css">
</head>
<body >
	<input type="hidden" id="board_title" value="<?= $_GET['id'] ?>">
	
	<div class="header">
		<div class="header-left">
			<a href="boards.php">home</a>
			<button type='button' class="select-borders" id='0'>看板</button>
			<button type='button' class="share_button" id="1">共享</button>
			<div class="hidden-select-borders" style="display:none;">
				<div>個人看板</div>
				<div class="my-board"></div>
			</div>
			<div class="share-msg" style="display:none;">
				<input type="text" class="email-or-name" placeholder="電子信箱地址或名稱">
				<button type="button" class="share" disabled>邀請</button>
				<button type="button" class="hidden-share">邀請</button>
			</div>
		</div>
	</div>
	
	<div class="board-header">
		<span class="title"><?=$title?></span>
		<span><input class="title-input" value="<?=$title?>"></span>
	</div>
	
	<div class="list">
		<?php 
			$sql="SELECT * FROM `list` WHERE `board_id`='{$_GET['id']}'";
			foreach((array)get_data($db->query($sql)) as $i){
		?>
		<div id="<?= $i['id'] ?>" class='list-box'>
			<div class='list-title'><?= $i['title'] ?></div>
			<input type='text' class='list-title' style='display:none;'>
			<div class='list-cards'>
				<?php 
					$sql="SELECT * FROM `card` WHERE `list_id`='{$i['id']}'";
					foreach((array)get_data($db->query($sql)) as $j){
				?>
				<div class='list-card' id="<?=$j['id']?>"><?= $j['name'] ?></div>
				<?php } ?>
			</div>
			<div class='list-card-add'>+新增另一張卡片</div>
			<div class='list-add-msg' style='display:none;'>
				<input type='text' class='list-input' placeholder='為這張卡片輸入標題...'>
				<button type='button' class='add-card'>輸入</button>
				<button type='button' class='cancle-card'>取消</button>
			</div>
		</div>
		<?php } ?>
		<div class="new-list-box" >+新增其他列表</div>
	</div>
	
	<div class='bg-box'>
		<input type='text' class='new-list-title' placeholder="為列表輸入標題...">
		<button type='button' class='add-list'>輸入</button>
		<button type='button' class='cancle-list'>取消</button>
	</div>
	
	<div class="bg"></div>
	<div class="list-card-window">
		<div class="list-card-window-tilte" id="list-card-name"></div>
		<input type="text" class="list-card-window-tilte" id="hidden-list-card-name" style="display:none;">	
		
		<div class="list-card-window-tilte">描述</div>
		<div class="description">新增更詳細的敘述...</div>
		<input type="text" class="hidden-description" placeholder="新增更詳細的敘述...">
		<div>
			<button type="button" class="description-save">儲存</button>
			<button type="button" class="description-cancle">取消</button>
		</div>
		<div class="list-card-window-tilte">新增評論</div>
		<div><input type="text" class="comment"></div>
		<div class="list-card-window-tilte">活動</div>
		<div class="list-card-active"></div>
	</div>
	
	<script src="jquery/jquery.min.js"></script>
	<script src="jquery/jquery-ui.min.js"></script>
	<script src="js/trello.js"></script>
	
</body>
</html>