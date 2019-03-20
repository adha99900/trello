<?php
	require_once("db.php");
	
	if(isset($_POST['register'])){
		$sql="INSERT INTO `users`(`name`,`password`,`email`) VALUES ('{$_POST['name']}','{$_POST['password']}','{$_POST['email']}')";
		$db->query($sql);
		echo "<script>alert('註冊成功!');location.href='./'</script>";
	}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/register.css">
</head>
<body>
	<div class="content">
		<div class='register-password-container-email'>
			<h2>建立 Trello 帳號</h2>
			<div class="create-account">
				or <a href="login.php"><span class="create">登入你的帳戶</span></a>
			</div>
			<form method="POST">
				<div>姓名</div>
				<input type='text' name='name' placeholder="例如： Calvin and Hobbes">
				<div>電子郵件</div>
				<input type='email' name='email' placeholder="例如： threepwood@grogmail.com">
				<div>密碼</div>
				<input type='password' name='password' placeholder="例如：••••••••••••">
				<div class="register-disabled">建立新帳號</div>
				<button type='submit' name='register' class='register' style="display:none;">建立新帳號</button>
			</form>
		</div>
	</div>
	
	<script src="jquery/jquery.min.js"></script>
	<script src="jquery/jquery-ui.min.js"></script>
	<script src="js/register.js"></script>	
</body>
</html>