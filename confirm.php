<?php
if(!isset($_GET['code']))
{
	header("Location: index.php");
	exit;
}
?>
<html>
<head>
<link rel="shortcut icon" href="images/favicon.ico" type="image/ico" />
<link rel="icon" href="images/favicon.ico" type="image/ico" />
<title>Kontobest&auml;tigung</title>
</head>
<body>
<table>
<?php
include_once('includes.php');
$conn = GetDbConnection();
if (isset($_GET['code']))
{
$code = CheckInput($_GET,'code',true);
$sql = "SELECT confirmed from user WHERE code = '$code'";
$ergebnis = mysql_query($sql, $conn) or die ("Fehler bei der Abfrage: ".mysql_error());
$zeile = mysql_fetch_row($ergebnis);
if ($zeile[0] == 0)
{
$sql = "UPDATE user SET confirmed = '1' WHERE code = '$code'";
mysql_query($sql, $conn) or die ("Fehler bei der Abfrage: ".mysql_error());
echo "Ihre Email-Adresse wurde best&auml;tigt. Zum <a href='login.php'>Login</a>";
}
else
{
echo "Ihre Email-Adresse wurde bereits best&auml;tigt.";
}
}
else
{
echo "Ihr Konto konnte nicht best&auml;tigt werden";
}
?>
</table>
</body>
</html>