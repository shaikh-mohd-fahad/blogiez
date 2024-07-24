<?php
if(session_id()==''){
	session_start();
}
if(isset($_SESSION['id'])){
echo"<script>location.href='<?php echo$url; ?>/profile';</script>";
}
$title="Sign Up";
$page="Sign Up";
include_once("include/header.php");
include_once("include/navbar.php");
include_once("conn.php");
?>
<div class="container add-post-container">
<div class="row mb-4 mt-5">
<div class="col-md-3"></div>
<div class="col-md-6 bg-white shadow p-3 mt-5 rounded" id="box">
<h3 class="text text-primary text-center"> Create New Account</h3>
<form action="" id="form_new_account" method="post">
<?php //below line will help me to submit data on server.php page ?>
<input type="hidden" name="form_new_account_submit" value="submit">
<div class="form-group">
Full name:
<input type="text" value="<?php if(isset($fullname)){echo$fullname;}?>" class="form-control" placeholder="Name to Display" name="fullname" required> 
</div>
<div class="form-group">
Username:<span class="float-right" id="show_user_err"></span>
<input type="text" id="username" value="<?php if(isset($username)){echo$username;}?>" class="form-control" placeholder="Username is Unique" name="username" required> 
</div>
<div class="form-group">
Email:
<input type="email" class="form-control" value="<?php if(isset($email)){echo$email;}?>" placeholder="Enter Email" name="email" required>
</div>
<div class="form-group">
Password: <span class="float-right text-danger" id="wrong_pass"></span>
<input type="password" class="form-control" placeholder="Enter Password" name="password" required id="password">
<label for="hide_and_show_pass" style="cursor:pointer"><input type="checkbox" id="hide_and_show_pass"> <small>Show Password</small></label> 
</div>
<div class="form-group">
Confirm Password:<span class="float-right text-danger" id="wrong_pass2"></span>
<input type="password" class="form-control" placeholder="Confirm Your Password" name="con_password" required id="con_password">
<label for="hide_and_show_con_pass" style="cursor:pointer"><input type="checkbox" id="hide_and_show_con_pass"> <small>Show Confirm Password</small></label> 
</div>
<div class="form-group">
Gender:
<label for="female">
<input type="radio" name="gender" value="female" <?php if(isset($gender) && $gender=='female'){echo'checked';}?> id="female"> Female
</label>
<label for="male">
<input type="radio" name="gender" value="male" id="male" <?php if(isset($gender) && $gender=='male'){echo'checked';}?>> Male
</label>
</div>
<div class="form-group">
<div class="row">
<div class="col-md-4">Date of Birth:</div>
<div class="col-md-8"> <input type="date"  value="<?php if(isset($birthday)){echo$birthday;}?>" name="birthday" class="form-control" required> </div>
</div>
</div>
<div class="form-group">
<button type="submit" class="btn btn-primary btn-block" id="signup" name="sub1">Sign Up</button>
</div>
<span id="show_error"></span>
</form>
<span class="float-right">
Already have an account? <a href="<?php echo$url; ?>/login"> Login</a>
</span>
</div>
<div class="col-md-3"></div>
</div>
</div>
<?php
include_once("include/footer.php");
?>
<script>
error_count1=0;
error_count2=0;
error_count3=0;
var con_passwrod_check_time=0;
// confirmed password length start
function conPasswordLength(){
	con_pass_length=$("#con_password").val().length;
	if(con_pass_length<8 || con_pass_length>25){
		$("#wrong_pass2").text("**Passwords must be between 8 to 25 characters");
		error_count2=1;
		if(error_count1==0 && error_count2==0 && error_count3==0){
			$("#signup").attr("disabled",false);
		}else{
			$("#signup").attr("disabled",true);
		}
	}else{
		
		$("#wrong_pass2").text("");
		//$("#signup").attr("disabled",false);
		con_passwrod_check_time+=1;
		check_pass();
		error_count2=0;
		if(error_count1==0 && error_count2==0 && error_count3==0){
			$("#signup").attr("disabled",false);
		}else{
			$("#signup").attr("disabled",true);
		}
	}
}
// confirmed password length end
//password length start
function passwordLenght(){
	var pass_length=$("#password").val().length;
	if(pass_length<8 || pass_length>25){
		$("#wrong_pass").text("**Passwords must be between 8 to 25 characters");
		error_count2=1;
		if(error_count1==0 && error_count2==0 && error_count3==0){
			$("#signup").attr("disabled",false);
		}else{
			$("#signup").attr("disabled",true);
		}
	}else{
		$("#wrong_pass").text("");
		if($("#con_password").val().length>0){
			check_pass();
		}
		error_count2=0;
		if(error_count1==0 && error_count2==0 && error_count3==0){
			$("#signup").attr("disabled",false);
		}else{
			$("#signup").attr("disabled",true);
		}
		if(con_passwrod_check_time>0){
			check_pass();
		}
	}
}
//password length end
//check passwrod and confirm password equality start
function check_pass(){
	password=$("#password").val();
	con_password=$("#con_password").val();
	if(password!=con_password){
		$("#wrong_pass").text("**Passwords are not matching");
		error_count3=1;
		if(error_count1==0 && error_count2==0 && error_count3==0){
			$("#signup").attr("disabled",false);
		}else{
			$("#signup").attr("disabled",true);
		}
	}else{
		$("#wrong_pass").text("");
		error_count3=0;
		if(error_count1==0 && error_count2==0 && error_count3==0){
			$("#signup").attr("disabled",false);
		}else{
			$("#signup").attr("disabled",true);
		}
	}
}
//check passwrod and confirm password equality end
$(document).ready(function(){
	$("#con_password").blur(function(){
		conPasswordLength();
	});
	$("#password").blur(function(){
		passwordLenght();
	});
});
//checking availability of username start
$("#username").blur(function (){
	var VAL = this.value;
	new_username= $("#username").val();
	new_username=new_username.toLowerCase();
	var regexx = new RegExp('^[A-Za-z0-9_]{3,20}$');
	if (!(regexx.test(VAL))){
		$("#show_user_err").html("<span class='text-danger'><small>Sorry, only letters(a-z), numbers(0-9) and (_) are allowed.</small></span>");
		error_count1=1;
		if(error_count1==0 && error_count2==0 && error_count3==0){
			$("#signup").attr("disabled",false);
		}else{
			$("#signup").attr("disabled",true);
		}
	}
	else{
		$.ajax({
			url:"server.php",
			type:"post",
			data:"userAvailable="+new_username,
			success:function(response10){
				if(response10==true){
					$("#show_user_err").html("<span class='text-danger'>**Username Unavailable</span>");
					error_count1=1;
					if(error_count1==0 && error_count2==0 && error_count3==0){
						$("#signup").attr("disabled",false);
					}else{
						$("#signup").attr("disabled",true);
					}
				}else{
					$("#show_user_err").html("<span class='text-success'>Username Available</span>");
					error_count1=0;
					if(error_count1==0 && error_count2==0 && error_count3==0){
						$("#signup").attr("disabled",false);
					}else{
						$("#signup").attr("disabled",true);
					}
				}
			}
		});
	}
});
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
//hide and show confirm password
$("#hide_and_show_con_pass").click(function(){
	check_status=$("#hide_and_show_con_pass").is(":checked");
	if(check_status==true){
		//show password
		$("#con_password").attr("type","text");
	}
	else{
		//hide password
		$("#con_password").attr("type","password");
	}
});
//submiting all data to server
$("#form_new_account").submit(function(e){
	e.preventDefault();
	if(error_count1==0 && error_count2==0 && error_count3==0){
		dataa=$("#form_new_account").serialize();
		$.ajax({
			url:"server.php",
			type:"post",
			data:dataa,
			beforeSend:function(){
			    $("#sub3").html("<i class='fas fa-sync fa-spin'></i>");
			},
			beforeSend:function(){
			    //alert("testing");
			  $("#signup").html('<i class="fas fa-sync fa-spin"></i>');  
			},
			success:function(response16){
			    //alert(response16);
			   $("#signup").html("Sign Up");
				$("#show_error").html(response16);
			}
		});
	}else{
		alert("please fill form properly");
	}
});
</script>