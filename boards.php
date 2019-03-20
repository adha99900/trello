<?php
	require_once("db.php");
	if(!isset($_SESSION['data'])){header("location:index.php");}
	$sql="SELECT * FROM `boards` WHERE `user_id`='{$_SESSION['data']['id']}'";
	$result=$db->query($sql);
	$data=get_data($result);
	
	if(isset($_POST['create'])){
		$sql="INSERT INTO `boards`(`user_id`,`title`) VALUES ('{$_SESSION['data']['id']}','{$_POST['title']}')";
		$db->query($sql);
		$sql="SELECT * FROM `boards` WHERE `user_id`='{$_SESSION['data']['id']}'";
		$result=$db->query($sql);
		$data=get_data($result);
		header("location:trello.php?id=".$data[count($data)-1]['id']);
	}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/boards.css">
</head>
<body>

	<div class="header">
		<div class="header-left"></div>
		<div class="header-center"></div>
		<div class="header-right"></div>
	</div>
	
	<div class="container">
		<div class="content-all-boards">
			<div class="board-title">個人看板</div>
			<?php foreach((array)$data as $i){ ?>
				<a href="trello.php?id=<?=$i['id']?>"><span class="board"><?=$i['title']?></span></a>
			<?php } ?>
			<span class="create_board">新建看板</span>
		</div>
	</div>
	
	<form method="POST">
		<div class="bg-box"></div>
		<div class="msg">
			<input type="text" name="title" class="new-board-title" placeholder="新增看板標題">
			<div class="new-board-cancle"><img src="img/cancle.svg" height="23" width="23"></img></div>
		</div>
		<div class="hidden-create-board">建立看板</div>
		<button type="submit" name="create" class="create-board">建立看板</button>
	</form>
	
	<script src="jquery/jquery.min.js"></script>
	<script src="jquery/jquery-ui.min.js"></script>
	<script src="js/boards.js"></script>
	
</body>

</html>