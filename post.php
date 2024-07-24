<?php
$page="Post";
if(session_id()==''){
	session_start();
}
include_once("conn.php");
//increasing post view dynamically
if(isset($_GET['seo_title'])){
	$url_friendly_title=mysqli_real_escape_string($con,$_GET['seo_title']);
	$q24="update post set view=view+1 where url_friendly_title='$url_friendly_title'";
	$run24=mysqli_query($con,$q24);
}
//fetching the detail of the post whose title is comming from the url
$q11="select * from post where url_friendly_title='$url_friendly_title'";
$run11=mysqli_query($con,$q11);
$row11=mysqli_fetch_array($run11);
$title=$row11['url_friendly_title'];
$description=$row11['description'];
$post_id=$row11['id'];
//fetching the detail of the blogger who write this post
$q12="select * from user where id='{$row11['user_id']}'";
$run12=mysqli_query($con,$q12);
$row12=mysqli_fetch_array($run12);
$author=$row12['fullname'];
?>
<?php
include_once("include/header.php");
include_once("include/navbar.php");
?>
<div class="container-fluid"><!-- main container of the page start -->
<div id="leftside" class="bg-white p-3 d-md-block leftside">
<?php
include_once('include/sidebarHome.php');
?>
</div>
<div class="rightside" id=""><!-- #rightside start -->
<div class="container shadow p-2 bg-white"><!-- container p-2 bg-white  start-->
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="<?php echo$url; ?>">Home</a></li>
<li class="breadcrumb-item active"> <?php echo$row11['title'];?></li>
</ul>
<div class="row"  id="content"><!-- row start-->
<div class="col-md-12"><!-- container start-->
<h3 class="text-justify h3"> <?php echo$row11['title'];?> <small>by <?php echo$row12['fullname']; ?></small></h3> uploaded:: <?php echo$row11['time']." ".$row11['date']; ?>
<img class="img-fluid shadow my-3 rounded" src="image/thumbnail/<?php echo$row11['thumbnail'];?>" id="thumbnail">
<div id="main-content">
 <?php echo$row11['content'];?>
</div>
<div class="text-center"> <!-- all button start -->
<span id="sp2"><!-- creating like button start -->
<?php
if(isset($_SESSION['id'])){
//check kar raha hu ki user ne is post ko pahle se like kiya hai ya nhi
$q33="select * from blog_like where user_id='{$_SESSION['id']}' and post_id='$post_id'";
$run33=mysqli_query($con,$q33);
if(mysqli_num_rows($run33)==1){
	?>
<button class="btn btn-primary btn24" onclick='unlike()'><i class="fa fa-thumbs-up"></i>  <span id="sp3"></span></button>	
<?php
}else{
	echo'<button class="btn btn24" onclick="like()"><i class="fa fa-thumbs-up"></i> <span id="sp3"></span></button>';
}
}else{
	echo'<button class="btn btn24" id="follow_btn" data-toggle="modal" data-target="#modal1"><i class="fa fa-thumbs-up"></i> <span id="sp3"></span></button>';
}
?>
</span><!-- creating like button end -->
<button class="btn btn-primary btn24 clearfix">
<span class=" float-left"><i class="fa fa-eye"></i></span>
<span class="d-none d-md-inline-block">Views</span>
<span id="sp4" class="float-right"><!-- float-right -->
<?php
//fetching total view on this post
echo$row11['view'];
?></span>
</button>
<button class="btn btn-primary btn24"  data-clipboard-text="" data-toggle="tooltip"><i class="fa fa-share"></i></button>
<button class="btn btn-primary btn24" style="width:23%">
<?php 
$q45="select * from comment where post_id='$post_id'";
$run45=mysqli_query($con,$q45);
echo mysqli_num_rows($run45);
?> <i class="fa fa-comment"></i></button>
<span  id="share_msg" class="text-success mt-2"></span>
</div> <!-- all button end -->
</div><!-- container end -->
</div><!-- row end -->
</div><!-- container p-2 bg-white  end-->
<div class="container shadow  my-5 p-2 bg-white">
<h4 class="text-center text-primary">About Author</h4>
<div class="row">
<div class="col-3 text-center">
<img src="image/profile_image/<?php echo$row12['user_profile'];?>" class="img-fluid">
<h5><?php echo$row12['fullname'];?></h5>
</div>
<div class="col-6">
<p class="text-justify"><?php echo$row12['about']; ?> <a href="<?php echo$url; ?>/user/<?php echo$row12['username']; ?>">Read More</a></p>
<!-- creating follow button start -->
<span id="sp1">
<?php
if(isset($_SESSION['id'])){
	if($_SESSION['id']!=$row12['id']){
		//checking whether user followed the blogger or not
		$q21="select * from follow where following='{$_SESSION['id']}' and followed='{$row12['id']}'";
		$run21=mysqli_query($con,$q21);
		if($_SESSION['id']!=$row12['id']){
			if(mysqli_num_rows($run21)==1){
				echo"<button class='btn btn-mutted' onclick='unfollow()'>Unfollow</button>";
			}else{
				echo'<button onclick="follow()" class="btn btn-primary" id="follow_btn">Follow</button>';
			}
		}
	}
}else{
	echo'<button class="btn btn-primary" id="follow_btn" data-toggle="modal" data-target="#modal1">Follow</button>';
}
?>
</span>
<!-- creating follow button start -->
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
<div class="col-3 text-center">
<div class="text-center border-bottom pb-3">
<?php
//query to get all followers
$q23="select * from follow where followed='{$row12['id']}'";
$run23=mysqli_query($con,$q23);
$row_num23=mysqli_num_rows($run23);
echo$row_num23;
?><br>Followers
</div>
<div class="text-center mt-3">
<?php
//query to get all following 
$q22="select * from follow where following='{$row12['id']}'";
$run22=mysqli_query($con,$q22);
$row_num22=mysqli_num_rows($run22);
echo$row_num22;
?>
<br>following
</div>
</div>
</div>
</div>
<?php
//fetching the details of the logged in user to write comment
if(isset($_SESSION['id'])){
$q13="select * from user where id='{$_SESSION['id']}'";
$run13=mysqli_query($con,$q13);
$row13=mysqli_fetch_array($run13);
}
?>
<div class="container shadow-lg p-2 bg-white" id="comment"><!-- comment section start -->
<h4 class="text-center text-primary">Comment </h4><span id="msg_error" class="ml-5 text-danger"></span>
<div class="w-100"><!-- w-100 start -->
<div class="d-inline-block text-center" style="width:20%">
<img src="image/profile_image/<?php if(isset($_SESSION['id'])){echo$row13['user_profile'];}else{echo'not_available.png';}?>" class="rounded-circle border" height="60" width="60"></div>
<div class="w-50 d-inline-block" >
<div class="form-group">
<input type="text" class="mt-2 form-control" placeholder="Add a Comment" name="comment" id="input_comment">
</div>
</div>
<div class="w-25 d-inline-block">
<input type="button" name="sub14" id="<?php if(isset($_SESSION['id'])){echo'sub14';}?>" value="Comment" class="mt-2 btn btn-block btn-primary" <?php if(!isset($_SESSION['id'])){echo"data-target='#modal1' data-toggle='modal'";}?>>
</div>
</div><!-- w-100 end -->
<div class="w-100 mt-4"  id="showcomment"><!-- fetching and showing comment here start -->
</div><!-- fetching and showing comment here end -->
</div><!-- comment section end -->
</div><!-- #rightside end -->
</div><!-- main container of the page  start-->
<!-- footer start -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/custom.js"></script>
<script src="https://kit.fontawesome.com/5d2911aa89.js" crossorigin="anonymous"></script>
<script src="js/clipboard.min.js"></script>
<script>
    //creating content image responsive
    $("#content p img,#content div img").addClass("img-fluid");
    //creating share button
	$("[data-toggle='tooltip']").click(function(){
		url=window.location.href;
		$(this).attr("data-clipboard-text",url);
		new ClipboardJS("[data-toggle='tooltip']");
		$("#share_msg").html("<br>Link Copied");
		$("#share_msg").delay(3000).fadeOut(1,function(){
			$("#share_msg").text("");
			$("#share_msg").show();		
		});
	});
	//count download App
	$(".download_app").click(function(){
		$.ajax({
			url:"server.php",
			type:"post",
			data:"download=download_app",
			success:function(){}
		});
	});
	var post_id="<?php echo$post_id;?>";
	var user_id="<?php if(isset($row13['id'])){echo$row13['id'];} ?>";
	var blogger_id="<?php echo$row12['id']; ?>";
	show_comment();
	//showing comment
	function show_comment(){
		$.ajax({
			url:"server.php",
			type:"post",
			data:{show_comm:'show_comm',blogger_id:blogger_id,post_id:post_id},
			success:function(response){
				$("#showcomment").html(response);
			}
		});
	}
	//Making follow button dynamic
	function follow(){
		$.ajax({
			url:"server.php",
			type:"post",
			data:{follow_btn:'follow_btn_clicked',user_id:user_id,blogger_id:blogger_id},
			success:function(response3){
				$("#sp1").html(response3);
			}
		});
	};
	//Making unfollow button dynamic
	function unfollow(){
		$.ajax({
			url:"server.php",
			type:"post",
			data:{unfollow_btn:'unfollow_btn_clicked',user_id:user_id,blogger_id:blogger_id},
			success:function(response4){
				$("#sp1").html(response4);
			}
		});
	};
	//Making like button dynamic
	function like(){
		$.ajax({
			url:"server.php",
			type:"post",
			data:{liked:'likedFromPost',blogger_id:blogger_id,user_id:user_id,post_id:post_id},
			success:function(response6){
				$("#sp2").html(response6);
				countLike();
			}
		});
	}
	//Making unlike button dynamic
	function unlike(){
		$.ajax({
			url:"server.php",
			type:"post",
			data:{unliked:'unlikedFromPost',blogger_id:blogger_id,user_id:user_id,post_id:post_id},
			success:function(response7){
				$("#sp2").html(response7);
				countLike();
			}
		});
	}
	//function to count like on opened post
	countLike();
	function countLike(){
		$.ajax({
			url:"server.php",
			type:"post",
			data:{countLike:"countLike",blogger_id:blogger_id,post_id:post_id},
			success:function(response8){
				$("#sp3").text(response8);
			}
		});
	}
	//inserting comments
	$("#sub14").click(function(){
		var comment=$("#input_comment").val();
		if(comment==""){
			$("#msg_error").text("**Please Write Comment");
		}else{
			$.ajax({
				url:"server.php",
				type:"post",
				data:{post_id:post_id, user_id:user_id, blogger_id:blogger_id, comment:comment},
				success:function(response2,status2){
					show_comment();
					$("#input_comment").val('');
					$("#msg_error").text("");
				}
			});
		}
	});
</script>
</body>
</html>