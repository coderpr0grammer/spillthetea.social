<?php
echo "hi";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include($_SERVER["DOCUMENT_ROOT"] ."/functions.php");

if (isset($_POST["username"])) {
	$username = $_POST["username"];
	$query = "UPDATE `users` SET `verified` = 0 WHERE `username`='" . $username . "'";
// 	if (mysqli_query($link, $query)) {
// 		echo 1;
// 	} else {
// 		echo mysqli_error($link);
// 	}

}



?>