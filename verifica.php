<?php
session_start();
if(!isset($_SESSION["slogin"]) or !isset($_SESSION["ssenha"]))
{
    session_destroy();
	unset($_SESSION['slogin']);
	unset($_SESSION['ssenha']);
	echo "<script> document.location.href='login.html';</script>";
	exit;
}
?>