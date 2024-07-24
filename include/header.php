<?php
if(session_id()==''){
	session_start();
}
if(isset($_COOKIE['id']) && isset($_COOKIE['username'])){
	$_SESSION['id']=$_COOKIE['id'];
	$_SESSION['username']=$_COOKIE['username'];
}
include_once("conn.php");
//counting visitor
if(!isset($_COOKIE['visiter'])){
setCookie('visiter','yes',time()+60*60*24*365);
mysqli_query($con,"update `visitor_counter` set count=count+1");
}
?>
<!doctype html>
<html>
<head>
<title><?php echo$title; ?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,intial-scale=1.0">
<?php if(isset($description) and !empty($description)){ ?>
<meta name="description" content="<?php echo$description; ?>">
<?php } ?>
<?php if(isset($keywords) and !empty($keywords)){ ?>
<meta name="keywords" content="<?php echo$keywords; ?>">
<?php } ?>
<?php if(isset($author) and !empty($author)){ ?>
<meta name="author" content="<?php echo$author; ?>">
<?php } ?>
<link href="image/logo/blogiez_logo.jpg" type="image" rel="icon">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!-- custom css -->
<link href="css/custom.css" rel="stylesheet">
<!-- chosen css -->
<link href="css/chosen.css" rel="stylesheet">
</head>
<body>