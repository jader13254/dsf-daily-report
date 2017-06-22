<?php
class Database
{
	var $mysqli;
	public function __construct()
	{
		    $this->mysqli = new mysqli("127.0.0.1", "root", "", "test");
		    if ($this->mysqli->connect_errno) {
		    	  die('Unable to connect to database [' . $this->msqli->connect_error . ']');
    }
    $this->mysqli->set_charset('utf8');
	}

    public function sql($sql)
	{
		if(!$result = $this->mysqli->query($sql)){
    	die('There was an error running the query [' . $this->mysqli->error . ']');
    	}
    	return $result;
	}

	public function sql_e($sql)
	{
		if(!$result = $this->mysqli->query($sql)){
    		throw new Exception('There was an error running the query [' . $this->mysqli->error . ']');
    	}
    	return $result;
	}

	public function sql_first($sql)
	{
		if(!$result = $this->mysqli->query($sql)){
    	die('There was an error running the query [' . $this->mysqli->error . ']');
    	}
    	return $result->fetch_assoc();
	}

    public function sql_first_e($sql)
	{
		if(!$result = $this->mysqli->query($sql)){
    	throw new Exception('There was an error running the query [' . $this->mysqli->error . ']');
    	}
    	return $result->fetch_assoc();
	}

    public function sql_one_value($sql)
	{
		if(!$result = $this->mysqli->query($sql)){
    	die('There was an error running the query [' . $this->mysqli->error . ']');
    	}
    	return $result->fetch_row();
	}

	public function sql_one_value_e($sql)
	{
		if(!$result = $this->mysqli->query($sql)){
    	throw new Exception('There was an error running the query [' . $this->mysqli->error . ']');
    	}
    	return $result->fetch_row();
	}

	public function error()
	{
		if($this->mysqli->error == "")
		{
			return false;
		}
		return true;
	}

    public function getConnection()
	{
		return $this->mysqli;
	}
	// Usage Examples
            // # Initialize Database Usage
            // $db = new Database();


            // # Normal SQL Query + Associative Fetching
            // $result = $db->sql("Select * from user");
            // while($current=$result->fetch_assoc())
            // {
            //   echo $current['userName']."<br>";
            // }
            // $result->close();

            // # First Result Only
            // $result = $db->sql_first("Select * from user");
            // echo $result['userName']."<br>";
            // echo $result['userID']."<br>"
            // $result->close();

            // # Getting One Value Only
            // $result = $db->sql_one_value("Select userName from user where userID = 5");
            // echo $result[0];
            // $result->close();
}

function ValidateText($res)
{
	if (get_magic_quotes_gpc())
		$res = stripslashes($res);
	return mysql_real_escape_string($res);
}

function ValidateTexti($res,$db)
{
	if (get_magic_quotes_gpc())
		$res = stripslashes($res);
	return mysqli_real_escape_string($db->getConnection(),$res);
}

function GetDbConnection()
{
	$conn = mysql_connect('localhost', 'root', '') 
		or die("Fehler beim Verbinden mit der Datenbank");
	mysql_select_db('test', $conn) 
		or die ("Fehler beim Ausw&auml;hlen einer Datenbank");
	if (!function_exists('mysql_set_charset')) 
		mysql_query("set names 'utf8'",$conn);
	else
		mysql_set_charset('utf8',$conn);
	return $conn;
}

function CheckInput($method, $name, $istext)
{
 // $method = $_GET oder $_POST
 // $name = Name der Variablen
 // $istext = TRUE -> Texteingabe, muss evtl. escaped werden
 $res = $method[$name];
 if ($istext)
 {
	return ValidateText($res);
 }
 // in Zahl konvertieren
 return intval($res);
}

function DbToHTML($str, $replaceNewline = true)
{
	$str = htmlentities($str, ENT_COMPAT, 'UTF-8');
	if ($replaceNewline)
		$str = str_replace("\n","<br />",$str); 
	return $str;
}

function urlPath()
{
	$trace = debug_backtrace();
	$first_frame = $trace[count($trace)-1];
	$callerdir = dirname($first_frame['file']);
	$includedir = dirname(__FILE__);
	$rootLength = strlen($includedir);
	$subDir = substr($callerdir, $rootLength);
	$subdirDepth = substr_count($subDir,DIRECTORY_SEPARATOR); // Anzahl der Verzeichnisse, die der Aufrufer tiefer steht
	$pageURL = 'http';
	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") 
	{
		$pageURL .= "s";
	}
	$pageURL .= "://" . $_SERVER["SERVER_NAME"];
	if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80") 
	{
		$pageURL .= ":".$_SERVER["SERVER_PORT"];
	} 
	$pageURL .= $_SERVER["REQUEST_URI"];
	for ($i = 0; $i <= $subdirDepth; $i++)
	{
		$idx = strrpos($pageURL,'/');
		$pageURL = substr($pageURL, 0, $idx);
	}
	return $pageURL;
}

?>