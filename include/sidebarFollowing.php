<style>
#img-fluid{
	max-height:60px;
	width:60px;
	height:60px;
}
ul{
	padding:0
}
.btn{
	font-size:15px;
	padding:3px;
}
</style>
<form class="shadow px-3 pt-3 pb-1 mb-3 rounded" action="following.php" method="post">
<div class="form-group">
<input type="search" class="form-control" name="search" placeholder="Search Friend/blogger..." required>
</div>
<div class="form-group">
<input type="submit" class="btn btn-muted" name="searchFriend" value="Search">
</div>
</form>
<div class="shadow bg-white rounded p-3">
<h4 class="text-primary">Find Friends/Blogger</h4>
<ul class="">
<?php
if(isset($_POST['searchFriend'])){
	$search=$_POST['search'];
	$q48="select * from user where username like '%$search%' and verify_status='1'  order by rand() limit 5";
}else{
	$q48="select * from user where id!={$_SESSION['id']} and verify_status='1' order by rand() limit 5";
}
$run48=mysqli_query($con,$q48);
while($row48=mysqli_fetch_array($run48)){
?>
	<li class="media mb-2">
	<a href="<?php echo$url; ?>/user/<?php echo$row48['username']; ?>"><img src="image/profile_image/<?php echo$row48['user_profile']; ?>" class="rounded-circle img-fluid mr-3 align-self-center" id="img-fluid"></a>
	<div class="media-body mt-3">
	<a href="<?php echo$url; ?>/user/<?php echo$row48['username']; ?>"><strong><?php  echo$row48['username'];?></strong></a>
	<span class="float-right mr-3"  id="sp<?php echo$row48['id'] ?>">
	<?php
	// creating follow/unfollow button
	if(isset($_SESSION['id'])){
		//checking  whether Logged in user followed this blogger or not
		$q49="select * from follow where following='{$_SESSION['id']}' and followed='{$row48['id']}'";
		$run49=mysqli_query($con,$q49);
		if(mysqli_num_rows($run49)==1){
			echo"<button class='btn btn-mutted' onclick='unfollow({$row48['id']})'>Unfollow</button>";
		}else{
			?>
			 <?php if($_SESSION['id']!=$row48['id']){ ?>
			<button onclick='follow(<?php echo$row48['id'];?>)' class="btn btn-primary" id='follow_btn'>Follow</button>
			<?php
			 }
		}
	}
	?>
	</span>
	</div>
	</li>
<?php
}
?>
</ul>
</div>