<?php
include_once("conn.php");
$id=$_COOKIE['id'];
$username=$_COOKIE['username'];
session_start();
setCookie("id",$id,time()-60*60*24*365);
setCookie("username",$username,time()-60*60*24*365);
session_destroy();
echo"<script> location.href='$url';</script>";
?>