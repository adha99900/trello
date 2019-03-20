<?php
	require_once("db.php");
	
	if(isset($_POST['login'])){
		$sql="SELECT * FROM `users` WHERE `email`='{$_POST['user']}' OR `name`='{$_POST['user']}' AND `password`='{$_POST['password']}'";
		$result=$db->query($sql);
		if($result->num_rows==1){
			$_SESSION['data']=get_data($result)[0];
			header("location:boards.php");
		}else{
			echo "<script>alert('帳號或密碼錯誤');window.history.back();</script>";
		}
	}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/login.css">
</head>
<body>
	<div class="content">
		<div class='login-password-container-email'>
			<h2>登入 Trello</h2>
			<div class="create-account">
				or <a href="register.php"><span class="create">建立帳號</span></a>
			</div>
			<form method="POST">
				<div>電子郵件<span style="color:rgb(130,130,130);">(或使用者名稱)</span></div>
				<input type='text' name='user' placeholder="例如： threepwood@grogmail.com">
				<div>密碼</div>
				<input type='password' name='password' placeholder="例如：••••••••••••">
				<button type='submit' name='login' class='login'>登入</button>
			</form>
		</div>
	</div>
</body>
</html>