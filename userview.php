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
$msg = "";
if(isset($_POST["addUserSubmitted"])) {
    if(!isset($_POST['nameBox']) || !isset($_POST['roleSelect']) || !isset($_POST['emailBox']) || !isset($_POST['passwordBox']) || !isset($_POST['confirmPasswordBox']))
  {
    echo "Not all values set";
    exit;
  }
  //all Values
  $check = ValidateTexti($_POST['addUserSubmitted'],$db);
  $name = ValidateTexti($_POST['nameBox'],$db);
  $roleATTENTION = ValidateTexti($_POST['roleSelect'],$db);
  $email = ValidateTexti($_POST['emailBox'],$db);
  $password1 = ValidateTexti($_POST['passwordBox'],$db);
  $password2 = ValidateTexti($_POST['confirmPasswordBox'],$db);
  if(!preg_match('?^[\w\.-]+@[\w\.-]+\.[\w]{2,4}$?', trim($email)))
  {
    echo "<font color=\"red\">Please enter valid mail adress!</font>";
    exit;
  }
  if($password1!=$password2)
  {
    echo "<font color=\"red\">Passwords don't match.</font>";
    exit;
  }
  if(!preg_match('/^[a-zA-Z0-9]{6,}$/', $password1))
  {
    echo "<font color=\"red\">Please enter a password with 6 letters minimum and a-z, A-Z, 0-9 letters only.</font>";
    exit;
  }
  if($roleATTENTION == "admin_account")
  {
    $roleATTENTION = 2;
  }
  else if($roleATTENTION =="coordinator_account")
  {
    $roleATTENTION = 1;
  }
  else
  {
    $roleATTENTION = 0;
  }
  //check if role is too high
  if($roleATTENTION>$role)
  {
    echo "<font color=\"red\">you cant add a user with higher role than yourself</font>";
    exit;
  }
  //check if user exists
  if(mysqli_num_rows($db->sql("select username from user where username LIKE '$name'"))>0)
  {
      echo "<font color=\"red\">user already exists (name)</font>";
      exit;
  }
  //check if email exists
  if(mysqli_num_rows($db->sql("select email from user where email LIKE '$email'"))>0)
  {
      echo "<font color=\"red\">email already used</font>";
      exit;
  }
  $password1 =  hash('sha256', $password1);
  $sql = "INSERT into user (userName,email,confirmed,password,role) VALUES ('$name','$email',1,'$password1',$roleATTENTION)";
  $db->sql($sql);
  if(!$db->error())
  {
  $msg="<p style='margin: 5px'>Sucess! User \"".$name."\" added.</p>";
}
else
{
    $msg="<p style='margin: 5px'>Error! User \"".$name."\" not added.</p>";
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
          <td><h1 style="color:#FFFFFF">User View</h1></td>
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
    <?php echo $msg; ?>
    <form action="userview.php" method="POST">
        <table class="styledTable" style="text-align: center; width: 75%; margin: 10px; border: 1px solid black;">
          <tr>
            <td><h3 style="margin: 5px">Add a new User</h3></td>
            <td></td>
            <td></td>
            <td><input style="margin: 5px" name="addUserSubmitted" value="Add User" type="submit"/></td>
          </tr>
          <tr>
            <td><a style="margin: 5px">Username</a></td>
            <td><input style="margin: 5px" title='Insert a name to identify the person the account will be used by.' type="text" pattern="[A-Za-z0-9]{3,30}" name="nameBox" required></input></td>
            <td>Role</td>
            <td>
              <select name="roleSelect" required>
              <option name="roleSelect" value="standard_account">Standard Account</option>
              <option name="roleSelect" value="coordinator_account">Centre Coordinator</option>
              <?php if($role>=2){echo '<option name="roleSelect" value="admin_account">Admin</option>';}?>
              </select>
              </td>
          </tr>
          <tr>
            <td><a style="margin: 5px">Email</a></td>
            <td><input style="margin: 5px" title='Insert the mail adress of the person that will use the account.' type="text" name="emailBox" required></input></td>
            <td><a style="margin: 5px">Password</a></td>
            <td><input style="margin: 5px" type="password" pattern='[A-Za-z0-9]{6,30}' name="passwordBox" required></input></td>
          </tr>
          <tr>
            <td>-</td>
            <td></td>
            <td><a style="margin: 5px">Confirm Password</a></td>
            <td><input style="margin: 5px" type="password" pattern='[A-Za-z0-9]{6,30}' name="confirmPasswordBox" required></input></td>
          </tr>
        </table>
    </form>
            <?php


echo "<h1 style='margin: 10px'>Users</h1>";
?>

<table class="styledTable" style="text-align: center; width: 75%; margin: 10px; border: 1px solid black;">
  <tr>
    <td><strong>Name</strong></td>
    <td><strong>Email</strong></td>
    <td><strong>UserID</strong></td>
    <td><strong>Role</strong></td>
    <td><strong>Edit</strong></td>
  </tr>

<?php
$res = $db->sql("SELECT userName, email, role, userID from user WHERE role < ".$role."+1 ORDER BY userID DESC");

while ($zeile= $res->fetch_assoc())
{

echo "<tr>
    <td>".$zeile['userName']."</td>
    <td>".$zeile['email']."</td>
    <td>".$zeile['userID']."</td>
    <td>";
    if($zeile['role']==0)
    {
      echo "Staff";
    }
    else if($zeile['role']==1)
    {
        echo "Centre Coordinator";
    }
    else if($zeile['role']==2)
    {
        echo "Admin";
    }
    echo "</td>
    <td><input type=\"submit\" value=\"Edit\" /></td>
  </tr>";
}

?>
            
</body>
</html>
<!--
tr>
            <td>-</td>
            <td></td>
            <td><a style="margin: 5px">Confirm Password</a></td>
            <td><input style="margin: 5px" type="password" name="confirmPasswordBox"></input></td>
          </tr>-->