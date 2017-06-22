<?php
session_start();
include_once('includes.php');
if(!isset($_SESSION['user']))
{
header('location: login.php');
exit;
}
$db = new Database();
$msg = "";
if(isset($_POST["reportSubmitted"])) {
  //all Values
  if(!isset($_POST['schoolSelect']) || !isset($_POST['classBox']) || !isset($_POST['strengthBox']) || !isset($_POST['moduleBox']) || !isset($_POST['fromTimeBox']) || !isset($_POST['toTimeBox']) || !isset($_POST['remarksBox']) || !isset($_POST['subjectBox']) || !isset($_POST['timeTableID']))
  {
    echo "Not all values set";
    exit;
  }
  $school = ValidateTexti($_POST['schoolSelect'],$db);
  $class = ValidateTexti($_POST['classBox'],$db);
  $strength = ValidateTexti($_POST['strengthBox'],$db);
  $module = ValidateTexti($_POST['moduleBox'],$db);
  $fromTime = ValidateTexti($_POST['fromTimeBox'],$db);
  $toTime = ValidateTexti($_POST['toTimeBox'],$db);
  $remarks = ValidateTexti($_POST['remarksBox'],$db);
  $subject = ValidateTexti($_POST['subjectBox'],$db);
  $timeTableID = ValidateTexti($_POST['timeTableID'],$db);
  $scratchMode = $timeTableID == "-1" ? true : false;
  if(!$scratchMode)
  {
  $res = $db->sql("Select userID from schooltt where serialNo = $timeTableID");
  $values = $res->fetch_assoc();
  if($_SESSION['user']!=$values['userID'])
  {
    echo "ID Mismatch. The currently active user is not allowed to give a report on the given timetable task.";
    exit;
  }
}
  if(!preg_match('/^[0-9]{0,2}$/', $class))
  {
    echo "<font color=\"red\">Please enter a class value of 0-99.</font>";
    exit;
  }
  if(!preg_match('/^[0-9]{0,4}$/', $strength))
  {
    echo "<font color=\"red\">Please enter a strength value of 0-9999.</font>";
    exit;
  }
  //check if school value is valid
  $res = $db->sql("select schoolCode from schoolmaster where schoolCode LIKE $school");
  $lol = $res->fetch_assoc();
 if(!($school == $lol['schoolCode']))
  {
  echo "<font color=\"red\">School selected was not found.</font>";
  exit;
  }
  //check if time values are valid;
  if(!(preg_match("/(2[0-3]|[01][0-9]):([0-5][0-9])/", $fromTime)) && !(preg_match("/(2[0-3]|[01][0-9]):([0-5][0-9]):([0-5][0-9])/", $fromTime)))
  {
  echo "<font color=\"red\">Invalid time format for from Time. Use standard 24h clock. (e.g. 15:00 or 15:00:00)</font>";
  }
  if(!(preg_match("/(2[0-3]|[01][0-9]):([0-5][0-9])/", $toTime)) && !(preg_match("/(2[0-3]|[01][0-9]):([0-5][0-9]):([0-5][0-9])/", $toTime)))
  {
  echo "<font color=\"red\">Invalid time format for to Time. Use standard 24h clock. (e.g. 15:00 or 15:00:00)</font>";
  }
  //get username and userid
  $userID = $_SESSION['user'];
  $res = $db->sql("select userName from user where userID = $userID");
  $userName = $res->fetch_assoc();
  $userName = $userName['userName'];
  //format fromtime and totime. 
  //take the date of the task and add it to the given fromTime and toTime to create dateTime format for SQL.
  $dateNow = date("Y-m-d ",time());
  if(preg_match("/(2[0-3]|[01][0-9]):([0-5][0-9]):([0-5][0-9])/", $fromTime))
  {
    $fromTime = $dateNow.$fromTime;
  }
  else
  {
    $fromTime = $dateNow.$fromTime.":00";
  }
  if(preg_match("/(2[0-3]|[01][0-9]):([0-5][0-9]):([0-5][0-9])/", $toTime))
  {
      $toTime = $dateNow.$toTime;
  }
  else
  {
    $toTime = $dateNow.$toTime.":00";
  }
  if(!$scratchMode)
  {
  $sql = "INSERT into dailyreport (timeTableID,schoolCode,date,class,strength,subject,module,userName,userID,fromTime,toTime,remarks) VALUES ($timeTableID,'$school',NOW(),$class,$strength,'$subject','$module','$userName','$userID','$fromTime','$toTime','$remarks')";
}
else
{
    $sql = "INSERT into dailyreport (schoolCode,date,class,strength,subject,module,userName,userID,fromTime,toTime,remarks) VALUES ('$school',NOW(),$class,$strength,'$subject','$module','$userName','$userID','$fromTime','$toTime','$remarks')";
}
  try
  {
    $db->sql_e($sql);
    $msg="<h4 style='margin: 10px'>Sucess! Report sent.</h4>";
  }
  catch (Exception $e)
  {
   $msg="<h4 style='margin: 10px'>Failure! Report could not be sent. The most likely cause is: you sent it already.</h4>";
 }
}
$scratch = false;
if(!isset($_POST['timeTableID']) && !isset($_POST["reportSubmitted"]))
{
    //special View: Create a new report from scratch
  $scratch = true;
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
<title>Create a Report</title>
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
          <td><h1 style="color:#FFFFFF">Create a Report</h1></td>
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
            <p><a href="index.php">Back to Main Area</a><br>
          </td>
        </tr>
      </table>
    </td>
    <td valign="top" bgcolor="#FFFFFF">
    <?php if($msg != "")
    {
      echo $msg; 
      exit;
    }
    if(!$scratch)
    {
    //get the data from the database, schooltt, serialNo
    $ttid = ValidateTexti($_POST['timeTableID'],$db);
    $res = $db->sql("Select subject,class,date,schoolCode,activityType,module,userID from schooltt where serialNo = $ttid");
    $values = $res->fetch_assoc();
    if($_SESSION['user']!=$values['userID'])
    {
      echo "ID Mismatch. The currently active user is not allowed to give a report on the given timetable task.";
      exit;
    }
  }
    ?>
    <form action="createReport.php" method="POST">
    <input type="hidden" name="timeTableID" value="<?php if(!$scratch){echo $_POST['timeTableID'];}else{echo "-1";} ?>" />
        <table class="styledTable" style="text-align: center; width: 75%; margin: 10px; border: 1px solid black;">
          <tr>
            <td><h3 style="margin: 5px">Create Report</h3></td>
            <td></td>
            <td></td>
            <td><input style="margin: 5px" name="reportSubmitted" value="Send Report" type="submit"/></td>
          </tr>
          <tr>
            <td><a style="margin: 5px">School</a></td>
            <td>
            <select name="schoolSelect" required>
            <?php
            //auto-populate school select field
            $res = $db->sql("select schoolCode, schoolName from schoolmaster");
            while($current = $res->fetch_assoc())
            {
              echo '<option name="schoolSelect" value="'.$current['schoolCode'].'"';
              if(!$scratch && $current['schoolCode']==$values['schoolCode'])
              {
                echo " selected";
              }
              echo '>'.$current['schoolName'].'</option>';
            }
            ?>
            </select></td>
            <td>Class</td>
            <td><input style="margin: 5px" type="text" name="classBox" value="<?php if(!$scratch && $values['class']!="-1"){echo $values['class'];}?>" required></input>
              </td>
          </tr>
          <tr>
          <td>Strength</td>
            <td><input style="margin: 5px" type="text" name="strengthBox" required></input>
              </td>
          <td>Subject</td>
            <td><input style="margin: 5px" type="text" name="subjectBox" value="<?php if(!$scratch){echo $values['subject'];}?>" required></input>
              </td>
          </tr>
          <tr>
            <td><a style="margin: 5px">Module</a></td>
            <td><input style="margin: 5px" type="text" name="moduleBox" value="<?php if(!$scratch){echo $values['module'];}?>"></input></td>
            <td><a style="margin: 5px">From Time</a></td>
            <td><input style="margin: 5px" type="time" name="fromTimeBox" value="<?php if(!$scratch){echo "".date("H:i:s",strtotime($values['date']));} ?>" required></input></td>
          </tr>
          <tr>
            <td>Remarks</td>
            <td><input style="margin: 5px" type="text" name="remarksBox"></input></td>
            <td><a style="margin: 5px">To Time</a></td>
            <td><input style="margin: 5px" type="time" name="toTimeBox" required></input></td>
          </tr>
        </table>
    </form>



</body>
</html>