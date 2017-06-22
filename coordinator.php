<?php
session_start();
include_once('includes.php');
if(!isset($_SESSION['role']) or $_SESSION['role']<1 or !isset($_SESSION['user']))
{
echo "Access denied. <a href=login.php>Login</a>.";
exit;
}
?>
<html>
<head>
<style type="text/css">
.standard A:link {color: black}
.standard A:visited {color: black}
.standard A:active {color: black}
.standard A:hover {color: black}
.styledTable tr:nth-child(even) {
    background-color: #d3d3d3;
}
</style>
<link href="design.css" type="text/css" rel="stylesheet">
<link rel="shortcut icon" href="images/favicon.ico" type="image/ico" />
<link rel="icon" href="images/favicon.ico" type="image/ico" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Coordinator Area</title>
</head>
<table>
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
          <td><h1 style="color:#FFFFFF">Coordinator Area</h1></td>
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
          </td>
        </tr>
      </table>
    </td>
    <td valign="top" bgcolor="#FFFFFF">
      <table border="0" cellpadding="10" cellspacing="0">
        <tr>
          <td>
            <?php
echo "<b>You have been assigned the role of a coordinator for one or more DSF-Centres. You can now...</b><br>";
echo "<br><a style=\"color: #0000EE\" href='schoolview.php'>Edit/View Schools</a> - <a style=\"color: #0000EE\" href='#'>Edit/View Timetables</a> - <a style=\"color: #0000EE\" href='userview.php'>Edit/View Users</a></p><br><br>";?>
            
</body>
</html>