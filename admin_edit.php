<?php
session_start();
include_once('includes.php');
if($_SESSION['role']<2 or !isset($_SESSION['role']) or !isset($_SESSION['user']))
{
echo "Access denied. Go to <a href=login.php>login</a>.";
exit;
}
?>
<html>
<head>
<link rel="shortcut icon" href="images/favicon.ico" type="image/ico" />
<link rel="icon" href="images/favicon.ico" type="image/ico" />
<title>
Account-Settings
</title>
<script>
function checkpassword(input) {
  if (input.value != document.getElementById('newpassword').value) {
    input.setCustomValidity('The two passwords have to be identical.');
	
  } else {
    // input is valid -- reset the error message
    input.setCustomValidity('');
  }
}
</script>
</head>
<body>

<?php
//BEGIN CONFIG
$conn = GetDbConnection();
//END CONFIG
//USER CHECK
IF (ISSET($_GET['user']))
{
if (isset($_SESSION['role']) && $_SESSION['role']>=2)
{
$user = CheckInput($_GET,'user',false);
$_SESSION['user_edit']=$user;
}
}
else
{
if (ISSET($_SESSION['user_edit']))
{
$user=$_SESSION['user_edit'];
}
else
{
echo "Fehler";
exit;
}
}
//END USER CHECK

//GET DATA
$sql = "SELECT userName, email, password, confirmed, role FROM user WHERE userID='$user'";
$ergebnis = mysql_query($sql, $conn) or die ('Fehler beim Login'.mysql_error());
$zeile = mysql_fetch_array($ergebnis);
$username=$zeile[0];
$email1=$zeile[1];
$password=$zeile[2];
$confirmed=$zeile[3];
$role=$zeile[4];
//END DATA
IF ($role>=2) {
echo "No Acess to other admins settings. <br><a href='admin.php'>Admin Settings</a><br><a href='index.php'>Main Area</a>";
exit;
}
//EDIT Confirm
if (isset($_POST['confirm']) AND $_POST['confirm']=="on" AND $confirmed==0)
{
  $sql = "UPDATE user SET confirmed = '1' WHERE `user`.`userID` = '$user'";
  mysql_query($sql, $conn) or die ('Fehler beim Best&auml;tigen der Email-Adresse'.mysql_error());
  $confirm=1;
  $confirmed=1;
}
elseif(isset($_POST['confirm']) AND $_POST['confirm']=="off" AND $confirmed==1)
{
    $sql = "UPDATE user SET confirmed = '0' WHERE `user`.`userID` = '$user'";
	mysql_query($sql, $conn) or die ('Fehler beim Entst&auml;tigen der Email-Adresse'.mysql_error());
	$confirm=2;
	$confirmed=0;
}

//END EDIT Email

if (isset($_POST['admin']) && $_POST['admin']=="on" AND $admin==0)
{
  $sql = "UPDATE user SET admin = '1' WHERE `user`.`userID` = '$user'";
  mysql_query($sql, $conn) or die ('Fehler beim Best&auml;tigen des Adminstatus'.mysql_error());
}

echo "<center><h2>Settings</h2></center>";
 ?>
<div align="center" id="tabAccountOptions">
			<div align="center" class="content">
        <h3 class="header">Email-Confirm</h3>
            <form action="admin_edit.php" method="POST">
                <table>
                    <tbody><tr>
                        <td class="row_caption">Confirm email adress</td>
                        <td class="left">
						                                                        <input class="checkbox" type="checkbox" name="confirm" <?php if($confirmed==1) { echo 'checked="checked"'; } ?>>
                                                        </td>
														<td>
														<input class="button" type="submit" value='Best&auml;tigen'>
														</td>
                    </tr>
                </tbody></table><br>
									<?php
				
				if ($confirm==1):
				echo "Email confirmed.";
				elseif($confirm==2):
				echo "Email is not confirmed.";
				endif;
				?>
                </div>
            </form>
        </div>
		<div align="center" class="content">
        <h3 class="header">Make Admin</h3>
            <form action="admin_edit.php" method="POST">
                <table>
                    <tbody><tr>
                       <td class="row_caption">Give admin rights</td>
                        <td class="left">
						                                                        <input class="checkbox" type="checkbox" name="admin">
                                                        </td>
														<td>
														<input class="button" type="submit" value="Best&auml;tigen">
														</td>
                    </tr>
                </tbody></table><br>
                </div>
            </form>
        </div>
    </div>
	<?php echo "<br><center>Back to <a href='index.php'>Main Area</a></center>";
	echo "<center>Back to <a href='admin.php'>Admin Settings</a></center>";?>
</body>
</html>