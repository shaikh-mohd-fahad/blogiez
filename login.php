<?php
session_start();
if(isset($_SESSION['id'])){
echo"<script>location.href='$url/profile';</script>";
}
$title="Login";
$page="Login";
include_once("include/header.php");
include_once("include/navbar.php");
?>
<div class="container"> <!-- container start -->
<div class="row mt-5"><!-- row start -->
<div class="col-md-3"></div>
<div class="col-md-6 bg-white shadow p-3 mt-5 rounded" id="box"><!-- col-md-6 start -->
<h3 class="text-center text-primary">Login to continue</h3>
<span id="show_error"></span>
<form id="form_to_login" method="post">
<?php //below line will help me to submit data on server.php page ?>
<input type="hidden" name="form_login_submit" value="login">
<div class="form-group">
Email:
<input type="email" class="form-control" placeholder="Enter Email" name="email" required> 
</div>
<div class="form-group">
Password:
<input type="password" class="form-control" placeholder="Enter Password" id="password" name="password" required> 
<label for="hide_and_show_pass" style="cursor:pointer"><input type="checkbox" id="hide_and_show_pass"> <small>Show Password</small></label> 
</div>
<div class="form-group">
<button type="submit" class="btn btn-primary btn-block" id="sub3" name="sub3"> Log in </button>
</div>
</form>
<span class="float-right">
Create New Account <a href="<?php echo$url; ?>/signup"> Click Here</a>
</span>
<div class="row mt-5"><!-- row start -->
<div class="col-12 text-center">
<a href="<?php echo$url; ?>/forgot_pass">Forgotten Password?</a>
</div>
</div><!-- row end -->
</div><!-- col-md-6 end -->
<div class="col-md-3"></div>
</div><!-- row end -->
</div><!-- container end -->
<?php
include_once("include/footer.php");
?>
<script>
$(document).ready(function(){
//hide and show password
	$("#hide_and_show_pass").click(function(){
		check_status=$("#hide_and_show_pass").is(":checked");
		if(check_status==true){
			//show password
			$("#password").attr("type","text");
		}
		else{
			//hide password
			$("#password").attr("type","password");
		}
	});
	//submiting all data to server
	$("#form_to_login").submit(function(e){
		e.preventDefault();
		dataa=$("#form_to_login").serialize();
		$.ajax({
			url:"server.php",
			type:"post",
			data:dataa,
			beforeSend:function(){
			    $("#sub3").html("<i class='fas fa-sync fa-spin'></i>");
			},
			success:function(response16){
			    $("#sub3").html("Log in");
				$("#show_error").html(response16);
			}
		});
	});
});
</script>