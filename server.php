<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';
include_once("conn.php");
//inserting comment
if(isset($_POST['comment'])){
	$user_id=mysqli_real_escape_string($con,$_POST['user_id']);
	$comment=mysqli_real_escape_string($con,$_POST['comment']);
	$post_id=mysqli_real_escape_string($con,$_POST['post_id']);
	$blogger_id=mysqli_real_escape_string($con,$_POST['blogger_id']);
	$q14="insert into comment(user_id, comment, post_id, blogger_id) values('$user_id', '$comment', '$post_id', '$blogger_id')";
	$run14=mysqli_query($con,$q14);
}//inserting coment ended

//fetching comment for the blog.php page
if(isset($_POST['show_comm'])){
	$q15="select * from comment where post_id='{$_POST['post_id']}' and blogger_id='{$_POST['blogger_id']}' order by id desc";
	$run15=mysqli_query($con,$q15);
	if(mysqli_num_rows($run15)>0){
		while($row15=mysqli_fetch_array($run15)){
		//fetching the detail of the person who commented on this post
		$q16="select * from user where id='{$row15['user_id']}'";
		$run16=mysqli_query($con,$q16);
		$row16=mysqli_fetch_array($run16);
		$data='
		<div class="w-100">
		<div class="text-center d-inline-block  align-top" style="width:20%">
		<img src="image/profile_image/'.$row16['user_profile'].'" class="rounded-circle mr-3" height="60" width="60">
		</div>
		<div class="d-inline-block" style="width:75%">
		<h5 class="mb-0 mt-1">'.$row16['username'].'</h5>
		<span class="text-justify"><small>'.$row15['comment'].'</small> </span>
		</div>
		</div>';
		echo$data;
		}
	}
}//fetching the comment on this blog ended

//inseting follow btn details for page post.php and profile.php
if(isset($_POST['follow_btn']) and $_POST['follow_btn']="follow_btn_clicked"){
	//login user id
	$following=$_POST['user_id'];
	//other blogger id
	$followed=$_POST['blogger_id'];
	$q20="insert into follow(following,followed) values('$following','$followed')";
	$run20=mysqli_query($con,$q20);
	if($run20){
		echo"<button class='btn btn-mutted' onclick='unfollow()'>Unfollow</button>";
	}else{
		echo"something error";
	}
}//inserting follow detail btn ended

//creating unfollow function for page post.php and profile.php
if(isset($_POST['unfollow_btn'])){
	$following=$_POST['user_id'];
	$followed=$_POST['blogger_id'];
	$q22="delete from follow where following='$following' and followed='$followed'";
	$run22=mysqli_query($con,$q22);
	if($run22){
		echo"<button onclick='follow()' class='btn btn-primary' id='follow_btn'>Follow</button>";
	}
}

//inseting follow btn funtion for page follow_list.php
if(isset($_POST['follow_from_follow_list'])){
	$following=$_POST['user_id'];
	$followed=$_POST['blogger_id'];
	$q20="insert into follow(following,followed) values('$following','$followed')";
	$run20=mysqli_query($con,$q20);
	echo"<button class='btn btn-mutted' onclick='unfollow($followed)'>Unfollow</button>";
}//inserting follow detail btn ended

//creating unfollow function for page follow_list.php
if(isset($_POST['unfollow_from_follow_list'])){
	$following=$_POST['user_id'];
	$followed=$_POST['blogger_id'];
	$q22="delete from follow where following='$following' and followed='$followed'";
	$run22=mysqli_query($con,$q22);
	if($run22){
		echo"<button onclick='follow($followed)' class='btn btn-primary' id='follow_btn'>Follow</button>";
	}
}

//inserting like button detail from post page in server
if(isset($_POST['liked']) and ($_POST['liked']=="likedFromPost")){
	$blogger_id=$_POST['blogger_id'];
	$user_id=$_POST['user_id'];
	$post_id=$_POST['post_id'];
	$q31="insert into blog_like(blogger_id, user_id, post_id,blog_like) values('$blogger_id', '$user_id', '$post_id','1')";
	$run31=mysqli_query($con,$q31);
	if($run31){
		echo'<button class="btn btn-primary btn24" onclick="unlike()"><i class="fa fa-thumbs-up"></i> <span id="sp3"></span></button>';
	}
}

//inserting unlike button detail from post page in server
if(isset($_POST['unliked']) and ($_POST['unliked']=="unlikedFromPost")){
	$user_id=$_POST['user_id'];
	$post_id=$_POST['post_id'];
	$q32="delete from blog_like where user_id='$user_id' and post_id='$post_id'";
	$run32=mysqli_query($con,$q32);
	if($run32){
		echo'<button class="btn btn24" onclick="like()"><i class="fa fa-thumbs-up"></i> <span id="sp3"></span></button>';
	}
}

//counting the like on a post
if(isset($_POST['countLike'])){	
	$blogger_id=$_POST['blogger_id'];
	$post_id=$_POST['post_id'];
	$q34="select * from blog_like where blogger_id=
	'$blogger_id' and post_id='$post_id'";
	$run34=mysqli_query($con,$q34);
	if(mysqli_num_rows($run34)>0){
		$like=mysqli_num_rows($run34);
		echo"$like";
	}
}

//inserting like button from profile page in server
if(isset($_POST['liked']) and ($_POST['liked']=="likedFromProfile")){
	$blogger_id=$_POST['blogger_id'];
	$user_id=$_POST['user_id'];
	$post_id=$_POST['post_id'];
	$q31="insert into blog_like(blogger_id, user_id, post_id,blog_like) values('$blogger_id', '$user_id', '$post_id','1')";
	$run31=mysqli_query($con,$q31);
	if($run31){
		echo"<button class='btn btn-primary' onclick='unlike($post_id)'> <span id='LikeCountBox".$post_id."'></span> Like</button>";
	}
}

//inserting unlike button from profile page in server
if(isset($_POST['unliked']) and ($_POST['unliked']=="unlikedFromProfile")){
	$user_id=$_POST['user_id'];
	$post_id=$_POST['post_id'];
	$q32="delete from blog_like where user_id='$user_id' and post_id='$post_id'";
	$run32=mysqli_query($con,$q32);
	if($run32){
		echo"<button class='btn' onclick='like($post_id)'><span id='LikeCountBox".$post_id."'></span> Like </button>";
	}
}

//uploading user's, only profile image of profile.php page
if(isset($_FILES["user_profile"]["name"])){
	$user_profile=$_FILES["user_profile"]["name"];
	$prof_exten=pathinfo($user_profile,PATHINFO_EXTENSION);
	if($prof_exten=="png" ||$prof_exten=="jpeg" ||$prof_exten=="jpg" ||$prof_exten=="PNG" ||$prof_exten=="JPG" ||$prof_exten=="JPEG" ){
		if($_FILES["user_profile"]["size"]<=2097152){
			$user_profile=explode('.',$user_profile);
			$user_profile=$user_profile[0];
			$user_profile.="_blogiez_".rand().".".$prof_exten;
			$user_profile_tmp=$_FILES["user_profile"]["tmp_name"];
			move_uploaded_file($user_profile_tmp,"image/profile_image/".$user_profile);
				$_FILES["user_profile"]=null;
				echo$user_profile;
			/*
			$q43="update user set user_profile='$user_profile' where id='$user_id'";
			$run43=mysqli_query($con,$q43);
			if($run43){
				if($old_profile!="mprofile.png"){
					unlink("image/profile_image/$old_profile");
				}
				move_uploaded_file($user_profile_tmp,"image/profile_image/".$user_profile);
				echo$user_profile;
			}
			*/
		}else{
			echo"size exceeded";
		}
	}else{
		echo"wrong format";
	}
exit();
}
//updating database for new uploaded profile image on profile.php page
if(isset($_POST["new_profile"])){
	$user_id=mysqli_real_escape_string($con,$_POST['user_id']);
	$old_profile=mysqli_real_escape_string($con,$_POST['old_profile']);
	$new_profile=mysqli_real_escape_string($con,$_POST['new_profile']);
	$q43="update user set user_profile='$new_profile' where id='$user_id'";
	$run43=mysqli_query($con,$q43);
	if($run43){
		if(isset($old_profile) and $old_profile!='' and $old_profile!="mprofile.png"){
			unlink("image/profile_image/$old_profile");
		}		
		echo"updated";
	}
}
//deleting image uploaded on server but now it is canceld by user on profile.php page
if(isset($_POST["new_pro_img1"])){
	$new_pro_img=mysqli_real_escape_string($con,$_POST["new_pro_img1"]);
	if($new_pro_img!="mprofile.png"){
			unlink("image/profile_image/$new_pro_img");
			echo"deleted";
		}else{
			echo"not deleted";
		}
}

//uploading user's, only cover image of cover.php page
if(isset($_FILES["user_cover"]["name"])){
	$user_cover=$_FILES["user_cover"]["name"];
	$prof_exten=pathinfo($user_cover,PATHINFO_EXTENSION);
	if($prof_exten=="png" ||$prof_exten=="jpeg" ||$prof_exten=="jpg" ||$prof_exten=="PNG" ||$prof_exten=="JPG" ||$prof_exten=="JPEG" ){
		if($_FILES["user_cover"]["size"]<=2097152){
			$user_cover=explode('.',$user_cover);
			$user_cover=$user_cover[0];
			$user_cover.="_blogiez_".rand().".".$prof_exten;
			$user_cover_tmp=$_FILES["user_cover"]["tmp_name"];
			move_uploaded_file($user_cover_tmp,"image/cover_image/".$user_cover);
				$_FILES["user_cover"]=null;
				echo$user_cover;
			/*
			$q43="update user set user_cover='$user_cover' where id='$user_id'";
			$run43=mysqli_query($con,$q43);
			if($run43){
				if($old_cover!="mcover.png"){
					unlink("image/cover_image/$old_cover");
				}
				move_uploaded_file($user_cover_tmp,"image/cover_image/".$user_cover);
				echo$user_cover;
			}
			*/
		}else{
			echo"size exceeded";
		}
	}else{
		echo"wrong format";
	}
exit();
}
//updating database for new uploaded cover image on cover.php page
if(isset($_POST["new_cover"])){
	$user_id=mysqli_real_escape_string($con,$_POST['user_id']);
	$old_cover=mysqli_real_escape_string($con,$_POST['old_cover']);
	$new_cover=mysqli_real_escape_string($con,$_POST['new_cover']);
	$q43="update user set user_cover='$new_cover' where id='$user_id'";
	$run43=mysqli_query($con,$q43);
	if($run43){
		if(isset($old_cover) and $old_cover!='' and $old_cover!="mcover.png"){
			unlink("image/cover_image/$old_cover");
		}		
		echo"updated";
	}
}
//deleting image uploaded on server but now it is canceld by user on cover.php page
if(isset($_POST["new_pro_img1"])){
	$new_pro_img=mysqli_real_escape_string($con,$_POST["new_pro_img1"]);
	if($new_pro_img!="mcover.png"){
			unlink("image/cover_image/$new_pro_img");
			echo"deleted";
		}else{
			echo"not deleted";
		}
}


//checking email and sending OTP for password recovery from forgot_pass.php
if(isset($_POST['sendOTP'])){
	$email=mysqli_real_escape_string($con,$_POST['email']);
	$q54="select * from user where email='$email'";
	$run54=mysqli_query($con,$q54);
	if(mysqli_num_rows($run54)==1){
	    $otp=rand(111111,999999);
	    $message="Enter this OTP $otp to change password";
	    //sending email to user using phpmailer6
	        $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host = 'smtp.hostinger.com';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->Username = 'blogiez.official@blogiez.com';
            $mail->Password = 'FAlkjkdfls@#4';
            $mail->setFrom('blogiez.official@blogiez.com', 'Blogiez');
            //$mail->addReplyTo('test@hostinger-tutorials.com', 'Your Name');
            $mail->addAddress($email);
            $mail->Subject = "Verify OTP to change Password";
            //$mail->msgHTML(file_get_contents('message.html'), __DIR__);
            $mail->Body = $message;
            //$mail->addAttachment('test.txt');
            if($mail->send()){
    	        //sending email to user using phpmailer6
    		    $q57="update user set OTP='$otp' where email='$email'";
    		    $run57=mysqli_query($con,$q57);
    		    echo"true";
            } else{
                echo"not send";
            }
	}else{
		echo"false";
	}
}


//Verifying otp send to above email from forgot_pass.php
if((isset($_POST['verifyOTP'])) and ($_POST['verifyOTP']=="verifyOTP")){
	$email=mysqli_real_escape_string($con,$_POST['email']);
	$OTP=mysqli_real_escape_string($con,$_POST['OTP']);
	$q55="select * from user where email='$email' and OTP='$OTP'";
	$run55=mysqli_query($con,$q55);
	if(mysqli_num_rows($run55)==1){
		echo"true";
	}else{
		echo"false";
	}
}
//Submiting new password from forgot_pass.php
if((isset($_POST['SubmitNewPass'])) and ($_POST['SubmitNewPass']=="SubmitNewPass")){
	$email=mysqli_real_escape_string($con,$_POST['email']);
	$password=mysqli_real_escape_string($con,$_POST['password']);
	$q56="update user set password='$password' where email='$email'";
	$run56=mysqli_query($con,$q56);
	if($run56){
		echo"true";
	}else{
		echo"false";
	}
}

//App donwload Count
if((isset($_POST['download'])) and ($_POST['download']=="download_app")){
	$q58="update download_count set app_download_count=app_download_count+1";
	$run58=mysqli_query($con,$q58);
}
//Checking username is available or not in sign up page
if(isset($_POST['userAvailable'])){
	$userAvailable=mysqli_real_escape_string($con,$_POST['userAvailable']);;
	$q60="select * from user where username='{$userAvailable}'";
	$run60=mysqli_query($con,$q60);
	if(mysqli_num_rows($run60)==1){
		echo true;
	}else{
		echo false;
	}
}
//submitting edited profile data from profile.php page
if(isset($_POST['form_edit_profile_submit']) and $_POST['form_edit_profile_submit']=='submit'){
	$user_id=htmlentities($_POST['user_id']);
	$user_id=mysqli_real_escape_string($con,$user_id);
	$username=htmlentities($_POST['username']);
	$username=strtolower(mysqli_real_escape_string($con,$username));
	$fullname=htmlentities($_POST['fullname']);
	$fullname=mysqli_real_escape_string($con,$fullname);
	$email=htmlentities($_POST['email']);
	$email=mysqli_real_escape_string($con,$email);
	$about=htmlentities($_POST['about']);
	$about=mysqli_real_escape_string($con,$about);
	$password=htmlentities($_POST['password']);
	$password=mysqli_real_escape_string($con,$password);
	$birthday=htmlentities($_POST['birthday']);
	$birthday=mysqli_real_escape_string($con,$birthday);
	$q42="update user set username='$username',fullname='$fullname', email='$email', password='$password', birthday='$birthday',about='$about' where id='$user_id'";
	$run42=mysqli_query($con,$q42);
	if($run42){
		//setCookie("id",$user_id,time()+60*60*24*365);
		setCookie("username",$username,time()+60*60*24*365);
		if(session_id()==''){
			session_start();
		}
		//$_SESSION['id']=$_COOKIE['id'];
		$_SESSION['username']=$_COOKIE['username'];
		echo true;
	}else{
		echo false;
	}
}

// creating new account from signup.php page
if(isset($_POST['form_new_account_submit']) and $_POST['form_new_account_submit']=='submit'){
	$username=htmlentities($_POST['username']);
	$username=strtolower(mysqli_real_escape_string($con,$username));
	$fullname=htmlentities($_POST['fullname']);
	$fullname=mysqli_real_escape_string($con,$fullname);
	$email=htmlentities($_POST['email']);
	$email=mysqli_real_escape_string($con,$email);
	$password=htmlentities($_POST['password']);
	$password=mysqli_real_escape_string($con,$password);
	$gender=htmlentities($_POST['gender']);
	$gender=mysqli_real_escape_string($con,$gender);
	if($gender=='male'){
		$profile='mprofile.png';
	}else{
		$profile='mprofile.png';
	}
	$birthday=htmlentities($_POST['birthday']);
	$birthday=mysqli_real_escape_string($con,$birthday);
	date_default_timezone_set('Asia/Kolkata');
	$date=date('j M Y g:i:sa');//j for day, M for 3 words of Month, Y for 4 digit of year
	$q2="select * from user where email='$email'";
	$run2=mysqli_query($con,$q2);
	if(mysqli_num_rows($run2)==1){
		$q4="select * from user where email='$email' and verify_status='1'";
		$run4=mysqli_query($con,$q4);
		if(mysqli_num_rows($run4)==1){
			$msg="<span class='alert alert-danger my-3 d-block'>**Email is Already Registered</span>";
			echo$msg;
		}else{
			$msg="<span class='alert alert-danger my-3 d-block'>**Email is Registered but not verified. Please verify your email</span>";
			echo$msg;
		}
	}else{
	    $str="abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $verification_id=substr(str_shuffle($str),0,20);
		$q1="insert into user(username,fullname, password, email, gender, birthday, joining_date, user_profile,user_cover, verification_id) values('$username', '$fullname', '$password', '$email', '$gender', '$birthday','$date','$profile','not_available.png','$verification_id')";
		$run1=mysqli_query($con,$q1);
		if($run1){
			$subject="Blogiez Account Verification";
			$message="Please confirm your email registrartion by clicking this button <a href='$url/verify.php?id=$verification_id'><button style='background:#007bff;color:white'>Click Me</button></a>";
            //require 'vendor/autoload.php';
			$mail = new PHPMailer(true);
			$mail->IsSMTP();
			$mail->Host = 'smtp.hostinger.com';
			$mail->SMTPAuth = true;
			$mail->Username = 'blogiez.official@blogiez.com';
			$mail->Password = 'FAlkjkdfls@#4';
			$mail->SMTPSecure = 'tls';
			$mail->Port = 587;
			$mail->setFrom('blogiez.official@blogiez.com','Blogiez');
			$mail->addAddress($email);
			$mail->IsHTML(true);
			$mail->Charset='UTF-8';
			$mail->Subject = $subject;
			$mail->Body    = $message;
			//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
			$mail->SMTPOptions=array('ssl'=>array(
				'verify_peer'=>false,
				'verify_peer_name'=>false,
				'allow_self_signed'=>false
			));
			if($mail->send()){
			    $msg="<span class='text-danger float-right'>We have just sent a verification link to <b>$email</b>. Please check your inbox and click on the link to get started.<br>If email is not delivered immediately please wait for 1-2 min.  </span>";
			    echo$msg;
			}else{
			    $msg="<span class='text-danger float-right'>Verification lin on email is not sent.</span>";
			    echo$msf;
			}
		}else{
			$msg="<span class='text-danger float-right'>**Registration Failled <br>$q1</span>";
			echo$msg;
		}
	}
}
// checking login detail to login
if(isset($_POST['form_login_submit']) and $_POST['form_login_submit']=='login'){
	$email=htmlentities($_POST['email']);
	$email=mysqli_real_escape_string($con,$email);
	$password=htmlentities($_POST['password']);
	$password=mysqli_real_escape_string($con,$password);
	//checking email existance
	$q3="select * from user where email='$email'";
	$run3=mysqli_query($con,$q3);
	if(mysqli_num_rows($run3)==1){
		//checking email is verified or not;
		$q52="select * from user where email='$email' and verify_status='1'";
		$run52=mysqli_query($con,$q52);
		if($row52=mysqli_num_rows($run52)==1){
			$q53="select * from user where email='$email' and password='$password'";
			$run53=mysqli_query($con,$q53);
			if($row53=mysqli_num_rows($run53)==1){
				$row53=mysqli_fetch_array($run3);
				setCookie("id",$row53['id'],time()+60*60*24*365);
				setCookie("username",$row53['username'],time()+60*60*24*365);
				echo"<script> location.href='$url/user/profile';</script>";
			}else{
				$msg="<span class='text-danger float-right'>**Wrong Email or Password</span>";
				echo$msg;
			}
		}else{
			$msg="<span class='text-danger float-right'>**Your email is registered but not verified. Please Verify Your Email</span>";
			echo$msg;
		}
	}else{
		$msg="<span class='text-danger float-right'>**Email not Exist </span>";
		echo$msg;
	}
}
?>