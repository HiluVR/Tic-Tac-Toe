<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Reg Tic</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Muli&display=swap" rel="stylesheet">
<body>
  <div class="header">
  	<h2>Login</h2>
  </div>
	 
  <form method="post" action="login.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username" id="log" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
  	<p class="sing">
  		Not yet a member? <a href="register.php" class="sin">Sign up</a>
  	</p>
  </form>
</body>
</html>