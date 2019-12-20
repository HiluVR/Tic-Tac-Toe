<?php 
  include 'server.php';
  session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
  
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css"  href="main.css" />
  <link href="https://fonts.googleapis.com/css?family=Lilita+One&display=swap" rel="stylesheet">
  <script type="text/javascript" src="ai.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <meta charset="utf-8" />
  <title>Tic Tac Toe</title>
</head>
<body>
<div class="header">
	<h2 align="center">Home Page</h2>
</div>
<div class="content">

  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <?php  if (isset($_SESSION['username'])) : ?>
    	<p align="center">Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
      <p align="center"> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
  <table align="center">
    <tr>
      <td class="cell" id="0"></td>
      <td class="cell" id="1"></td>
      <td class="cell" id="2"></td>
    </tr>
    <tr>
      <td class="cell" id="3"></td>
      <td class="cell" id="4"></td>
      <td class="cell" id="5"></td>
    </tr>
    <tr>
      <td class="cell" id="6"></td>
      <td class="cell" id="7"></td>
      <td class="cell" id="8"></td>
    </tr>
  </table>
<div align="center">
  <button onClick="es()">
    Easy
  </button>
  <button onClick="ms()">
    Middle
  </button> 
  <button onClick="hs()">
    Hard
  </button>
</div>

  <div class="end-game"align="center">
    <div class="text"></div>
  </div>
    <?php endif ?>
</div>
</body>
</html>
