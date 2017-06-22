<?php
session_start();
include_once('includes.php');
if(!isset($_SESSION['role']) or $_SESSION['role']<1 or !isset($_SESSION['user']))
{
echo "Access denied. <a href=login.php>Login</a>.";
exit;
}
else
{
  $role = $_SESSION['role'];
}
$db = new Database();
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
<title>Schools</title>
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
          <td><h1 style="color:#FFFFFF">School View</h1></td>
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
    <form action="userview.php" method="POST">
        <table class="styledTable" style="text-align: center; width: 75%; margin: 10px; border: 1px solid black;">
          <tr>
            <td><h3 style="margin: 5px">Add a new School</h3></td>
            <td></td>
            <td></td>
            <td><input style="margin: 5px" value="Add School" type="submit" /></td>
          </tr>
          <tr>
            <td><a style="margin: 5px">School Name</a></td>
            <td><input style="margin: 5px" type="text" name="nameBox"></input></td>
            <td>Role</td>
            <td>
              <select>
              <option value="standard_account">Standard Account</option>
              <option value="coordinator_account">Centre Coordinator</option>
              <?php if($role>=2){echo '<option value="admin_account">Admin</option>';}?>
              </select>
              </td>
          </tr>
          <tr>
            <td><a style="margin: 5px">School Location</a></td>
            <td><input style="margin: 5px" type="text" name="emailBox"></input></td>
            <td><a style="margin: 5px">Password</a></td>
            <td><input style="margin: 5px" type="password" name="passwordBox"></input></td>
          </tr>
          <tr>
            <td>-</td>
            <td></td>
            <td><a style="margin: 5px">Confirm Password</a></td>
            <td><input style="margin: 5px" type="password" name="confirmPasswordBox"></input></td>
          </tr>
        </table>
    </form>
            <?php

$res = $db->sql("SELECT DSFCoord, clusterID, clusterName, location, locationID, schoolID, schoolName, schoolCategory, schoolHM, contactNo, totalStrength, schoolStaff, latitude, longitude, address from schoolmaster ORDER BY schoolCode DESC");

echo "<h1 style='margin: 10px'>Schools</h1>";


echo '<table class="styledTable" style="text-align: center; width: 75%; margin: 10px; border: 1px solid black;">
  <tr>
    <td><strong>Coordinator</strong></td>
    <td><strong>ClusterID</strong></td>
    <td><strong>ClusterName</strong></td>
    <td><strong>Location</strong></td>
    <td><strong>LocationID</strong></td>
    <td><strong>SchoolID</strong></td>
    <td><strong>Name</strong></td>
    <td><strong>Category</strong></td>
    <td><strong>Headmaster</strong></td>
    <td><strong>Contact Number</strong></td>
    <td><strong>Total Strength</strong></td>
    <td><strong>Staff</strong></td>
    <td><strong>Latitude</strong></td>
    <td><strong>Longitude</strong></td>
    <td><strong>Adress</strong></td>
  </tr>';


while ($zeile=$res->fetch_assoc())
{

echo "<tr><td>".$zeile['DSFCoord']."</td>
    <td>".$zeile['clusterID']."</td>
    <td>".$zeile['clusterName']."</td>
    <td>".$zeile['location']."</td>
    <td>".$zeile['locationID']."</td>
    <td>".$zeile['schoolID']."</td>
    <td>".$zeile['schoolName']."</td>
    <td>".$zeile['schoolCategory']."</td>
    <td>".$zeile['schoolHM']."</td>
    <td>".$zeile['contactNo']."</td>
    <td>".$zeile['totalStrength']."</td>
    <td>".$zeile['schoolStaff']."</td>
    <td>".$zeile['latitude']."</td>
    <td>".$zeile['longitude']."</td>
    <td>".$zeile['address']."</td>
    <td><input type=\"submit\" value=\"Edit\" /></td>
  </tr>";
}

?>
            
</body>
</html>