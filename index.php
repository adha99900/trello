<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/index.css">
</head>
<body>

	<div class="header">
		<a href="/trello" class="logo"><img src='img/logo.svg' height="50"></img></a>
		<a href="register.php"><button class="header-register">註冊</button></a>
		<a href="login.php"><button class="header-login">登入</button></a>
	</div>
	<div class="content">
		<h1>歡迎回到 Trello !</h1>
		<h1>登入 Trello !</h1>
		<div class="create-account">
			or <a href="register.php"><span class="create">建立帳號</span></a>
		</div>
		<form method='POST' action="login.php">
			<div class='login-password-container-email'>
				<div>電子郵件<span style="color:rgb(130,130,130);">(或使用者名稱)</span></div>
				<input type='text' name='user' placeholder="例如： threepwood@grogmail.com">
				<div>密碼</div>
				<input type='password' name='password' placeholder="例如：••••••••••••">
				<button type='submit' name='login' class='login'>登入</button>
			</div>
		</form>
	</div>
		
</body>
</html>