<?php
$title="Blogiez";
$description="Start BLOGGING for FREE. Share your knowledge, experiences or the latest news all with friends, family and the world on Blogiez.";
$keywords="Blogging";
$page="Home";
?>
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
<meta name="google-site-verification" content="M7w2yFwrdL4mgrK8htQFA2KmLIHBC3FV8es0seb7H8A" />
<meta name="facebook-domain-verification" content="o9ovo8ablwko8e5izjj40xigcnbo7g" />
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
<link href="<?php if(isset($_GET['category'])){echo"../";}?>image/logo/blogiez_logo.jpg" type="image" rel="icon">
<!-- Bootstrap 4 -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!-- custom css -->
<link href="<?php if(isset($_GET['category'])){echo"../";}?>css/custom.css" rel="stylesheet">
<!-- chosen css -->
<link href="<?php if(isset($_GET['category'])){echo"../";}?>css/chosen.css" rel="stylesheet">
</head>
<body>
<?php
include_once("include/navbar.php");
?>
<div class="container-fluid"><!-- main container of the page  start-->
<div id="leftside" class="bg-white p-3 d-md-block leftside">
<?php
include_once('include/sidebarHome.php');
?>
</div>
<div class="rightside"><!-- #rightside start -->
<div class="container mb-3">
<div class="carousel slide" id="myslide" data-ride="carousel"><!-- carousel start -->
<ul class="carousel-indicators">
<li class="active" data-target="#myslide" data-slide-to="0"></li>
<li data-target="#myslide" data-slide-to="1"></li>
<li data-target="#myslide" data-slide-to="2"></li>
</ul>
<div class="carousel-inner"><!-- carousel-inner start -->
<div class="carousel-item active">
<img src="<?php if(isset($_GET['category'])){echo"../";}?>image/slider/slider1.jpg" class="d-md-block w-100">
</div>
<div class="carousel-item">
<img src="<?php if(isset($_GET['category'])){echo"../";}?>image/slider/slider2.jpg" class="d-md-block w-100">
</div>
<div class="carousel-item">
<img src="<?php if(isset($_GET['category'])){echo"../";}?>image/slider/slider3.jpg" class="d-md-block w-100">
</div>
</div><!-- carousel-inner end -->
<a href="#myslide" class="carousel-control-prev" role="button" data-slide="prev">
<span class="carousel-control-prev-icon"></span>
</a> 
<a href="#myslide" class="carousel-control-next" role="button" data-slide="next">
<span class="carousel-control-next-icon"></span>
</a>
</div><!-- carousel end -->
</div>
<div class="container p-2 bg-white">
<div class="row"><!-- main row start -->
<?php
//getting all blog
if(isset($_POST['sub47'])){
	$search=mysqli_real_escape_string($con,$_POST['search']);
	$search=htmlentities($search);
	$q7="select * from post where status='Publish' and title like '%$search%' order by rand()";
}else if(isset($_GET['category'])){
	$category_id=mysqli_real_escape_string($con,$_GET['category']);
	$category_id=htmlentities($category_id);
	$q7="select * from post where status='Publish' and category_id like '%$category_id%' order by rand()";
}else{
	$q7="select * from post where status='Publish' order by rand()";
}
$run7=mysqli_query($con,$q7);
if(mysqli_num_rows($run7)>0){
while($row7=mysqli_fetch_array($run7)){
//fetching the detail of the blogger who write this blog
$q8="select * from user where id={$row7['user_id']}";
$run8=mysqli_query($con,$q8);
$row8=mysqli_fetch_array($run8);
?>
<div class="col-md-3 mb-2">
<a href="<?php echo$url; ?>/<?php echo$row7['url_friendly_title']; ?>">
<img src="<?php if(isset($_GET['category'])){echo"../";}?>image/thumbnail/<?php echo$row7['thumbnail']; ?>" class="img-fluid img1" id=""></a>
</div>
<div class="col-md-9 mb-2">
<a href="<?php echo$url; ?>/<?php echo$row7['url_friendly_title']; ?>" class="m-0 p-0"><h3 class="m-0 p-0 h3"><?php echo$row7['title']; ?></h3></a>
<p class="m-0 p-0" style="font-size: 12px;line-height: 1.3;text-align:justify">
<a href="<?php echo$url; ?>/user/<?php echo$row8['username'];?>" class="text-dark">
<img src="<?php if(isset($_GET['category'])){echo"../";}?>image/profile_image/<?php echo$row8['user_profile']; ?>" height="30" width="30px" class="rounded-circle mr-2">
<b><?php echo$row8['fullname']; ?></b> </a><?php echo$row7['view']." View"; ?><br>
<?php if($row7['description']!=""){ echo substr($row7['description'],0,240);} ?>
</p>
</div>
<?php
}//while loop end
}else{
	echo"<div class='alert alert-danger w-100 m-3'>There are no Blog/Post</div>";
}
?>
</div><!-- main row close -->
</div>
</div><!-- #rightside end -->
</div><!-- main container of the page  end-->
<!-- footer start -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/5d2911aa89.js" crossorigin="anonymous"></script>
<script src="<?php if(isset($_GET['category'])){echo"../";}?>js/custom.js"></script>
</body>
</html>