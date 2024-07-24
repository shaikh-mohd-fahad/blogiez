<?php
$title="Profile";
$page="Profile";
if(session_id()==''){
	session_start();
}
if(isset($_COOKIE['id']) && isset($_COOKIE['username'])){
	$_SESSION['id']=$_COOKIE['id'];
	$_SESSION['username']=$_COOKIE['username'];
	$title=$_SESSION['username'];
}
include_once('conn.php');
if(!isset($_SESSION['username']) && (isset($_GET['username']) and $_GET['username']=="profile")){
echo"<script>location.href='$url/login';</script>";
}
//fetching the detail of the person whose profile, we are checking
$q10="select * from user where username=";
if(isset($_GET['username']) and $_GET['username']!="profile"){
	//other profile checking
	$username=mysqli_real_escape_string($con,$_GET['username']);
	$q10.="'$username'";
}else {
	if(isset($_GET['username']) and $_GET['username']=="profile"){
	//self profile checking
	$q10.="'{$_SESSION['username']}'";
	}
	else{
	//self profile checking
	$q10.="'{$_SESSION['username']}'";
	}
}
$run10=mysqli_query($con,$q10);
$row10=mysqli_fetch_array($run10);
//getting the id of that persone whose profile is opened
$profile_id=$row10['id'];
if(mysqli_num_rows($run10)==1){
?>
<!DOCTYPE HTML>
<html>
<head>
<title><?php echo$title; ?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link href="../image/logo/blogiez_logo.jpg" type="image" rel="icon">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!-- custom css -->
<link href="../css/custom.css" rel="stylesheet">
<!-- chosen css -->
</head>
<body style="background-color:white !important">
<div class="navbar navbar-dark bg-primary navbar-expand-md fixed-top"> <!-- navbar start -->
<div class="container" id="nav-container">
<?php 
if($page=="Home" || $page=="Post" || $page=="Following" || $page=="followlist" ){?>
<button class="navbar-toggler" id="opensidebar"><span class="navbar-toggler-icon"></span></button>
<?php
}?>
<a href="<?php echo$url; ?>/" class="navbar-brand"><b><i>Blogiez</i></b></a>
<button class="navbar-toggler" data-toggle="collapse" data-target="#nclp1"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="nclp1"><!-- navbar collpase start -->
<ul class="nav navbar-nav ml-auto">
<li class="nav-item"><a href="<?php echo$url; ?>/" class="nav-link <?php if(isset($page) && $page=='Home'){echo'active';} ?>"><i class="fa fa-home"></i>  Home</a></li>
<li class="nav-item"><a href="<?php echo$url; ?>/following" class="nav-link  <?php if(isset($page) && $page=='Following'){echo'active';} ?>"><i class="fas fa-blog"></i>  Following</a></li>
<li class="nav-item" id="show_profile_link">
<a href='<?php echo$url; ?>/user/<?php if(isset($_SESSION['username'])){echo$_SESSION['username'];}else{echo'profile';}?>' class='nav-link  <?php if(isset($page) && $page=='Profile'){echo'active';} ?>'><i class='fas fa-user'></i>  <?php if(isset($_SESSION['username'])){echo$_SESSION['username'];}else{echo'Profile';} ?></a>
</li>
<li class="nav-item"><a href="../app/Blogiez.apk" class="nav-link download_app" download><i class="fab fa-android"></i> Download Blogiez App</a></li>
<li class="nav-item"><a href="" class="nav-link <?php if(isset($page) && $page=='Trending'){echo'active';} ?>"><i class="fas fa-poll"></i> Trending</a></li>
<li class="nav-item">
<?php if(!isset($_SESSION['id'])){?>
<a href="<?php echo$url; ?>/login" class="nav-link <?php if(isset($page) && $page=='Login'){echo'active';} ?>"><i class='fas fa-sign-in-alt'></i> Log in</a>
<?php }
else{
	?>
<a href="<?php echo$url; ?>/logout" class="nav-link <?php if(isset($page) && $page=='Login'){echo'active';} ?>"><i class='fas fa-sign-in-alt'></i> Log out</a>
<?php } ?>
</li>
</ul>
</div><!-- navbar collapse close -->
</div>
</div><!-- navbar close -->
<div class="container-fluid"> <!-- container-fluid start -->
<div class="row" style="margin-top:65px"><!-- row to show cover and profile start -->
<div class="col-md-2"></div>
<div class="col-md-8" id="cover">
<img src="../image/cover_image/<?php echo$row10['user_cover']; ?>" class="shadow rounded" id="img2">
<?php
if(isset($_SESSION['id']) && $_SESSION['id']==$profile_id){
?>
<form method="post" enctype="multipart/form-data" id="user_cover_form1">
<label class="btn btn-primary" id="div1"><i class="fas fa-camera"></i> Select Cover
<input type="file" name="user_cover" id="user_cover" class="d-none">
</label>
</form>


<button class="d-none" type="button" data-target="#modal_user_cover" id="btn_user_cover" data-toggle="modal"></button>
<div class="modal" id="modal_user_cover"> <!-- modal to show upload user cover -->
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-body"><!-- modal body to show upload user cover -->
<div class="modal-header"><button class="d-none close" data-dismiss="modal" id="modal_remove_btn2">&times;</button>
</div>
<?php //If user upload new cover by clicking on update cover button on modal then this form will update database?>
<img src="" class="img-fluid mb-3" id="show_uploaded_user_cover">
<form method="post" enctype="multipart/form-data" id="user_cover_form2">
<input type="hidden" id="new_cover" name="new_cover" value="">
<input type="hidden" name="user_id" value="<?php echo$_SESSION['id']; ?>" id="user_id">
<?php //below old_cover is used to delete old cover from server when new cover is added on server
?>
<input type="hidden" id="old_cover" name="old_cover" value="<?php echo$row10['user_cover'] ?>">
<input type="submit" class="btn btn-primary" value="upload Cover" data-dismiss="" id="upload_cover_btn">
<!-- below button is used to delete just uploaded profile image from server -->
<input type="button" data-dismiss="" class="btn close" value="Cancel" id="cancel_upload_cover">
</form>
</div><!-- modal body to show upload user profile -->
</div>
</div>
</div><!-- modal to show upload user profile -->
<?php
}
?>
<div class="" id="div2"><!-- uploading user profile -->
<?php
if(isset($_SESSION['id']) && $_SESSION['id']==$profile_id){
?>
<style>
#user_profile_img_on_cover{
	cursor:pointer;
	border: 5px #fff solid !important;
}
</style>
<?php //this form only send profile image to server and show in modal/popup but not update it in users database until user submit it ?>
<form method="post" enctype="multipart/form-data" id="user_profile_form1">
<label class="" id="">
	<!-- image button to show and upload image  -->
	<input type="file" name="user_profile" id="user_profile" class="d-none">
	<img id="user_profile_img_on_cover" src="../image/profile_image/<?php echo$row10['user_profile'] ?>" class="rounded-circle user_profile_img">
</label>
</form>
<button class="d-none" type="button" data-target="#modal_user_profile" id="btn_user_profile" data-toggle="modal"></button>
<div class="modal" id="modal_user_profile"> <!-- modal to show upload user profile -->
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-body"><!-- modal body to show upload user profile -->
<div class="modal-header"><button class="d-none close" data-dismiss="modal" id="modal_remove_btn">&times;</button>
</div>
<?php //If user upload new profile by clicking on update profile button on modal then this form will update database?>
<img src="" class="img-fluid mb-3" id="show_uploaded_user_profile">
<form method="post" enctype="multipart/form-data" id="user_profile_form2">
<input type="hidden" id="new_profile" name="new_profile" value="">
<input type="hidden" name="user_id" value="<?php echo$_SESSION['id']; ?>" id="user_id2">
<?php //below old_profile is used to delete old profile from server when new profile is added on server
?>
<input type="hidden" id="old_profile" name="old_profile" value="<?php echo$row10['user_profile'] ?>">
<input type="submit" class="btn btn-primary" value="upload Profile" data-dismiss="" id="upload_profile_btn">
<!-- below button is used to delete just uploaded profile image from server -->
<input type="button" data-dismiss="" class="btn close" value="Cancel" id="cancel_upload_profile">
</form>
</div><!-- modal body to show upload user profile -->
</div>
</div>
</div><!-- modal to show upload user profile -->
<?php
}else{?>
	<img id="user_profile_img_on_cover" src="../image/profile_image/<?php echo$row10['user_profile'] ?>" class="border border-success rounded-circle user_profile_img">
<?php }
/*
<div class="text-center">
<input type="submit" name="user_profile_submit" id="user_profile_submit" value="Update Profile" class="btn btn-primary">
</div>
*/?>

</div><!-- uploading user profile -->
</div>
<div class="col-md-2"></div>
</div><!-- row end -->
<span id="error_msg1" class="text-danger ml-5"></span>
<div class="row my-4"><!-- main row start -->
<div class="col-md-2 col-lg-2"></div>
<div class="col-md-2 col-lg-2" id="user_detail"><!-- sidebar to show user detail col-2 start -->
<div class="shadow text-center rounded bg-white p-3 text-box">
<b><?php echo$row10['fullname']; ?></b><br>
<a href="<?php echo$url; ?>/follow_List?user_id=<?php echo$row10['id']; ?>&status=follower">
<?php
//query to get all followers
$q28="select * from follow where followed='{$row10['id']}'";
$run28=mysqli_query($con,$q28);
$row_num28=mysqli_num_rows($run28);
echo$row_num28;
?>
 Followers</a><br>
<a href="<?php echo$url; ?>/follow_List?user_id=<?php echo$row10['id']; ?>&status=following">
<?php
//query to get all following 
$q29="select * from follow where following='{$row10['id']}'";
$run29=mysqli_query($con,$q29);
$row_num29=mysqli_num_rows($run29);
echo$row_num29;
?>
 Following</a><br>
<!-- creating follow/unfollow button start -->
<?php
if(isset($_SESSION['id']) && isset($profile_id) && ($_SESSION['id']!=$profile_id)){?>
<span id="sp1">
<?php
	//checking whether user followed this blogger or not
	$q30="select * from follow where following='{$_SESSION['id']}' and followed='{$row10['id']}'";
	$run30=mysqli_query($con,$q30);
	if(mysqli_num_rows($run30)==1){
		echo"<button class='btn btn-mutted' onclick='unfollow()'>Unfollow</button>";
	}else{
		echo'<button onclick="follow()" class="btn btn-primary" id="follow_btn">Follow</button>';
	}
?>
</span>
<!-- creating follow/unfollow button end --><br>
<?php 
}
if(!isset($_SESSION['id']) && isset($profile_id)){
	echo'<button class="btn btn-primary" id="follow_btn" data-toggle="modal" data-target="#modal1">Follow</button></br>';
} ?>
<?php
if(isset($_SESSION['id']) and $_SESSION['id']==$profile_id){
	echo"<br><a href='".$url."/add_post' class='rounded h5 shadow my-4 px-2 py-2 btn_hover'><i class='fas fa-plus'></i> Add Post</a><br>";
	echo"<br><a href='#edit_profile_modal' data-dismiss='modal' class='btn_hover rounded h5 shadow my-4 px-2 py-2' data-toggle='modal'><i class='fas fa-user-edit'></i> Edit Profile</a>";
}
?>
</div>

<div class="modal" id="edit_profile_modal"><!-- modal to edit profile-->
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-body">
<button class="close" data-dismiss="modal" id="">&times;</button>
	<form id="form_edit_profile">
	<input type="hidden" name="user_id" value="<?php echo$row10['id'];?>">
	<input type="hidden" name="form_edit_profile_submit" value="submit">
	<div class="form-group">
		Username
		<span class="float-right" id="show_user_err"></span>
		<input type="text" id="username" name="username" placeholder="Enter Your Username" class="form-control" value="<?php echo$row10['username'];?>" required>
		<input type="hidden" id="old_username" value="<?php echo$row10['username'];?>">
	</div>
	<div class="form-group">
		Full Name
		<input type="text" name="fullname" placeholder="Name to Display" class="form-control" value="<?php echo$row10['fullname'];?>" required>
	</div>
	<div class="form-group">
		Describe Yourself:
		<input type="text" name="about" placeholder="Describe Yourself" class="form-control" value="<?php echo$row10['about'];?>">
	</div>
	<div class="form-group">
		Email:
		<input type="email" name="email" placeholder="Enter Your Email" class="form-control" value="<?php echo$row10['email'];?>" required>
	</div>
	<div class="form-group">
		Password:<span class="float-right text-danger" id="wrong_pass"></span>
		<input type="password" name="password" id="password" placeholder="Enter Your Password" class="form-control" value="<?php echo$row10['password'];?>" required>
		<label for="hide_and_show_pass" style="cursor:pointer"><input type="checkbox" id="hide_and_show_pass"> <small>Show Password</small></label>
	</div>
	<div class="form-group">
		Confirm Password:<span class="float-right text-danger" id="wrong_pass2"></span>
		<input type="password" name="" id="con_password" placeholder="Confirm Your Password" class="form-control" value="<?php echo$row10['password'];?>" required>
		<label for="hide_and_show_con_pass" style="cursor:pointer"><input type="checkbox" id="hide_and_show_con_pass"> <small>Show Confirm Password</small></label>
	</div>
	<div class="form-group">
		Birthday:
		<input type="date" name="birthday" class="form-control" value="<?php echo$row10['birthday'];?>" required>
	</div>
	<div class="form-group">
		<input type="submit" name="sub42" id="update"  class="btn btn-primary btn-block" value="Update Profile">
	</div>
	</form>
	<span id="show_error" class='d-block mb-2'></span>
</div>
</div>
</div>
</div><!-- modal to edit profile-->



<div class="modal" id="modal1"><!-- modal to show login start -->
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-body">
<button class="close" data-dismiss="modal">&times;</button>
<h3 class="">Please <a href="<?php echo$url; ?>/login"> Login</a> to continue </h3>
</div>
</div>
</div>
</div><!-- modal end -->
</div><!-- sidebar col-2 end -->
<div class="col-md-6 col-lg-6"><!-- showing user's all post col-6  start -->
<div class="row m-0"><!-- row inside col-6 start -->
<?php
//fetching the post of the person whose profile, we are checking
$q9="select * from post where user_id=";
if(isset($profile_id) and $profile_id!=$_SESSION['id']){
	$q9.="'$profile_id' and status='Publish' order by id desc";
}else{
	$q9.="'{$_SESSION['id']}' order by id desc";
}
$run9=mysqli_query($con,$q9);
if(mysqli_num_rows($run9)>0){	
	while($row9=mysqli_fetch_array($run9)){
?>
<div class="col-12 rounded shadow bg-white post_box" id="post_box<?php echo$row9['id']; ?>" value="<?php echo$row9['id']; ?>"><!-- col-12 inside col-6 start -->
<a href="<?php echo$url; ?>/<?php echo$row9['url_friendly_title']; ?>" class="m-0 p-0"><h3 class="m-0 p-0"><?php echo$row9['title']; ?></h3></a>
<small class="m-0 p-0"><img src="../image/profile_image/<?php echo$row10['user_profile'] ?>" height="30" width="30px" class="rounded-circle mr-2 user_profile_img"><b><?php echo$row10['fullname']; ?></b> <?php echo$row9['view']; ?> views
<p class="text-justify"><?php echo substr($row9['description'],0,245)."..."; ?></p></small>
<div class="float-left">
<span id="LikeBox<?php echo$row9['id'];?>"><!-- creating like button start -->
<?php
//counting like on the post
$q36="select * from blog_like where post_id={$row9['id']}";
$run36=mysqli_query($con,$q36);
$row_num36=mysqli_num_rows($run36);
if(isset($_SESSION['id'])){
//check kar raha hu ki user ne is post ko pahle se like kiya hai ya nhi
$q33="select * from blog_like where user_id='{$_SESSION['id']}' and post_id='{$row9['id']}'";
$run33=mysqli_query($con,$q33);
if(mysqli_num_rows($run33)==1){
	?>
<button class="btn btn-primary" onclick='unlike(<?php echo$row9['id'];?>)'> <span id="LikeCountBox<?php echo$row9['id'];?>"><?php 
echo $row_num36;?></span> Like</button>	
<?php
}else{?>
	<button class="btn" onclick="like(<?php echo$row9['id'];?>)"><span id="LikeCountBox<?php echo$row9['id'];?>"><?php echo $row_num36; ?></span> Like </button>
<?php
}
}else{
	echo"<button class='btn' id='follow_btn' data-toggle='modal' data-target='#modal1'><span id='LikeCountBox".$row9['id']."'> $row_num36</span> Like</button>";
}
?>
</span><!-- creating follow button end -->
<button class="btn border border-dark share_btn" value="<?php echo$row9['id']; ?>" id="" data-clipboard-text="<?php echo$url; ?>/<?php echo$row9['url_friendly_title'];?>">Share</button>
<span  id="share_msg<?php echo$row9['id']; ?>" class="text-success mt-2"></span>
</div>
<div class="float-right">
<a href="<?php echo$url; ?>/<?php echo$row9['url_friendly_title']; ?>" class="btn btn-success">View</a>
<?php 
if(isset($_SESSION['id']) && $_SESSION['id']==$profile_id){
?>
<button class="btn btn-danger" onclick="del('<?php echo$row9['id']; ?>')">Delete</button>
<a  href="../edit_post.php?id=<?php echo$row9['id']; ?>" class="btn btn-primary">Edit</a>
<?php
}
?>
</div>
<span clear="all"></span>
</div><!-- col-12 inside col-6 end -->
<?php
}
}else{
	if(isset($profile_id)){
		echo"<div class='alert alert-danger w-100'>{$row10['username']} have no post.</div>";
	}
	else{
		echo"<div class='alert alert-danger'>You Don't have any post please write your first post</div>";
	}
}
?>
</div><!-- row inside col-6 end -->
</div><!-- col-7 end -->
<div class="col-md-2 col-lg-2"></div>
</div><!-- main row close -->
</div><!-- container-fluid end -->
<?php
}else{
	echo"<h1 class='text-center mt-5 pt-5'>Sorry, this page isn't available.</h1>";
}
?>
<!-- footer start -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/5d2911aa89.js" crossorigin="anonymous"></script>
<script src="../js/clipboard.min.js"></script>

<script>
//logged in user id
var user_id="<?php if(isset($_SESSION['id'])){echo$_SESSION['id'];}?>";
//whose profile is open
var blogger_id="<?php if(isset($profile_id)){echo$profile_id;} else{echo$_SESSION['id'];}?>";
new ClipboardJS('.share_btn');
$(".share_btn").click(function(){
	id= $(this).val();
	$("#share_msg"+id).html("<br>Link Copied");
	setTimeout(function(){
		$("#share_msg"+id).html("");
	},1000);
});
function showprofile(){
	$("#show_profile_link").html("<a href='<?php echo$url; ?>/user/"+username+"' class='nav-link  <?php if(isset($page) && $page=='Profile'){echo'active';} ?>'><i class='fas fa-user'></i> "+username+"</a>");
}
</script>
<script src="../js/profile_js.js"></script>

</body>
</html>