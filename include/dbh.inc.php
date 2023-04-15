<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// DESCRIPTION: creates database connection with MySQLi ext
//
// ISSUES: ERROR HANDLING - function die() is used to terminate db connection, however the error message can reveal important info to attackers, function must exit silently
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$serverName = "localhost"; // IP / Server address
$dBUserName = "root"; // Database username
$dBUserPassword = ""; // Database password
$dBName = "blog"; // Database name

$conn = mysqli_connect($serverName, $dBUserName, $dBUserPassword, $dBName);

//it make sure if an error occurs it show an error message
if(!$conn) {
	die("Connection failed:" . mysqli_connect());
}
?>
