<?php
$title="follow List | Blogiez";
$page="followlist";
include_once('include/header.php');
include_once('include/navbar.php');
?>
<style>
.img-fluid{
	max-height:60px;
	width:60px;
	height:60px;
}
</style>
<div class="container-fluid"><!-- main container of the page  start-->
<div id="leftside" class="bg-white p-3 d-md-block leftside">
<?php
include_once('include/sidebarFollowing.php');
?>
</div>
<div class="rightside"><!-- #rightside start -->
<div class="container p-2 bg-white">
<div class="row p-2"><!-- main row start -->
<div class="col-md-12">
<ul class="">
<?php
//us user ki follower/following ki data nikal rahe hai jiski link par hamne click kiya hai
$user_id=mysqli_real_escape_string($con,$_GET['user_id']);
$q39="select * from user where id='$user_id'";
$run39=mysqli_query($con,$q39);
$row39=mysqli_fetch_array($run39);
if($_GET['status']=='follower'){
	echo"<h4 class='ml-3 text-primary'>".$row39['fullname']." is Followed by -- </h4>";
}else{
	echo"<h4 class='ml-3 text-primary'>".$row39['fullname']." is Following -- </h4>";
}
?>
<?php
if(isset($_GET['user_id']) and isset($_GET['status'])){
	$user_id=mysqli_real_escape_string($con,$_GET['user_id']);
	//fetching the detail of the follower or following of that person whose profile we are checking
	//it fetch follower's id
	if($_GET['status']=='follower'){
		$q37="select * from follow where followed='$user_id'";
	}else if($_GET['status']=='following'){
		//it fetch following's id
		$q37="select * from follow where following='$user_id'";
	}
	$run37=mysqli_query($con,$q37);
	if(mysqli_num_rows($run37)>0){
		while($row37=mysqli_fetch_array($run37)){
			//fetching detail of follower and following using their id
			if($_GET['status']=='follower'){
				$q38="select * from user where id='{$row37['following']}'";
			}else{
				$q38="select * from user where id='{$row37['followed']}'";
			}
			$run38=mysqli_query($con,$q38);
			if($run38){
				$row38=mysqli_fetch_array($run38);
				?>
				<li class="media mb-2">
				
				<a href="<?php echo$url; ?>/user/<?php echo$row38['username']; ?>"><img src="image/profile_image/<?php echo$row38['user_profile']; ?>" class="rounded-circle img-fluid mr-3 align-self-center"></a>
				<div class="media-body mt-1">
				<a href="<?php echo$url; ?>/user/<?php echo$row38['username']; ?>"><strong><?php  echo$row38['fullname'];?></strong></a>
				<span class="float-right mr-3"  id="spa<?php echo$row38['id'] ?>">
				<?php
				// creating follow/unfollow button
				if(isset($_SESSION['id'])){
					//checking  whether Logged in user followed this blogger or not
					$q40="select * from follow where following='{$_SESSION['id']}' and followed='{$row38['id']}'";
					$run40=mysqli_query($con,$q40);
					if(mysqli_num_rows($run40)==1){
						echo"<button class='btn btn-mutted' onclick='unfollow({$row38['id']})'>Unfollow</button>";
					}else{
						?>
						 <?php if($_SESSION['id']!=$row38['id']){ ?>
						<button onclick='follow(<?php echo$row38['id'];?>)' class="btn btn-primary" id='follow_btn'>Follow</button>
						<?php
						 }
					}
				}else{
					echo'<button class="btn btn-primary" id="follow_btn" data-toggle="modal" data-target="#modal1">Follow</button></br>';
				}
				?>
				</span>
				<br>
				<?php
				//query to get all followers
				$q39="select * from follow where followed='{$row38['id']}'";
				$run39=mysqli_query($con,$q39);
				$row_num39=mysqli_num_rows($run39);
				echo$row_num39." Follower";
				?>
				<i class="fas fa-circle" style="font-size:5px;vertical-align: middle;"></i> 
				<?php
				//query to get all following 
				$q40="select * from follow where following='{$row38['id']}'";
				$run40=mysqli_query($con,$q40);
				$row_num40=mysqli_num_rows($run40);
				echo$row_num40." Following";
				?>
				</div>
				</li>
				<?php
			}
		}
	}else{
		if($_GET['status']=='follower'){
			echo"<div class='alert alert-primary'>0 Follower</div>";
		}else{
			echo"<div class='alert alert-primary'>0 Following</div>";
		}
	}
}
?>
</ul>
</div>
</div><!-- main row close -->
<div class="modal" id="modal1"><!-- modal start -->
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-body">
<button class="close" data-dismiss="modal">&times;</button>
<h3 class="">Please <a href="<?php echo$url; ?>/login"> Login</a> to continue </h3>
</div>
</div>
</div>
</div><!-- modal end -->
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
			$("#spa"+blogger_id).html(response6);
		}
	});
};
//Making unfollow button dynamic
function unfollow(blogger_id){
	//alert(blogger_id);
	$.ajax({
		url:"server.php",
		type:"post",
		data:{unfollow_from_follow_list:'unfollow_from_follow_list',user_id:user_id,blogger_id:blogger_id},
		success:function(response5){
			$("#sp"+blogger_id).html(response5);
			$("#spa"+blogger_id).html(response5);
		}
	});
};
</script>
</body>
</html>