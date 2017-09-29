<?php
if(!isset($_SESSION))
{
	session_start();
}
$_SESSION['logged_on_user'] = "";
unset($_SESSION['logged_on_user']);
$_SESSION['profile'] = "";
unset($_SESSION['profile']);
$_SESSION['total'] = "";
unset($_SESSION['total']);
header("Location: ../index.php");
?>

