<?php
	require_once('db.php');
	
	switch ($_GET["thing"]){
		//更新list-title
		case "edit_list_title":
			$sql="UPDATE `list` SET `title`='{$_GET['list_title']}' WHERE `id`='{$_GET['list_id']}'";
			$db->query($sql);
		//新增card
			break;
		case "add_new_card":
			$sql="INSERT INTO `card`(`list_id`,`name`) VALUES ('{$_GET['list_id']}','{$_GET['name']}')";
			$db->query($sql);
			$sql="SELECT `id` FROM `card` ORDER BY `id` DESC LIMIT 1";
			echo get_data($db->query($sql))[0]['id'];
		//新增list
			break;
		case "add_new_list":
			$sql="INSERT INTO `list`(`board_id`,`title`) VALUES ('{$_GET['board_id']}','{$_GET['title']}')";
			$db->query($sql);
			$sql="SELECT `id` FROM `list` ORDER BY `id` DESC LIMIT 1";
			echo get_data($db->query($sql))[0]['id'];
			break;
		case "description-save":
			$sql="UPDATE `card` SET `description`='{$_GET['description']}' WHERE `id`='{$_GET['id']}'";
			$db->query($sql);
			break;
		case "get_val":
			$sql="SELECT * FROM `card` WHERE `id`='{$_GET['id']}'";
			echo json_encode(get_data($db->query($sql))[0],JSON_UNESCAPED_UNICODE);
			break;
		case "list-card-name":
			$sql="UPDATE `card` SET`name`='{$_GET['name']}' WHERE `id`='{$_GET['id']}'";
			$db->query($sql);
			break;
		case "get-all-boards":
			$sql="SELECT * FROM `boards` WHERE 1";
			echo json_encode(get_data($db->query($sql)),JSON_UNESCAPED_UNICODE);
			break;
		case "insert-cart-comment":
			$sql="INSERT INTO `comment`(`user_id`,`card_id`,`text`) VALUES ('{$_GET['user_id']}','{$_GET['card_id']}','{$_GET['comment']}')";
			$db->query($sql);
			$sql="SELECT `users`.`name`,`comment`.`text` FROM `comment` INNER JOIN `users` ON `users`.`id`=`comment`.`user_id` ORDER BY `comment`.`id` DESC LIMIT 1";
			echo json_encode(get_data($db->query($sql))[0],JSON_UNESCAPED_UNICODE);
			break;
		case "get_cart_active":
			$sql="SELECT `users`.`name`,`comment`.`text` FROM `comment` INNER JOIN `users` ON `users`.`id`=`comment`.`user_id` WHERE `card_id` = '{$_GET['card_id']}'";
			echo json_encode(get_data($db->query($sql)),JSON_UNESCAPED_UNICODE);
			break;
		case "share":
			if($_GET['user']===$_SESSION['data']['name'] || $_GET['user']===$_SESSION['data']['email']){
				echo "不能跟自己共享";exit;
			}
			$sql="SELECT * FROM `users` WHERE `email` = '{$_GET['user']}' OR `name` = '{$_GET['user']}'";
			$result=$db->query($sql);
			if($result->num_rows==1){
				$sql="NSERT INTO `share`(`board_id`,`user_id`) VALUES ('{$_GET['board_id']}','{$_GET['user']}')";
				echo "共享成功";
			}else{
				echo "未找到該用戶";
			}
			break;
	}
	
