//deleting post dynamically
function del(del_id){
	$.ajax({
		url:'../delete.php',
		type:'post',
		data:'del_id='+del_id,
		success:function(response){
			if(response=='true'){
				$('#post_box'+del_id).hide();
			}else{
				alert('Some error occured During deleting this post. Please try after some time.');
			}
		}
	});
}
//Making follow button dynamic
function follow(){
	$.ajax({
		url:"../server.php",
		type:"post",
		data:{follow_btn:'follow_btn_clicked',user_id:user_id,blogger_id:blogger_id},
		success:function(response6){
			$("#sp1").html(response6);
		}
	});
};
//Making unfollow button dynamic
function unfollow(){
	$.ajax({
		url:"../server.php",
		type:"post",
		data:{unfollow_btn:'unfollow_btn_clicked',user_id:user_id,blogger_id:blogger_id},
		success:function(response5){
			$("#sp1").html(response5);
		}
	});
};
//Making like button dynamic
function like(post_id){
	$.ajax({
		url:"../server.php",
		type:"post",
		data:{liked:'likedFromProfile',blogger_id:blogger_id,user_id:user_id,post_id:post_id},
		success:function(response6){
			$("#LikeBox"+post_id).html(response6);
			countLike(post_id);
		}
	});
};
//Making unlike button dynamic
function unlike(post_id){
	$.ajax({
		url:"../server.php",
		type:"post",
		data:{unliked:'unlikedFromProfile',blogger_id:blogger_id,user_id:user_id,post_id:post_id},
		success:function(response7){
			$("#LikeBox"+post_id).html(response7);
			countLike(post_id);
		}
	});
};
function countLike(post_id){
	$.ajax({
		url:"../server.php",
		type:"post",
		data:{countLike:"countLike",blogger_id:blogger_id,post_id:post_id},
		success:function(response8){
			$("#LikeCountBox"+post_id).text(response8);
		}
	});
};
//uploading user profile image to server and then show it on popup/modal
$("#user_profile").change(function(e){
	e.preventDefault();
	var formData= new FormData(user_profile_form1);
	$.ajax({
		url:"../server.php",
		type:"post",
		data:formData,
		contentType:false,
		processData:false,
		success:function(response9){
			if(response9=="wrong format"){
				$("#error_msg1").text("Image format is wrong");
			}else if(response9=="size exceeded"){
				$("#error_msg1").text("Image size exceed 2mb");
			}else{
				// we use ../ in below src because we add user/@username in htaccess
				$("#show_uploaded_user_profile").attr("src","../image/profile_image/"+response9);
				//this button is used to open modal to show new profile image
				$("#btn_user_profile").click();
				$("#new_profile").val(response9);
			}
		}
	});
	//below line is working perfectly to upload same file many time
	$("#user_profile").prop("value","");
});

//uploading details of image in database after user click to update profile
$("#user_profile_form2").submit(function(e2){
	e2.preventDefault();
	var formData1= new FormData(this);
	$.ajax({
		url:"../server.php",
		type:"post",
		data:formData1,
		contentType:false,
		processData:false,
		success:function(response11){
			if(response11=="updated"){
				new_pro_img=$("#new_profile").val();
				$("#new_profile").val("");
				$("#old_profile").val(new_pro_img);
				$(".user_profile_img").attr("src","../image/profile_image/"+new_pro_img);
				$("#modal_remove_btn").click();
			}
		}
	});
});
//if user click on cancel button, then delete just uploaded profile image  from server
$("#cancel_upload_profile").click(function(){
	new_pro_img=$("#new_profile").val();
	$.ajax({
		url:"../server.php",
		type:"post",
		data:"new_pro_img1="+new_pro_img,
		success:function(response12){
			$("#modal_remove_btn").click();
		}
	});
});
//uploading user cover image to server and then show it on popup/modal
$("#user_cover").change(function(e){
	e.preventDefault();
	var formData= new FormData(user_cover_form1);
	$.ajax({
		url:"../server.php",
		type:"post",
		data:formData,
		contentType:false,
		processData:false,
		success:function(response13){
			if(response13=="wrong format"){
				$("#error_msg1").text("Image format is wrong");
			}else if(response13=="size exceeded"){
				$("#error_msg1").text("Image size exceed 2mb");
			}else{
				// we use ../ in below src because we add user/@username in htaccess
				$("#show_uploaded_user_cover").attr("src","../image/cover_image/"+response13);
				//this button is used to open modal to show new cover image
				$("#btn_user_cover").click();
				$("#new_cover").val(response13);
			}
		}
	});
	//below line is working perfectly to upload same file many time
	$("#user_cover").prop("value","");
});
//uploading details of image in database after user click to update cover
$("#user_cover_form2").submit(function(e2){
	e2.preventDefault();
	var formData1= new FormData(this);
	$.ajax({
		url:"../server.php",
		type:"post",
		data:formData1,
		contentType:false,
		processData:false,
		success:function(response14){
			if(response14=="updated"){
				new_cover_img=$("#new_cover").val();
				$("#new_cover").val("");
				$("#old_cover").val(new_cover_img);
				$("#img2").attr("src","../image/cover_image/"+new_cover_img);
				$("#modal_remove_btn2").click();
			}
		}
	});
});
//if user click on cancel button, then delete just uploaded image  from server
$("#cancel_upload_cover").click(function(){
	new_pro_img=$("#new_cover").val();
	$.ajax({
		url:"../server.php",
		type:"post",
		data:"new_pro_img1="+new_pro_img,
		success:function(response15){
			$("#modal_remove_btn2").click();
		}
	});
});

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
			$("#update").attr("disabled",false);
		}else{
			$("#update").attr("disabled",true);
		}
	}else{
		
		$("#wrong_pass2").text("");
		//$("#update").attr("disabled",false);
		con_passwrod_check_time+=1;
		check_pass();
		error_count2=0;
		if(error_count1==0 && error_count2==0 && error_count3==0){
			$("#update").attr("disabled",false);
		}else{
			$("#update").attr("disabled",true);
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
			$("#update").attr("disabled",false);
		}else{
			$("#update").attr("disabled",true);
		}
	}else{
		$("#wrong_pass").text("");
		if($("#con_password").val().length>0){
			check_pass();
		}
		error_count2=0;
		if(error_count1==0 && error_count2==0 && error_count3==0){
			$("#update").attr("disabled",false);
		}else{
			$("#update").attr("disabled",true);
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
			$("#update").attr("disabled",false);
		}else{
			$("#update").attr("disabled",true);
		}
	}else{
		$("#wrong_pass").text("");
		error_count3=0;
		if(error_count1==0 && error_count2==0 && error_count3==0){
			$("#update").attr("disabled",false);
		}else{
			$("#update").attr("disabled",true);
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
	old_username=$("#old_username").val();
	old_username=old_username.toLowerCase();
	new_username= $("#username").val();
	new_username=new_username.toLowerCase();
	var regexx = new RegExp('^[A-Za-z0-9_]{3,20}$');
	if (!(regexx.test(VAL))){
		$("#show_user_err").html("<span class='text-danger'><small>Sorry, only letters(a-z), numbers(0-9) and (_) are allowed.</small></span>");
		error_count1=1;
		if(error_count1==0 && error_count2==0 && error_count3==0){
			$("#update").attr("disabled",false);
		}else{
			$("#update").attr("disabled",true);
		}
	}
	else if(old_username==new_username){
		$("#show_user_err").html("<span class='text-danger'><small>**You are entering your own username.</small></span>");
		if(error_count1==0 && error_count2==0 && error_count3==0){
			$("#update").attr("disabled",false);
		}else{
			$("#update").attr("disabled",true);
		}
	}
	else{
		$.ajax({
			url:"../server.php",
			type:"post",
			data:"userAvailable="+new_username,
			success:function(response10){
				if(response10==true){
					$("#show_user_err").html("<span class='text-danger'>**Username Unavailable</span>");
					error_count1=1;
					if(error_count1==0 && error_count2==0 && error_count3==0){
						$("#update").attr("disabled",false);
					}else{
						$("#update").attr("disabled",true);
					}
				}else{
					$("#show_user_err").html("<span class='text-success'>Username Available</span>");
					error_count1=0;
					if(error_count1==0 && error_count2==0 && error_count3==0){
						$("#update").attr("disabled",false);
					}else{
						$("#update").attr("disabled",true);
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
$("#form_edit_profile").submit(function(e){
	e.preventDefault();
	if(error_count1==0 && error_count2==0 && error_count3==0){
		dataa=$("#form_edit_profile").serialize();
		//alert(dataa);
		$.ajax({
			url:"../server.php",
			type:"post",
			data:dataa,
			success:function(response16){
				//alert(response16);
				if(response16){
					$("#show_error").html("<span class='alert alert-success d-block'> Profile Updated</span>");
					username=$("#username").val();
					showprofile();
				}else{
					$("#show_error").html("<span class='alert alert-danger d-block'> **Profile Not Updated</span>");
				}
			}
		});
	}else{
		alert("please form properly");
	}
});