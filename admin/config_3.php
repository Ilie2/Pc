<?php
include 'config-1.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login-2.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login-2.php');
};
?>