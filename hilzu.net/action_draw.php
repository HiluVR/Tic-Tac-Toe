<? php
$db = mysqli_connect('localhost', 'root', '', 'user');
$username = $_SESSION['username'];
$query = "SELECT username, password FROM users WHERE username='$username'";
$results = mysqli_query($db, $query);    
$query = "UPDATE users SET draw = '1' + draw  WHERE username='$username'";
mysqli_query($db, $query);
?>