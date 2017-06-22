<html>
<head>
<link rel='shortcut icon' href='images/favicon.ico' type='image/ico' />
<link rel='icon' href='images/favicon.ico' type='image/ico' />
<title>Passwort/Benutzernamen vergessen</title>
</head>
<body>
<?php
include_once('includes.php');
function CreateRandomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 15; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
$conn = GetDbConnection();
if (ISSET($_POST['emailorun']))
{
	if ($_POST['emailorun']!="")
	{
		$emailorun = CheckInput($_POST,'emailorun',true);
		$sql = "select username, email, confirmed, id FROM user WHERE email='$emailorun' OR username='$emailorun'";
		$ergebnis = mysql_query($sql, $conn) or die ('Fehler beim Abrufen der Daten.'.mysql_error());
		$zeile = mysql_fetch_array($ergebnis);
		$name = $zeile[0];
		if ($zeile AND $zeile[2]!=0)
		{
			echo "Hallo, $zeile[0]. Wir haben dir eine Email mit einem neuen Passwort zugeschickt. Bitte &uuml;berpr&uuml;fe auch deinen Spam-Ordner.";
			$adress=$zeile[1];
			$passwordnew = CreateRandomPassword();
			echo '';
			$id=$zeile[3];
			echo "<br>";
			mysql_query($sql, $conn) or die ('Fehler bei der Registrierung.'.mysql_error());
			$id = mysql_insert_id($conn);
			$code = sha1(uniqid ( '', TRUE ));
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
			$mail->Subject = 'Neues Passwort';
			$mail->AltBody    = "Sie haben für ihr Konto bei WM-Spiel ein neues Passwort beantragt. Ihr neues Passwort ist $passwordnew. Der Punkt am Ende ist als Satzzeichen und nicht als Teil des Passworts zu werten. Viel Spaß beim weiterspielen.";
			$mail->MsgHTML($mail->AltBody);
			$mail->AddAddress($adress);
				if (!$mail->send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					
				}
			$sql = "UPDATE user SET password = 'sha1($passwordnew)' WHERE id = '$id'";
			mysql_query($sql, $conn) or die ('Fehler beim Senden der Email.'.mysql_error());
		}
		else
		{
			echo "Die von Ihnen eingegebene Email-Adresse ist mit keinem Account verkn&uuml;pft, oder wurde noch nicht best&auml;tigt.";
			exit;
		}
	}
	else
	{
		echo "Bitte geben Sie eine g&uuml;ltige Email-Adresse ein.";
		exit;
	}
}
elseif (ISSET($_POST['username']))
{
	if ($_POST['username']!="")
	{
		$email = CheckInput($_POST,'username',true);
	}
	else
	{
		echo "Bitte geben sie eine g&uuml;ltige Email-Adresse an.";
		exit;
	}
		$sql = "select username FROM user WHERE email='$email'";
		$ergebnis = mysql_query($sql, $conn) or die ('Fehler beim Abrufen der Daten.'.mysql_error());
		$zeile = mysql_fetch_array($ergebnis);
		if ($zeile)
		{
			echo "Hallo, dein Benutzername ist $zeile[0].";
			echo " <a href=\"login.php\">Zum Login</a>";
		}
		else
		{
			echo "Die von Ihnen eingegebene Email-Adresse ist unserem System unbekannt.";
			exit;
		}
}
else
{
	echo "<center><h1>Probleme bei der Anmeldung?</h1>Falls Sie Ihr Passwort und/oder Ihren Benutzername vergessen haben, k&ouml;nnen wir Ihnen helfen.<br><br><u>Passwort vergessen?</u><br>Bitte geben Sie hier Ihren Benutzername oder Ihre Email-Adresse ein.<form action='forgotpw.php' method='POST' ><label>Benutzername/Email-Adresse:</label><br><input type='text' name='emailorun'><input type='submit' name='submit_email'></form><br><br><u>Benutzername vergessen?</u><br>Bitte geben Sie hier Ihre Email-Adresse ein, um Ihren Benutzername angezeigt zu bekommen.<form action='forgotpw.php' method='POST'><label>Email-Adresse:</label><br><input type='email' name='username'><input type='submit' name='submit_username'></form><hr></center>";
}
?></body></html>