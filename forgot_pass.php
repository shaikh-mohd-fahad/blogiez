<?php
session_start();
$title="Recover Password";
$page="Recover Password";
include_once("include/header.php");
include_once("include/navbar.php");
?>
<div class="container mt-5">
<div class="row">
<div class="col-md-3"></div>
<div class="col-md-6 bg-white shadow p-3 mt-5 rounded">
<!-- submiting email to check and send OTP -->
<form action="" method="post" id="form1">
<div class="form-group">
Enter Your Email <span class="float-right sp_email_error" id=""></span>
<input type="email" name="email" id="email" placeholder="Enter Your Email" class="form-control" required>
</div>
<div class="form-group">
<input type="submit" name="submit_email" id="submit_email" class="btn btn-primary btn-block">
</div>
</form>


<!-- Submitting OTP -->
<form action="" method="post" id="form2" class="d-none">
<div class="form-group">
<span class="float-right sp_email_error" id=""></span>
<input type="email" disabled name="email_otp" id="email_otp" class="form-control" required>
</div>
<div class="form-group">
Enter OTP
<input type="text" name="OTP" id="OTP" placeholder="Enter OTP" class="form-control" required>
</div>
<div class="form-group">
<input type="submit" name="submit_OTP" id="submit_OTP" class="btn btn-primary btn-block">
</div>
</form>

<!-- Changing User Password -->
<form action="" method="post" id="form3" class="d-none">
<div class="form-group">
<span class="float-right sp_email_error" id=""></span>
<input type="email" disabled name="email_password" id="email_password" class="form-control" required>
</div>
<div class="form-group">
New Password:
<input type="password" class="form-control" placeholder="Enter Password" name="password" required id="password"> 
</div>
<div class="form-group">
Confirm Password:
<input type="password" class="form-control" placeholder="Confirm Your Password" name="con_password" required id="con_password"> 
</div>
<div class="form-group">
<input type="submit" name="submit_password" id="submit_password" class="btn btn-primary btn-block">
</div>
</form>
</div>
<div class="col-md-3"></div>
</div>
</div>

<!-- footer start -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/5d2911aa89.js" crossorigin="anonymous"></script>
<script src="js/custom.js"></script>
<script>
$(document).ready(function(){
		$("#con_password").blur(function(){
		password=$("#password").val();
		con_password=$("#con_password").val();
		if(password!=con_password){
			$(".sp_email_error").html("<span class='text-danger'>**Passwords are not matching</span>");
			$("#submit_password").attr();
		}else{
			$(".sp_email_error").html("");
		}
	});
	$("#password").blur(function(){
		var pass_length=$("#password").val().length;
		if(pass_length<8 || pass_length>25){
			$(".sp_email_error").html("<span class='text-danger'>**Passwords must be between 8 to 25 characters</span>");
		}else{
			$(".sp_email_error").html("");
		}
	});
	//Checking and sending otp to email
	$("#form1").submit(function(e){
		e.preventDefault();
		email=$("#email").val();
		//alert(email);
		$.ajax({
			url:"server.php",
			type:"post",
			data:{sendOTP:"sendOTP",email:email},
			success:function(response){
				//alert(response);
				if(response=="true"){
					$(".sp_email_error").html("<span class='text-success'>OTP is send to your Email.Please verify Email</span>");
					$("#form1").addClass("d-none");
					$("#form2").removeClass("d-none");
					$("#email_otp").val(email);
				}else{
					$(".sp_email_error").html("<span class='text-danger'>**Email Not Exist</span>");
				}
			}
		});
	});
	
	
	
	//Checking/Verifying OTP
	$("#form2").submit(function(e){
		e.preventDefault();
		email=$("#email_otp").val();
		//alert(email);
		OTP=$("#OTP").val();
		//alert(OTP);
		$.ajax({
			url:"server.php",
			type:"post",
			data:{verifyOTP:"verifyOTP",email:email,OTP:OTP},
			success:function(response){
				if(response=="true"){
					$(".sp_email_error").html("<span class='text-success'>OTP is Verfied</span>");
					$("#form2").addClass("d-none");
					$("#form3").removeClass("d-none");
					$("#email_password").val(email);
				}else{
					$(".sp_email_error").html("<span class='text-danger'>**OTP is Wrong</span>");
				}
			}
		});
	});
	
	
	
	//submiting password
	$("#form3").submit(function(e){
		e.preventDefault();
		email=$("#email_password").val();
		password=$("#password").val();
		con_password=$("#con_password").val();
		//alert(email);
		//OTP=$("#OTP").val();
		//alert(OTP);
		$.ajax({
			url:"server.php",
			type:"post",
			data:{SubmitNewPass:"SubmitNewPass",email:email,password:password,con_password:con_password},
			success:function(response){
				if(response=="true"){
					$(".sp_email_error").html("<span class='text-success'>Password Changed</span>");
					//$("#form2").addClass("d-none");
					//$("#form3").removeClass("d-none");
					//$("#email_password").val(email);
				}else{
					$(".sp_email_error").html("<span class='text-danger'>**Password is not Changed</span>");
				}
			}
		});
	});
});
</script>
</body>
</html>