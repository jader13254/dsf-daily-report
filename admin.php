<?php
session_start();
include_once('includes.php');
if(!isset($_SESSION['role']) or $_SESSION['role']<2 or !isset($_SESSION['user']))
{
echo "Access denied. <a href=login.php>Login</a>.";
exit;
}
?>
<html>
<head>
<link rel="shortcut icon" href="images/favicon.ico" type="image/ico" />
<link rel="icon" href="images/favicon.ico" type="image/ico" />
<link href='design.css' type='text/css' rel='stylesheet' />
<title>Admin Settings</title>
</head>
<body>
<table>
<tr>
<td>
<table>
<?php
echo "<h1>Admin Stuff</h1>";
echo "This does not yet feature much content,<br> because most of the tasks can be handled by center coordinators and any development settings are yet to be created.<br><br>";
echo "Quick links:<br><a href='login.php'>Login</a> - <a href='index.php'>Index</a> - <a href='forgotpw.php'>Reset Password</a> - <a href='register.php'>Register</a> - <a href='useroptions.php'>User options</a> - <a href='user.php'>User overview</a> - <a href='userview.php'>User List/Edit</a> - <a href='schoolview.php'>School List/Edit</a> - <a href='Coordinator.php'>Coordinator Page</a><br><br>";
?>
</body>
</html>