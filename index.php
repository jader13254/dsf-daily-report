<?php
session_start();
include_once('includes.php');
if(!isset($_SESSION['user']))
{
header('location: login.php');
exit;
}
//BEGIN CONFIG
$user=$_SESSION['user'];
$conn = GetDbConnection();
//END CONFIG

//LOGOUT CHECK 1
IF (ISSET($_GET['logout']))
{
session_destroy();
header('location: login.php');
exit;
}
//END LOGOUT CHECK 1
$db = new Database();

$news=$db->sql_one_value("SELECT user.code FROM user WHERE userID = 1")[0];

try
{
$zeile = $db->sql_first("SELECT userName, role FROM user WHERE userID='$user'");
$username=$zeile['userName'];
$role = $zeile['role'];
}
catch (Exception $e)
{
  die('Fehler beim Login! '.mysql_error().' <a href="index.php?logout=1">Logout</a>');
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
.read-more-state {
  display: none;
}

.read-more-target {
  opacity: 0;
  max-height: 0;
  font-size: 0;
  transition: .25s ease;
}

.read-more-state:checked ~ .read-more-wrap .read-more-target {
  opacity: 1;
  font-size: inherit;
  max-height: 999em;
}

.read-more-state ~ .read-more-trigger:before {
  content: 'Show more';
}

.read-more-state:checked ~ .read-more-trigger:before {
  content: 'Show less';
}

.read-more-trigger {
  cursor: pointer;
  display: inline-block;
  font-size: .9em;
  line-height: 2;
  border: 1px solid #ddd;
  border-radius: .25em
}
</style>
<link href="design.css" type="text/css" rel="stylesheet">
<link rel="shortcut icon" href="images/favicon.ico" type="image/ico" />
<link rel="icon" href="images/favicon.ico" type="image/ico" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Main Area</title>
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
          <td><h1 style="color:#FFFFFF">Daily Reports DSF</h1></td>
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
			<h4 style="color:#FFFFFF">Reports</h4>
			<a href="viewReport.php">View My Reports</a><br>
      <a href="createReport.php">Create a new Report</a>
      <?php if ($role < 1) {
echo '<h4 style="color:#FFFFFF">Overview</h4>
<a href="#">View Schools</a>';}
?>
                  <?php if ($role >= 1) {
echo '<h4 style="color:#FFFFFF">Center Coordinator</h4> <a href="coordinator.php">Coordinator Area</a>
<a href="schoolview.php">Edit/View Schools</a>
<a href="createTimetable.php">Edit/View Timetable</a>
<a href="userview.php">Edit/View Users</a>';}
?>
						<?php if ($role >= 2) {
echo '<h4 style="color:#FFFFFF">Admin</h4> <a href="admin.php">Admin Area</a>';}
?>      <h4 style="color:#FFFFFF">Account Settings</h4>
            <p><a href="user.php">My Account</a><br>
       <a href="index.php?logout=1">Logout</a><br>
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
            <h2>Welcome, <?php echo $username; ?>.</h2>
            <?php

// BEGIN SELECT
$res = $db->sql("SELECT class, date, subject, schoolCode, activityType, classType, module, assignedByID, serialNo from schooltt where userID = $user ORDER BY date ASC");
//END SELECT

$first = true;
while ($zeile= $res->fetch_assoc())
{
  $result = $db->sql("Select timeTableID from dailyreport where timeTableID = ".$zeile['serialNo']);
  if($result->num_rows!=0)
  {
    continue;
  }
  if($first)
{
  echo "You have upcoming tasks. Please create a report whenever you finished a task.<br><br>";
  echo '  <label for="post-2" class="read-more-trigger">Show/Hide Details</label><br><br>';
  $first=false;
}
$result = $db->sql_one_value("SELECT userName from user where userID = ".$zeile['assignedByID']);
$assignedByID = $result[0];

$result= $db->sql_one_value("SELECT schoolName from schoolMaster where schoolCode = ".$zeile['schoolCode']);
$schoolName = $result[0];

$warning = "";
if(strtotime($zeile['date'])-time()<-24*60*60)
{
$warning = '<strong><font style="margin-left: 5px" color="red">OVERDUE</font></strong>';
}
echo '  <input type="checkbox" class="read-more-state" id="post-2" />';
echo "<table class=\"styledTable read-more-wrap\" style=\"table-layout: fixed; width: 40%; border: 1px solid black\">";
//overview row
echo "<tr><td style='word-wrap: break-word'>
";
$class = $zeile['class'] == -1 ? "" : "Class ".$zeile['class'];
echo "
<strong>".$zeile['subject']."</strong> at <strong>$schoolName</strong></td><td><strong>".$class."</strong>";
echo "</td></tr>
<tr>
<td><strong>Date:</strong></td><td>".date("F j, Y",strtotime($zeile['date']))."</td>
</tr>";
echo "</td></tr>
<tr>
<td><strong>Time:</strong></td><td>".date("g:i a",strtotime($zeile['date']))."</td>
</tr>";

echo "<tr class='read-more-target'>
<td><strong>Activity:</strong></td><td> ".$zeile['activityType']."</td>
</tr>

<tr class='read-more-target'>
<td><strong>Class Type:</strong></td><td> ".$zeile['classType']."</td>
</tr>

<tr class='read-more-target'>
<td><strong>Module:</strong></td><td> ".$zeile['module']."</td>
</tr>

<tr class='read-more-target'>
<td><strong>Assigned By:</strong></td><td> $assignedByID</td>
</tr>

<tr>
<td>$warning</td><td><form method=\"POST\" action=\"createReport.php\"><input type='hidden' name='timeTableID' value='".$zeile['serialNo']."' /><input style='width: 80%; display: block;
margin: auto;' name=\"createDailyReport\" value=\"Create Report\" type=\"submit\"></input></form></td>
</tr>";
echo "</table><br>";
}
if($first)
{
    echo "No new tasks have been assigned to you.";
}

?>
</body>
</html>