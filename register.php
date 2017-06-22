<?php
include_once('includes.php');
$conn = GetDbConnection();

if (!isset($_POST["username"]) AND !isset($_POST["password"]) AND !ISSET($_POST["passwordwdh"]) AND !ISSET($_POST["email"]))
{
echo "<html>
<head>
<link rel='shortcut icon' href='images/favicon.ico' type='image/ico' />
<link rel='icon' href='images/favicon.ico' type='image/ico' />
<title>
Registrierung
</title>
<style type='text/css'>
table { align:center }
</style>
</head>
<body>
<div align='center'>
<h1>Registrierung</h1>
<form action='register.php' method='POST'>
<table>
<tr>
<td><label for='user'>Benutzername:</label><td></tr>
<tr><td><input type='text' name='username' id='username'  pattern='[A-Za-z0-9]{3,30}' title='Bitte geben Sie einen Namen ein, mit dem Sie sich anmelden werden.'  onkeyup='prüfebenutzer(this)' required></td>
<td><span style='border:0px;width:145px;font-size:10px;' id='output'></span>
</td>
</tr>
<tr><td><label for='password'>Passwort:</label></td></tr>
<tr><td><input type='password' name='password' id = 'password_1' pattern='[A-Za-z0-9]{6,30}' title='Sie können A-Z, a-z und 0-9 und müssen insgesamt mindestens 6 und höchstens 30 Zeichen verwenden'  required ></td></tr>
<tr>
<td><label for='password2'>Passwort wiederholen:</label></td></tr>
<tr><td><input type='password' name='passwordwdh' onblur='checkpassword(this)' required></td></tr>
<tr><td><label for='email1'>Email-Adresse:</label></td></tr>
<tr><td><input type='email' name='email' required></td></tr>
</table>
<p>
<input type='checkbox' name='AGB' value='agreed' title='Bitte lesen und akzeptieren Sie die AGB & Nutzungsbedingungen.' required> Ich akzeptiere die <a href='agb.html'>AGB und Nutzungsbedingungen</a>.
</p>
<input type='submit' onsubmit='return CheckInput();' name='Login' value='Registrieren' required><br>
<script>
function checkpassword(input) {
  if (input.value != document.getElementById('password_1').value) {
    input.setCustomValidity('Die zwei Passwörter müssen übereinstimmen.');
	
  } else {
    // input is valid -- reset the error message
    input.setCustomValidity('');
  }
}
</script>
<script type='text/javascript'>

  function prüfebenutzer(input){
   if (window.XMLHttpRequest){
    myAjax = new XMLHttpRequest();
   }else{
    //Dieser Code wird als Fallback f&uuml;r den IE5 und IE6 ben&ouml;tigt, da diese die obrige Schreibweise nicht unterst&uuml;tzen.
    myAjax = new ActiveXObject('Microsoft.XMLHTTP');
   }
 
   myAjax.onreadystatechange=function(){
    if (myAjax.readyState==4 && myAjax.status==200){
if (myajax.responseText == '0')
{
     document.getElementById('output').innerHTML='Verfügbar';
	 }
	 else 
	 {
	 document.getElementById('output').innerHTML='Benutzername nicht verfügbar.';
	 }
    }
   };
 
   myAjax.open('GET','datum.php?username='+username,true);
   myAjax.send();
  }

 </script>
<p>
Bereits registriert? <a href='login.php'>Login</a></p>
</body>
</html>";
}
else{
$username = CheckInput($_POST,"username", true);
$password = CheckInput($_POST,"password", true);
$password2 = CheckInput($_POST,"passwordwdh", true);
$email = CheckInput($_POST,"email", true);

if($username == "" OR $password == "" OR $password2 == "")
   {
   echo "Bitte f&uuml;lle alle Felder aus. <a href=\"register.php\">Zur&uuml;ck</a>";
echo "<html>
<title>
Registrierung fehlgeschlagen
</title>
</html>";
   exit;
   }
else
{
if($password != $password2)
   {
   echo "Die von dir eingegebenen Passw&ouml;rter stimmen nicht &uuml;berein. <a href=\"register.php\">Zur&uuml;ck</a>";
echo "<html>
<title>
Registrierung fehlgeschlagen
</title>
</html>";
   exit;
   }
}
if(preg_match('/^[a-zA-Z0-9]{6,}$/', $password))
{
$passwordokay=true;
}

if(!ISSET($passwordokay))
{
echo "Bitte dein Passwort den Vorgaben nach einrichten: Es sollte mindestens 6 Stellen haben und nur aus A-Z , a-z und 0, 9 bestehen.";
echo "<html>
<title>
Registrierung fehlgeschlagen
</title>
</html>";
exit;
}  

if(!preg_match('?^[\w\.-]+@[\w\.-]+\.[\w]{2,4}$?', trim($email)))
{
echo "Bitte geben Sie eine g&uuml;ltige Email-Adresse an. <a href=\"register.php\">Zur&uuml;ck</a>";
echo "<html>
<title>
Registrierung fehlgeschlagen
</title>
</html>";
exit;
}

$sql = mysql_query("SELECT username FROM user WHERE username LIKE '$username'");
$zeile = mysql_num_rows($sql);
if($zeile == 0)
   {
$sql = mysql_query("SELECT email FROM user WHERE email LIKE '$email'");
   $zeile = mysql_num_rows($sql);
   if($zeile == 0)
   {
   $status = "Hi! Ich spiele beim WM-Tippsiel mit.";
   mysql_query('BEGIN',$conn);
   $sql = "INSERT INTO user (username, password, email, confirmed, admin, date, status) VALUES ('$username', SHA1('$password'), '$email', '0', '0', NOW(), '$status')";
   mysql_query($sql, $conn) or die ('Fehler bei der Registrierung'.mysql_error());
   $id = mysql_insert_id($conn);
   $code = sha1(uniqid ( '', TRUE ));
   //Create a new PHPMailer instance
	include_once('class.phpmailer.php');
	$mail             = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth   = true;                  
	$mail->SMTPSecure = 'ssl';                 
	$mail->Host       = 'smtp.gmail.com';
	$mail->Port       = 465;
	$mail->Username   = 'wmspiel@kepiweb.de';
	$mail->Password   = 'hDk36yL"&j';
	$mail->From       = 'wmspiel@kepiweb.de';
	$mail->FromName   = "WM-Spiel Verwaltung";
	$mail->Subject = 'Verifizierungslink';
	$mail->AltBody    = "Vielen Dank, dass Sie sich bei unserem WM-Tippspiel registriert haben. Um ihr Konto freizuschalten, klicken Sie bitte auf den Link:<br/><a href='".urlPath()."/confirm.php?code=$code'>".urlPath()."/confirm.php?code=$code</a>";
	$mail->MsgHTML($mail->AltBody);

	$mail->AddAddress($email);
	//send the message, check for errors
	if (!$mail->send()) {
		echo "Mailer Error: " . $mail->ErrorInfo . "<br/>";
	} 
   $sql = "UPDATE user SET code = '$code' WHERE id = '$id'";
   mysql_query($sql,$conn) or die("Fehler: " . mysql_error());
   mysql_query('COMMIT',$conn);
   
   
   
echo "Benutzer <b>$username</b> wurde erstellt.<br> Sie erhalten eine E-Mail mit dem Link zur Best&auml;tigung ihres Accounts. <a href=\"login.php\">Login</a>";
echo "<html><title>Registrierung abgeschlossen</title></html>";
   }
   else
   {
   echo "Fehler bei der Registrierung. Diese Email-Adresse wird bereits verwendet!";
   }
   }
else
   {
   echo "Benutzer schon vorhanden. <a href=\"register.php\">Zur&uuml;ck</a>";
echo "<html><title></title></html>";
   }
   }
?>