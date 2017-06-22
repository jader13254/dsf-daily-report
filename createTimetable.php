<?php
session_start();
include_once('includes.php');
if(!isset($_SESSION['user']))
{
  header('location: login.php');
  exit;
}
if($_SESSION['role']<1)
{
  header("Location: index.php");
}
$db = new Database();
$msg = "";

if(isset($_POST["timetableEntrySubmitted"])) {
  //all Values
  if(!isset($_POST['schoolSelect']) || !isset($_POST['classBox']) || !isset($_POST['moduleBox']) || !isset($_POST['activityTypeBox']) || !isset($_POST['classTypeBox']) || !isset($_POST['dateBox']) || !isset($_POST['subjectBox']) || !isset($_POST['userSelect']))
  {
    echo "Not all values set";
    exit;
  }
  $school = ValidateTexti($_POST['schoolSelect'],$db);
  $class = ValidateTexti($_POST['classBox'],$db) == "" ? -1 : ValidateTexti($_POST['classBox'],$db);
  $activityType = ValidateTexti($_POST['activityTypeBox'],$db);
  $module = ValidateTexti($_POST['moduleBox'],$db);
  $date = ValidateTexti($_POST['dateBox'],$db);
  $subject = ValidateTexti($_POST['subjectBox'],$db);
  $user = ValidateTexti($_POST['userSelect'],$db);
  $subject = ValidateTexti($_POST['subjectBox'],$db);
  $classType = ValidateTexti($_POST['classTypeBox'],$db);
  $res = $db->sql("select userID from user where userID LIKE $user");
  $lol = $res->fetch_assoc();
  if(!($user == $lol['userID']))
  {
    echo "<font color=\"red\">User selected was not found.</font>";
    exit;
  }
  if(!preg_match('/^[0-9]{0,2}$/', $class))
  {
    if($class!="-1")
    {
      echo "<font color=\"red\">Please enter a class value of 0-99.</font>";
      exit;
    }
  }
  if(!preg_match('/^[0-9]{0,5}$/', $user))
  {
    echo "<font color=\"red\">User ID invalid.</font>";
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
  //check if datetime format is correct
  $format = 'Y-m-d H:i';
  $date = str_replace("T"," ",$date);
  $dateNew = DateTime::createFromFormat($format, $date);
  if($dateNew == false)
  {
    echo $date;
    echo "<font color=\"red\">Time Format invalid.</font>";
    exit;
  }
  $assigned = $_SESSION['user'];
  $sql = "INSERT into schooltt (date,schoolCode,class,activityType,classType,subject,module,userID,assignedByID) VALUES ('$date','$school',$class,'$activityType','$classType','$subject','$module',$user,$assigned)";
  try
  {
   $db->sql_e($sql); 
   $msg="<p style='margin: 5px'>Sucess! Entry created.</p>";
 }
 catch (Exception $e)
 {
   $msg="<p style='margin: 5px'>Failure! Entry could not be created.</p>";
 }
}
if(isset($_POST["deleteButton"])) {
  //all Values
  if(!isset($_POST['serialNo']))
  {
    echo "Not all values set";
    exit;
  }
  $serialNo = ValidateTexti($_POST['serialNo'],$db);
  $sql = "Select assignedByID from schooltt where serialNo =".$serialNo;
  $result = $db->sql_one_value($sql);
  if(!$result)
  {
    $msg = "<h4 style='margin: 10px'>Failure! Entry was not found and could not be deleted. Most common cause: it was already deleted.</h4>";
  }
  else if($result[0]!=$_SESSION['user'])
  {
    echo "wrong user ID for deletion... you can't delete task of others";
    exit;
  }
  else
  {
  $sql = "DELETE FROM schooltt where serialNo =".$serialNo;
  try
  {
   $db->sql_e($sql); 
   $msg="<h4 style='margin: 10px'>Entry deleted.</h4>";
 }
 catch (Exception $e)
 {
   $msg="<h4 style='margin: 10px'>Failure! Entry could not be deleted.</h4>";
 }
}
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
    .red {
      background-color: #ff3232;
    }
    .green {
      background-color: #79c879;
    }
  </style>
  <link href="design.css" type="text/css" rel="stylesheet">
  <link rel="shortcut icon" href="images/favicon.ico" type="image/ico" />
  <link rel="icon" href="images/favicon.ico" type="image/ico" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Add a Timetable Entry</title>
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
            <td><h1 style="color:#FFFFFF">Adding a Timetable Entry</h1></td>
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
          }
          ?>
          <form action="createTimetable.php" method="POST">
            <table class="styledTable" style="text-align: center; width: 75%; margin: 10px; border: 1px solid black;">
              <tr>
                <td><h3 style="margin: 5px">Add Entry</h3></td>
                <td></td>
                <td></td>
                <td><input style="margin: 5px" name="timetableEntrySubmitted" value="Add Entry" type="submit"/></td>
              </tr>
              <tr>
                <td><a style="margin: 5px"><b>School</b></a></td>
                <td>
                  <select name="schoolSelect" required>
                    <?php
            //auto-populate school select field
                    $res = $db->sql("select schoolCode, schoolName from schoolmaster");
                    while($current = $res->fetch_assoc())
                    {
                      echo '<option name="schoolSelect" value="'.$current['schoolCode'].'">'.$current['schoolName'].'</option>';
                    }
                    ?>
                  </select></td>
                  <td><b>Date</b></td>
                  <td><input type="datetime-local" name="dateBox" value="" required></time>
                  </td>
                </tr>
                <tr>
                  <td><i>Class</i></td>
                  <td><input style="margin: 5px" type="text" name="classBox"></input>
                  </td>
                  <td><i>Subject</i></td>
                  <td><input style="margin: 5px" type="text" name="subjectBox" value=""></input>
                  </td>
                </tr>
                <tr>
                  <td><a style="margin: 5px"><i>Module</i></a></td>
                  <td><input style="margin: 5px" type="text" name="moduleBox" value=""></input></td>
                  <td><a style="margin: 5px"><i>Activity Type</i></a></td>
                  <td><input style="margin: 5px" type="text" name="activityTypeBox" value=""></input></td>
                </tr>
                <tr>
                  <td><b>User</b></td>
                  <td>
                    <select name="userSelect" required>
                      <?php
            //auto-populate user select field
                      $res = $db->sql("select userName, userID from user");
                      while($current = $res->fetch_assoc())
                      {
                        echo '<option name="userSelect" value="'.$current['userID'].'">'.$current['userName'].'</option>';
                      }
                      ?>
                    </select>
                  </td>
                  <td><a style="margin: 5px"><i>Class Type</i></a></td>
                  <td><input style="margin: 5px" type="text" name="classTypeBox"></input></td>
                </tr>
              </table>
            </form>

            <?php echo "<h2 style='margin: 10px'>My Timetable Entries </h2>

            <table style='text-align: center; width: 75%; margin: 10px; border: 1px solid black;''>
              <tr>
                <td><strong>Subject</strong></td>
                <td><strong>School</strong></td>
                <td><strong>Date</strong></td>
                <td><strong>Who</strong></td>
                <td><strong>Class</strong></td>
                <td><strong>Activity Type</strong></td>
                <td><strong>Class Type</strong></td>
                <td><strong>Module</strong></td>
                <td><strong>Assigned By</strong></td>
                <td><strong>Completed</strong></td>
                <td><strong>Delete</strong></td>
              </tr>";

              $results = $db->sql("SELECT subject,schoolCode,userID,class,activityType,classType,module,assignedByID,serialNo,date from schooltt where assignedByID = ".$_SESSION['user']);

              while ($zeile= $results->fetch_assoc())
              {
                $res = $db->sql_one_value("Select schoolName FROM schoolmaster where schoolCode = ".$zeile['schoolCode']);
                $schoolName = $res[0];
                $res = $db->sql_one_value("Select userName FROM user where userID = ".$zeile['userID']);
                $userName = $res[0];
                $res = $db->sql_one_value("Select userName FROM user where userID = ".$zeile['assignedByID']);
                $assignedName = $res[0];
                $res = $db->sql_one_value("Select timeTableID FROM dailyreport where timeTableID = ".$zeile['serialNo']);
                $timeTableID = $res[0];
                $completed = $timeTableID == $zeile['serialNo'] ? "YES" : "NO";
                $color = $timeTableID == $zeile['serialNo'] ? "green" : "red";
                $class = $zeile['class'] == -1 ? "NOT SET" : $zeile['class'];
                echo "<tr class='".$color."'>
                <td>".$zeile['subject']."</td>
                <td>".$schoolName."</td>
                <td>".$zeile['date']."</td>
                <td>".$userName."</td>
                <td>".$class."</td>
                <td>".$zeile['activityType']."</td>
                <td>".$zeile['classType']."</td>
                <td>".$zeile['module']."</td>
                <td>".$assignedName."</td>
                <td>".$completed."</td>
                <td><form action='createTimetable.php' method='POST'>
                <input type='hidden' name='serialNo' value='".$zeile['serialNo']."'></input>
                <input type=\"submit\" name=\"deleteButton\" value=\"Delete\" /></form></td>
              </tr>";
            }


            echo"

            <table style='text-align: center; width: 75%; margin: 10px; border: 1px solid black;''>
              <tr>
                <td><strong>Subject</strong></td>
                <td><strong>School</strong></td>
                <td><strong>Date</strong></td>
                <td><strong>Who</strong></td>
                <td><strong>Class</strong></td>
                <td><strong>Activity Type</strong></td>
                <td><strong>Class Type</strong></td>
                <td><strong>Module</strong></td>
                <td><strong>Assigned By</strong></td>
                <td><strong>Completed</strong></td>
                <td><strong>Delete</strong></td>
              </tr>
              ";

//TODO Only display results relevant to the logged in user (limit by cluster)
              $results = $db->sql("SELECT subject,schoolCode,userID,class,activityType,classType,module,assignedByID,serialNo,date from schooltt");

              while ($zeile= $results->fetch_assoc())
              {
                $res = $db->sql_one_value("Select schoolName FROM schoolmaster where schoolCode = ".$zeile['schoolCode']);
                $schoolName = $res[0];
                $res = $db->sql_one_value("Select userName FROM user where userID = ".$zeile['userID']);
                $userName = $res[0];
                $res = $db->sql_one_value("Select userName FROM user where userID = ".$zeile['assignedByID']);
                $assignedName = $res[0];
                $res = $db->sql_one_value("Select timeTableID FROM dailyreport where timeTableID = ".$zeile['serialNo']);
                $timeTableID = $res[0];
                $completed = $timeTableID == $zeile['serialNo'] ? "YES" : "NO";
                $color = $timeTableID == $zeile['serialNo'] ? "green" : "red";
                $class = $zeile['class'] == -1 ? "NOT SET" : $zeile['class'];
                echo "<tr class='".$color."'>
                <td>".$zeile['subject']."</td>
                <td>".$schoolName."</td>
                <td>".$zeile['date']."</td>
                <td>".$userName."</td>
                <td>".$class."</td>
                <td>".$zeile['activityType']."</td>
                <td>".$zeile['classType']."</td>
                <td>".$zeile['module']."</td>
                <td>".$assignedName."</td>
                <td>".$completed."</td><td>";
                if($zeile['assignedByID']==$_SESSION['user'])
                {
                  echo "<form action='createTimetable.php' method='POST'>
                  <input type='hidden' name='serialNo' value='".$zeile['serialNo']."'></input>
                  <input type=\"submit\" name=\"deleteButton\" value=\"Delete\" /></form>";
                }
                echo " </td></tr>";
              }
              echo "<h2 style='margin: 10px'>All Timetable Entries </h2>";
              ?>
            </body>
            </html>