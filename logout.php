<?php session_start();
 unset($_SESSION['username']);
 unset($_SESSION['uid']);
 unset($_SESSION['billy']);
 unset($_SESSION['password']);
 session_destroy();
 header('Location: index1.php');
?>