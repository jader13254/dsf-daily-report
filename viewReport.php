<?php
session_start();
include_once('includes.php');
if(!isset($_SESSION['user']))
{
  header('location: login.php');
  exit;
}
//This page will have several functions
//for staff it will be viewing his/her own reports and deleting those
//for center coordinator it will be viewing his own reports, and viewing all reports and also filtering by school cluster and date. deleting reports only original creator shall do.
//for admin it will be viewing all reports that have ever been sent, deleting all reports also.
$db = new Database();
$msg = "";
if(isset($_POST["deleteButton"])) {
  //all Values
  if(!isset($_POST['reportID']))
  {
    echo "Not all values set";
    exit;
  }
  $reportID = ValidateTexti($_POST['reportID'],$db);
  $sql = "Select userID from dailyreport where reportID =".$reportID;
  $result = $db->sql_one_value($sql);
  if(!$result)
  {
    $msg = "<h4 style='margin: 10px'>Failure! Report was not found and could not be deleted. Most common cause: it was already deleted.</h4>";
  }
  else if($result[0]!=$_SESSION['user'])
  {
    $msg = "<h4 style='margin: 10px'>You can't delete reports of others!</h4>";
  }
  else
  {
  $sql = "DELETE FROM dailyreport where reportID =".$reportID;
  try
  {
   $db->sql_e($sql); 
   $msg="<h4 style='margin: 10px'>Report deleted.</h4>";
 }
 catch (Exception $e)
 {
   $msg="<h4 style='margin: 10px'>Failure! Report could not be deleted.</h4>";
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
  <title>View Reports</title>
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
            <td><h1 style="color:#FFFFFF">View Daily Reports</h1></td>
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
          function secondsToTime($seconds) {
                $dtF = new \DateTime('@0');
                $dtT = new \DateTime("@$seconds");
                $tempReturn = $dtF->diff($dtT)->format('%hh %imin');
                $tempExplode=explode(" ",$tempReturn);
                if($tempExplode[1]=="0min")
                {
                  return $tempExplode[0];
                }
                return $tempReturn;
              }




          echo "<h1 style='margin: 7px'>My Daily Reports </h1><input style='margin: 10px' onclick='window.location.href=\"viewReport.php?download=ownReport\"' type='button' value='Download Data for Excel'></input>

            <table class='styledTable' style='text-align: center; width: 75%; margin: 10px; border: 1px solid black;''>
              <tr>
                <td><strong>Subject</strong></td>
                <td><strong>School</strong></td>
                <td><strong>Date</strong></td>
                <td><strong>Strength</strong></td>
                <td><strong>Class</strong></td>
                <td><strong>Module</strong></td>
                <td><strong>Remarks</strong></td>
                <td><strong>Duration</strong></td>
                <td><strong>Started</strong></td>
                <td><strong>Delete</strong></td>
              </tr>";

              $results = $db->sql("SELECT subject,schoolCode,class,module,fromTime,toTime,remarks,date,strength,reportID from dailyreport where userID = ".$_SESSION['user']);
              
              while ($zeile= $results->fetch_assoc())
              {
                $res = $db->sql_one_value("Select schoolName FROM schoolmaster where schoolCode = ".$zeile['schoolCode']);
                $schoolName = $res[0];
                //calculate duration
                $diffInSeconds = abs(strtotime($zeile['fromTime']) - strtotime($zeile['toTime']));
                $duration = secondsToTime($diffInSeconds);

                //calculate started time
                $startedTime = explode(" ",$zeile['fromTime']);
                $startedTime = explode(":",$startedTime[1]);
                $startedTime = $startedTime[0].":".$startedTime[1];
                echo "<tr>
                <td>".$zeile['subject']."</td>
                <td>".$schoolName."</td>
                <td>".$zeile['date']."</td>
                <td>".$zeile['strength']."</td>
                <td>".$zeile['class']."</td>
                <td>".$zeile['module']."</td>
                <td>".$zeile['remarks']."</td>
                <td>".$duration."</td>
                <td>".$startedTime."</td>
                <td><form action='viewReport.php' method='POST'>
                <input type='hidden' name='reportID' value='".$zeile['reportID']."'></input>
                <input type=\"submit\" name=\"deleteButton\" value=\"Delete\" /></form></td>
              </tr>";
            }

            if($_SESSION['role']>0)
            {
              //view all reports and filter those
           echo "<table class='styledTable' style='text-align: center; width: 75%; margin: 10px; border: 1px solid black;''>
              <tr>
                <td><strong>User</strong></td>
                <td><strong>Subject</strong></td>
                <td><strong>School</strong></td>
                <td><strong>Date</strong></td>
                <td><strong>Strength</strong></td>
                <td><strong>Class</strong></td>
                <td><strong>Module</strong></td>
                <td><strong>Remarks</strong></td>
                <td><strong>Duration</strong></td>
                <td><strong>Started</strong></td>
                <td><strong>Delete</strong></td>
              </tr>";

              $results = $db->sql("SELECT subject,schoolCode,class,module,fromTime,toTime,remarks,userName,userID,date,strength,reportID from dailyreport");
              $count = 0;
              while ($zeile= $results->fetch_assoc())
              {
                $res = $db->sql_one_value("Select schoolName FROM schoolmaster where schoolCode = ".$zeile['schoolCode']);
                $schoolName = $res[0];
                //calculate duration
                $diffInSeconds = abs(strtotime($zeile['fromTime']) - strtotime($zeile['toTime']));
                $duration = secondsToTime($diffInSeconds);

                //calculate started time
                $startedTime = explode(" ",$zeile['fromTime']);
                $startedTime = explode(":",$startedTime[1]);
                $startedTime = $startedTime[0].":".$startedTime[1];
                echo "<tr>
                <td>".$zeile['userName']."</td>
                <td>".$zeile['subject']."</td>
                <td>".$schoolName."</td>
                <td>".$zeile['date']."</td>
                <td>".$zeile['strength']."</td>
                <td>".$zeile['class']."</td>
                <td>".$zeile['module']."</td>
                <td>".$zeile['remarks']."</td>
                <td>".$duration."</td>
                <td>".$startedTime."</td>";
                echo "<td>";
                if($zeile['userID']==$_SESSION['user'])
                {
                echo "<form action='viewReport.php' method='POST'>
                <input type='hidden' name='reportID' value='".$zeile['reportID']."'></input>
                <input type=\"submit\" name=\"deleteButton\" value=\"Delete\" /></form>";
              }
                echo "</td>
              </tr>";
              $count++;
            }
             echo "<h1 style='margin: 7px'>All Daily Reports</h1><p style='padding:5px'>(Count: ".$count.")</p><input style='margin: 10px' onclick='window.location.href=\"viewReport.php?download=allReports\"' type='button' value='Download Data for Excel'></input>";
          }
              ?>
            </body>
            </html>