<?php
session_start();
$username = "";
$errors = array(); 

$db = mysqli_connect('localhost', 'root', '', 'user');

if (isset($_POST['reg_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  $user_check_query = "SELECT * FROM users WHERE username='$username'";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { 
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }
  }

  if (count($errors) == 0) {
    $ps =  MD5($password_1);
  	$query = "INSERT INTO users (username, password, win, draw, loss) 
     VALUES ('$username','$ps', '0', '0', '0')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}

if (isset($_POST['login_user'])) {
   $username = mysqli_real_escape_string($db, $_POST['username']);
   $password = mysqli_real_escape_string($db, $_POST['password']);
 
   if (empty($username)) {
      array_push($errors, "Username is required");
   }
   if (empty($password)) {
      array_push($errors, "Password is required");
   }
 
   $password = md5($password);
   if (count($errors) == 0) {
      $query = "SELECT username, password FROM users WHERE username='$username' AND password='$password'";
      $results = mysqli_query($db, $query);
      if (mysqli_num_rows($results) > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
      }else {
         array_push($errors, "Wrong username/password combination");
      }
   }
 }

 if(isset($_POST['idq'])){
  $db = mysqli_connect('localhost', 'root', '', 'user');  
  $user = $_SESSION['username'];
  $q = "SELECT username FROM users WHERE username= '$user'";
  $res = mysqli_query($db, $q);
      
  if($_POST['idq'] == "1"){
    $q = "UPDATE users SET win = win +'1' WHERE username = '$user'";
    mysqli_query($db, $q);
  }
  else if($_POST['idq']== "-1"){
    $q = "UPDATE users SET loss = loss +'1' WHERE username = '$user'";
    mysqli_query($db, $q);
  }
  else if($_POST['idq']=="0"){
    $q = "UPDATE users SET draw = draw +'1' WHERE username = '$user'";
    mysqli_query($db, $q);
  }
  
  
 }

 ?>