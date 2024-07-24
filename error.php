<?php
$page="Error";
?>
<!doctype html>
<html>
<head>
<title>Error</title>
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
<style>
body{
	overflow-x:hidden;
	background:#f5f5fb;
}
</style>
</head>
<body>
<?php 
include_once('include/navbar.php');
?>
<h3 class="text-center mt-5 pt-5">Sorry, The page you are searching is not found. Please visit <a href="<?php echo$url; ?>">Home</a></h3>
<?php
include_once('include/footer.php');
?>