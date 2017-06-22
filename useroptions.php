<?php
session_start();
include_once('includes.php');
if(!isset($_SESSION['user']))
{
header('location: login.php');
exit;
}
?>
<html>
<head>
<link rel="shortcut icon" href="images/favicon.ico" type="image/ico" />
<link rel="icon" href="images/favicon.ico" type="image/ico" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
Konto-Einstellungen
</title>
</head>
<body>
<script>
function checkpassword(input) {
  if (input.value != document.getElementById('newpassword').value) {
    input.setCustomValidity('Die zwei Passwörter müssen übereinstimmen');
	
  } else {
    // input is valid -- reset the error message
    input.setCustomValidity('');
  }
}
</script>
<?php
//BEGIN CONFIG
$user=$_SESSION['user'];
$conn = GetDbConnection();
//END CONFIG

//GET DATA
$sql = "SELECT username, email, password, status FROM user WHERE userID='$user'";
$ergebnis = mysql_query($sql, $conn) or die ('Fehler beim Login'.mysql_error());
$zeile = mysql_fetch_array($ergebnis);
$username=DbToHTML($zeile[0]);
$email1=DbToHTML($zeile[1]);
$password=$zeile[2];
$status=DbToHTML($zeile[3]);
//END DATA
//EDIT PASSWORD
if (isset($_POST['newpassword']) AND isset($_POST['oldpassword']))
{
if ($_POST['newpassword']!="" AND $_POST['oldpassword']!="")
{
if ($_POST['newpassword']!="empty" AND $_POST['oldpassword']!="empty")
{
 $newpassword = SHA1($_POST['newpassword']);
 $oldpassword = SHA1($_POST['oldpassword']);
if ($newpassword!=$password)
 {
 if ($oldpassword==$password)
  {
  $sql = "UPDATE user SET password = '$newpassword' WHERE user.userID = '$user'";
  mysql_query($sql, $conn) or die ('Fehler beim &Auml;ndern des Passworts'.mysql_error());
  $passwordchanged=1;
  $_POST['newpassword']="empty";
  $_POST['oldpassword']="empty";
  }
  else
  {
  $passwordchanged=0;
  }
  }
 else
 {
   $passwordchanged=2;
  }
  }
  }
}
//END EDIT PASSWORD

//EDIT Email
if (isset($_POST['email']) AND isset($_POST['emailpassword']))
{
if ($_POST['email']!="" AND $_POST['emailpassword']!="")
{
if ($_POST['email']!="empty" AND $_POST['emailpassword']!="empty")
{
 $email = CheckInput($_POST,'email',true);
 $emailpassword = SHA1($_POST['emailpassword']);
  if ($email!=$email1)
  {
  $sql = mysql_query("SELECT email FROM user WHERE email LIKE '$email'");
 $zeile = mysql_num_rows($sql);
 if($zeile == 0)
 {
  if ($emailpassword==$password)
  {
  $sql = "UPDATE user SET email = '$email' WHERE user.userID = '$user'";
  mysql_query($sql, $conn) or die ('Fehler beim &Auml;ndern der Email'.mysql_error());
  $emailchanged=1;
  $_POST['email']="empty";
  $_POST['emailpassword']="empty";
  $email1=$email;
  }
  else
  {
  $emailchanged=0;
  }
  }
 else
  {
$emailchanged=3;
  }
  }
  else
  {
  $emailchanged=2;
  }
  }
}
}
//END EDIT Email

//EDIT STATUS
if (isset($_POST['status']))
{
if ($_POST['status']!="")
{
if ($_POST['status']!="empty")
{
 $newstatus= CheckInput($_POST, 'status', true);
 if ($status!=$newstatus)
 {
  $sql = "UPDATE user SET status = '$newstatus' WHERE `user`.`userID` = '$user'";
  mysql_query($sql, $conn) or die ('Fehler beim &Auml;ndern der Email'.mysql_error());
  $statuschanged=1;
  $_POST['email']="empty";
  $_POST['emailpassword']="empty";
  $status=$newstatus;
  }
  else
  {
  $statuschanged=2;
  }
  }
  else
  {
  $statuschanged=0;
  }
  }
 else
  {
  $statuschanged=0;
  }
  }
//END STATUS
 ?>
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
          <td><h1 style="color:#FFFFFF">Kontoeinstellungen</h1></td>
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
            <p><a href="index.php">Hauptseite</a><br>
           <h3 style="color:#FFFFFF">Kontoverwaltung</h3>
		   <p><a href="user.php">Kontoübersicht</a><br>
          </td>
        </tr>
      </table>
    </td>
    <td valign="top" bgcolor="#FFFFFF">
      <table border="0" cellpadding="10" cellspacing="0">
        <tr>
          <td>
				<div align="center" id="tabAccountOptions">
        <div class="content">
		<form action="useroptions.php" method="POST">
                <div id="options_changePass">
                    <h3>Passwort &auml;ndern</h3>
                    <table class="table01">
                        <tbody><tr>
                            <td class="row_caption">Altes Passwort</td>
                            <td class="left">
							<input type="password" class="textfield" name="oldpassword" required></td>
                        </tr>
                        <tr>
                            <td class="row_caption">Neues Passwort</td>
                            <td class="left">
							<input type="password" id = "newpassword" pattern="[A-Za-z0-9]{6,30}" title="Sie k&ouml;nnen A-Z, a-z und 0-9 und m&uuml;ssen insgesamt mindestens 6 und h&ouml;chstens 30 Zeichen verwenden" class="textfield" name="newpassword" required></td>
                        </tr>
                        <tr>
                            <td class="row_caption">Neues Passwort wiederholen</td>
                            <td class="left">
							<input type="password" class="textfield" name="newPasswordConfirm" onblur="checkpassword(this)" required></td>
                        </tr>
                    </tbody></table>
                </div>
               <div class="centerButton">
                   <input type="submit" class="button" value="Einstellungen speichern">
               </div>
				<?php
				if (isset($passwordchanged))
				{
				if ($passwordchanged==1):
				echo "Dein Passwort wurde erfolgreich ge&auml;ndert.";
				elseif($passwordchanged==0):
				echo "Bitte &uuml;berpr&uuml;fe die Eingabe deines Passworts.";
				elseif($passwordchanged==2):
				echo "Das eingebene, neue Passwort ist bereits dein altes Passwort.";
				endif;
				}
				?>
            </form>
        </div>
    </div>
	<div align="center" class="content">
        <h3 class="header">E-Mail-Adresse &auml;ndern</h3>
            <form action="useroptions.php" method="POST">
                <table>
                    <tbody><tr>
                        <td class="row_caption">E-Mail-Adresse &auml;ndern</td>
                        <td class="left">
                                                        <input class="textfield" type="text" name="email" maxlength="100" required value="<?php echo $email1; ?>">
                                                        </td>
                    </tr>
                    <tr>
                        <td class="row_caption">Passwort eingeben</td>
                        <td class="left"><input type="password" class="textfield" name="emailpassword" required title="Geben Sie Ihr Passwort zur Best&auml;tigung ein."></td>
                    </tr>
                </tbody></table>
									<?php
				if (isset($emailchanged))
				{
				if ($emailchanged==1):
				echo "Deine Email-Adresse wurde erfolgreich ge&auml;ndert.";
				elseif($emailchanged==0):
				echo "Fehlercode 30: Bitte &uuml;berpr&uuml;fe die Eingabe deines Passworts.";
				elseif($emailchanged==2):
				echo "Fehlercode 32: Dies ist bereits deine Email-Adresse.";
				elseif($emailchanged==3):
				echo "Fehlercode 33: Es ist bereits ein anderer User mit dieser Email-Adresse registriert.";
				endif;
				}
				?>
                <div class="centerButton">
                    <input type="submit" class="button" value="E-Mail-Adresse &auml;ndern">
                </div>
            </form>
        </div>
		<div align="center" class="content">
        <h3 class="header">Status &auml;ndern</h3>
            <form action="useroptions.php" method="POST">
                <table>
                    <tbody><tr>
                        <td class="row_caption">Status &auml;ndern</td>
                        <td class="left">
                                                        <input class="textfield" type="text" name="status" maxlength="100" required value="<?php echo $status; ?>">
                                                        </td>
                    </tr>
					</tbody></table>
									<?php
				if (isset($statuschanged))
				{
				if($statuschanged=1):
                echo "Dein Status wurde erfolgreich ge&auml;ndert.";
				elseif($statuschanged=0):
				echo "<b>Fehler</b>";
				elseif($statuschanged=2):
				echo "<b>Das ist bereits dein Status</b>";
				endif;
				}
				?>
                <div class="centerButton">
                    <input type="submit" class="button" value="Status &auml;ndern">
                </div>
            </form>
        </div>
    </div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</body>
</html>