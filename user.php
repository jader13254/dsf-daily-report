<?php
session_start();
include_once('includes.php');
if(!isset($_SESSION['user']))
{
header('location: login.php');
exit;
}
$db = new Database();
//BEGIN CONFIG
$user=$_SESSION['user'];
//END CONFIG
IF (ISSET($_GET['userid']) AND $_GET['userid']!="")
{

$check_userid=CheckInput($_GET,'userid',false);

$res = $db->sql("SELECT userName, email, role, status FROM user WHERE userID='$check_userid'");

$zeile = $res->fetch_array();
if ($zeile)
{
$user=CheckInput($_GET,'userid',false);
$username=$zeile[0];
$email=$zeile[1];
$role=$zeile[2];
$status=DbToHTML($zeile[3]);
$else=TRUE;
UNSET($_GET['userid']);
}
}
else
{
$ownview=true;
}
?>
<html>
<head>
<link rel="shortcut icon" href="images/favicon.ico" type="image/ico" />
<link rel="icon" href="images/favicon.ico" type="image/ico" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
<?php 
		  if(ISSET($else))
		  {
		  echo $username;
		  }
		  else
		  {
		  echo "Account Overview";
		  }
?>
</title>
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
          <td><h1 style="color:#FFFFFF"><?php 
		  if(ISSET($else))
		  {
		  echo $username;
		  }
		  else
		  {
		  echo "Account Overview";
		  }
		  ?></h1></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td valign="top" width="20">
      <table border="0" cellpadding="10" cellspacing="0">
        <tr>
          <td>
            <h3 style="color:#FFFFFF">Navigation</h3>
			<p><a href="index.php">Main Area</a><br>
		  <h4 style="color:#FFFFFF">My Account</h4>
			<a href="useroptions.php">Account Settings</a><br>
          </td>
        </tr>
      </table>
    </td>
    <td valign="top" bgcolor="#FFFFFF">
      <table border="0" cellpadding="10" cellspacing="0">
        <tr>
          <td>
<?php
if($ownview=true)
{
//GET DATA
$res = $db->sql("SELECT username, email, role, status FROM user WHERE userID='$user'");
$zeile = $res->fetch_array();
$username=$zeile[0];
$email=$zeile[1];
$role=$zeile[2];
}
if (!ISSET($else))
{
if ($role==2)
{
$type = "You are an <b>Administrator.</B>";
}
else if($role==1)
{
$type = "You are a <b>Centre Coordinator.</B>";
}
else
{
$type = "You are using a <B>standard account.</B>";
}
//END DATA
echo "<table><tr><td><b>Username:</B> $username</td><tr>";
echo "<br>";
echo "<tr><td><B>Email:</B> $email</td></tr>";
echo "<br>";
echo "<tr><td><B>Status:</B> $zeile[3]</td></tr>";
echo "<br>";
echo "<tr><td>$type</td></tr>";
echo "</table>";
}
else
{
if ($role==2)
{
$type = "This User ist an Administrator.";
}
else if($role==1)
{
$type = "This User ist an Centre Coordinator.";
}
else
{
$type = "This User is a standard user.";
}
echo "<h1>$username</h1>";
echo "Email-Adresse: $email";
echo "<br>";
echo $type;
echo "<br>";
echo "Nachricht an ";
echo "$username "; 
echo "<span style='color:black, font-size:10px'><a href='message_create.php?receiver=$user'>schreiben</a></span>.<br>";
echo "Status: $status";
}
?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<hr></hr><center></center>
</body>
</html>