<?php
session_start();
include_once('includes.php');
if (isset($_SESSION['user']))
{
echo "You are logged in! Go to <a href='index.php'>Member Area</a>.<br> Or <a href='index.php?logout=1'>log out</a>.";
exit;
}
?>
<?php
$conn = GetDbConnection();
if (ISSET($_POST['username']) AND ISSET($_POST['password']))
{
if ($_POST['username']!="" AND $_POST['password']!="")
{
	
	

 $username = CheckInput($_POST,'username',true);
 $password = CheckInput($_POST,'password',true);
$password = $_POST['password'];
$username = $_POST['username'];

 $password1 = hash('sha256', $password);


$sql = "select userID, role, confirmed, userName FROM user WHERE userName='$username' AND password='$password1'";




$ergebnis = mysql_query($sql, $conn) or die ('Fehler beim Login');
$zeile = mysql_fetch_array($ergebnis);
if ($zeile)
{
if($zeile[2] == 0)
{
$errorcode=3;
echo "<title>Login failed</title>";
}
else
{
$_SESSION['user'] = $zeile[0];
$_SESSION['role']=$zeile[1];
$_SESSION['username']=$zeile[3];
header('location: index.php');
}
}
else
{
$errorcode=1;
echo "<title>Login failed</title>";
}
}
else
{
$errorcode=2;
echo "<title>Error</title>";
}
}
else
{
echo "<title>Login - DSF Daily</title>";
}
?>
<html>
<head>
<style type="text/css">
.standard A:link {color: blue}
.standard A:visited {color: blue}
.standard A:active {color: blue}
.standard A:hover {color: blue}
</style>
<?php
$sql = "SELECT user.code FROM user WHERE userID = 1";
$ergebnis = mysql_query($sql, $conn) or die ('Error during Login! '.mysql_error().' <a href="index.php?logout=1">Logout</a>');
$zeile = mysql_fetch_array($ergebnis);
$news=DbToHTML($zeile[0]);
?>
<link href="design.css" type="text/css" rel="stylesheet">
<link rel="shortcut icon" href="images/favicon.ico" type="image/ico" />
<link rel="icon" href="images/favicon.ico" type="image/ico" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body bgcolor="#FFFFFF" link="#FFFF00" vlink="#FFCC00" alink="#FFFFFF" text="#000000">
<table border="3" cellpadding="0" cellspacing="0" width="100%" bgcolor="092F55">
  <colgroup>
    <col width="200">
    <col>
  </colgroup>
  <tr>
    <td colspan="2">
      <table border="0" cellpadding="10" cellspacing="0">
        <tr>
          <td><h1 style="color:#FFFFFF">Login - DSF Daily Reports</h1></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td valign="top" width="20">
      <table border="0" cellpadding="10" cellspacing="0">
        <tr>
          <td>
            <h3 style="color:#FFFFFF">News</h3>
            <p style="color:#FFFFFF"><?php echo $news; ?></p>
          </td>
        </tr>
      </table>
    </td>
    <td valign="top" bgcolor="#FFFFFF">
      <table border="0" cellpadding="10" cellspacing="0">
        <tr>
          <td>
<form action="login.php" method="POST">
<p>
<label>Username:</label><br>
<input type="text" name="username">
</p>
<p>
<label>Password:</label><br>
<input type="password" name="password">
</p>
<p>
</p><input type="submit" name="Login" value="Login">
<p></p></form>
<?php
if (ISSET($errorcode))
{
if ($errorcode==1):
echo "<font size='2'>Login failed! Wrong username or password. Are you having <a href='forgotpw.php'>issues while logging in</a>?<br></font>";
elseif($errorcode==2):
echo "<font size='2'>Error. Please login <a href='login.php'>again</a><br></font>";
elseif($errorcode==3):
echo "<font size='2'>Email not confirmed!<br></font>";
endif;
}
?>
<span class="standard"><font size="2">Please head over to <a href='register.php'>register</a> if you haven't yet done so! 
</font></span> 
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<hr></hr><center></center>
</body>
</html>