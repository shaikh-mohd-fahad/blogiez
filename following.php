<?php
$title="Following";
$page="Following";
if(session_id()==''){
	session_start();
}
include_once('conn.php');
$follow_someone='';
if(!isset($_SESSION['id'])){
echo"<script>location.href='$url/login';</script>";
}
include_once('include/header.php');
include_once('include/navbar.php');
?>
<div class="container-fluid"><!-- main container of the page  start-->
<div id="leftside" class="bg-white p-3 d-md-block leftside"><!-- #leftside start -->
<?php
include_once('include/sidebarFollowing.php');
?>
</div><!-- #leftside end -->
<div class="rightside"><!-- #rightside start -->
<div class="container p-2 bg-white">
<div class="row"><!-- main row start -->
<?php
//fetching the id of person whom logged in user is following
$q26="select * from follow where following='{$_SESSION['id']}'";
$run26=mysqli_query($con,$q26);
if(mysqli_num_rows($run26)>0){
	$follow_someone='';
	//fetching the blog of the  of logged in user's following, with respect to time
	$q25="select * from post where  status='Publish' order by id desc";
	$run25=mysqli_query($con,$q25);
	if(mysqli_num_rows($run25)>0){
		while($row25=mysqli_fetch_array($run25)){
			//fetching the id of person whom logged in user is following
			$q51="select * from follow where following='{$_SESSION['id']}'";
			$run51=mysqli_query($con,$q51);
			while($row51=mysqli_fetch_array($run51)){
				if($row25['user_id']==$row51['followed']){
					//fetching the detail of the blogger who write this blog
					$q27="select * from user where id={$row25['user_id']}";
					$run27=mysqli_query($con,$q27);
					$row27=mysqli_fetch_array($run27);
		?>
		<div class="col-md-3 mb-2">
		<a href="<?php echo$url; ?>/<?php echo$row25['url_friendly_title']; ?>"><img src="image/thumbnail/<?php echo$row25['thumbnail']; ?>" class="img-fluid img1" id=""></a>
		</div>
		<div class="col-md-9">
		<a href="<?php echo$url; ?>/<?php echo$row25['url_friendly_title']; ?>" class="m-0 p-0"><h3 class="m-0 p-0 h3"><?php echo$row25['title']; ?></h3></a>
		<p class="m-0 p-0" style="font-size: 12px;line-height: 1.3;text-align:justify">
		<a href="<?php echo$url; ?>/user/<?php echo$row27['username'];?>" class="text-dark">
		<img src="image/profile_image/<?php echo$row27['user_profile']; ?>" height="30" width="30px" class="rounded-circle mr-2">
		<b><?php echo$row27['fullname']; ?></b> </a><?php echo$row25['view']." View"; ?><br>
		<?php if($row25['description']!=""){ echo substr($row25['description'],0,240);} ?>
		</p>
		</div>
		<?php
				}
			}
		}
	}
	else{
		echo"<div class='alert alert-danger w-100'>There is no Blog/Post</div>";
		}
}
else{
	$follow_someone='nobody';
	}
if($follow_someone=='nobody'){
	echo"<div class='mx-3 alert alert-danger w-100'>Please Follow Someone to see there post</div>";
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
<script src="js/custom.js"></script>
<script>
user_id="<?php if(isset($_SESSION['id'])){echo$_SESSION['id'];}; ?>";
//Making follow button dynamic
function follow(blogger_id){
	$.ajax({
		url:"server.php",
		type:"post",
		data:{follow_from_follow_list:'follow_from_follow_list',user_id:user_id,blogger_id:blogger_id},
		success:function(response6){
			$("#sp"+blogger_id).html(response6);
		}
	});
};
//Making unfollow button dynamic
function unfollow(blogger_id){
	$.ajax({
		url:"server.php",
		type:"post",
		data:{unfollow_from_follow_list:'unfollow_from_follow_list',user_id:user_id,blogger_id:blogger_id},
		success:function(response5){
			$("#sp"+blogger_id).html(response5);
		}
	});
};
</script>
</body>
</html>