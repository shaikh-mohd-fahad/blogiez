<?php
if(session_id()==''){
	session_start();
}
if(isset($_COOKIE['id']) && isset($_COOKIE['username'])){
	$_SESSION['id']=$_COOKIE['id'];
	$_SESSION['username']=$_COOKIE['username'];
}
include_once("conn.php");
if(!isset($_COOKIE['visiter'])){
setCookie('visiter','yes',time()+60*60*24*365);
mysqli_query($con,"update `visitor_counter` set count=count+1");
}
if(!isset($_SESSION['id'])){
echo"<script>location.href='<?php echo$url; ?>/php/blog/third/login';</script>";
}
$page="Edit Blog";
$title="Edit Blog";
$id=$_SESSION['id'];
//Updating  post content
if(isset($_POST['sub18'])){
	$id=mysqli_real_escape_string($con,$_POST['id']);
	$title=mysqli_real_escape_string($con,$_POST['title']);
	$status=mysqli_real_escape_string($con,$_POST['status']);
	$time=mysqli_real_escape_string($con,$_POST['time']);
	$date=mysqli_real_escape_string($con,$_POST['date']);
	if($status=="Draft" and $time=="" and $date==""){
		$date="";
		$time="";
	}else{
		if($status=="Publish" and $time=="" and $date==""){
		date_default_timezone_set('Asia/Kolkata');
		$date=date('j M Y');//j for day, M for 3 words of Month, Y for 4 digit of year
		$time=date('g:i:sa');//g=hour, i=min, s=second a=am,pm
		}
	}
	$content=mysqli_real_escape_string($con,$_POST['content']);
	$description=mysqli_real_escape_string($con,$_POST['description']);
	$category="";
	if(isset($_POST['category'])){
		for($i=0;$i<count($_POST['category']);$i++){
			if($i==count($_POST['category'])-1){
				$category.=$_POST['category'][$i];
			}else{
				$category.=$_POST['category'][$i].",";
			}
		}
	}
	$sub_category="";
	if(isset($_POST['sub_category'])){
		for($i=0;$i<count($_POST['sub_category']);$i++){
			if($i==count($_POST['sub_category'])-1){
				$sub_category.=$_POST['sub_category'][$i];
			}else{
				$sub_category.=$_POST['sub_category'][$i].",";
			}
		}
	}
	$thumbnail_status=true;
	if($_FILES['thumbnail']['name']!=''){
		$thumbnail=$_FILES['thumbnail']['name'];
		$extension=pathinfo($thumbnail,PATHINFO_EXTENSION);
		
		if($extension=="png" ||$extension=="jpeg" ||$extension=="jpg" ||$extension=="PNG" ||$extension=="JPG" ||$extension=="JPEG" ){
			if($_FILES["thumbnail"]["size"]<=2097152){
				$thumbnail=explode('.',$thumbnail);
				$thumbnail=$thumbnail[0];
				$thumbnail.="_blogiez_".rand().".".$extension;
			}
			else{
				$thumbnail_status=false;
				$msg1="<span class='text-danger float-right'>**Thumbnail Photo size exceeded 2mb</span>";
			}
		}else{
			$thumbnail_status=false;
			$msg1="<span class='text-danger float-right'>**Format of Thumbnail Photo is wrong.</span>";
		}
		
		$thumbnail_tmp=$_FILES['thumbnail']['tmp_name'];
		$old_thumbnail=$_POST['old_thumbnail'];
	}else{
		$thumbnail=$_POST['old_thumbnail'];
	}
	if($thumbnail_status==true){
	$q18="update post set title='$title', content='$content', category_id='$category', sub_category_id='$sub_category', thumbnail='$thumbnail',status='$status',time='$time',date='$date', description='$description' where id='$id'";
	$run18=mysqli_query($con,$q18);
	}else{
		$run18=false;
	}
	if($run18){
		if($_FILES['thumbnail']['name']!=''){
			if($old_thumbnail!="not_available.png"){
				unlink("image/thumbnail/$old_thumbnail");
			}
			move_uploaded_file($thumbnail_tmp, "image/thumbnail/".$thumbnail);
		}
		$msg="<span class='text-success float-right'>Post Updated Successfully</span>";
	}else{
		$msg="<span class='text-danger float-right'>**Post Not Updated </span>";
	}
}
//fetching the detail of the post to show it in input boxes
if(isset($_GET['id'])){
	$id=mysqli_real_escape_string($con,$_GET['id']);
	$q17="select * from post where id='$id'";
	$run17=mysqli_query($con,$q17);
	$row17=mysqli_fetch_array($run17);
	$all_category=explode(",",$row17['category_id']);
	$all_sub_category=explode(",",$row17['sub_category_id']);
}
if($_SESSION['id']!=$row17['user_id']){
	echo"<script> location.href='<?php echo$url; ?>/php/blog/third/profile'; </script>";
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,intial-scale=1.0">
<title><?php echo$title; ?></title>
<link href="image/logo/blogiez_logo.jpg" type="image" rel="icon">
<!-- Bootstrap 4 -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!-- custom css -->
<link href="css/custom.css" rel="stylesheet">
<!-- chosen css -->
<link href="css/chosen.css" rel="stylesheet">
<!-- summernote -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
</head>
<body>
<?php
include_once("include/navbar.php");
?>
<div class="container-fluid"><!-- main container of the page  start-->
<div class="container add-post-container" style="margin-top:56px">
<h3 class="text-center text-primary">Update Your Post</h3>
<div class="row">
<div class="col-12 bg-white mb-5 p-3 shadow rounded">
<?php
if(isset($msg)){echo$msg;}
if(isset($msg1)){echo"</br>".$msg1;}
?>
<form action="" method="post" enctype="multipart/form-data">
<input type="hidden"  value="<?php echo$row17['id']; ?>" name="id">
<input type="hidden"  value="<?php echo$row17['time']; ?>" name="time">
<input type="hidden"  value="<?php echo$row17['date']; ?>" name="date">
<div class="form-group">
Title
<input type="text" name="title" value="<?php echo$row17['title']; ?>" class="form-control" placeholder="Enter the Title of the Blog">
</div>
<div class="form-group">
<input type="hidden"  value="<?php echo$row17['thumbnail']; ?>" name="old_thumbnail">
<label class="btn btn-secondary">Thumbnail
<input type="file" name="thumbnail" class="d-none"></label><span class="text-danger">**Must Upload Thumbnail of width 1280px and height 720px</span>
</div>
<div class="form-group">
Description
<textarea name="description" id="description" class="form-control" placeholder="Describe Your Blog"><?php echo$row17['description']; ?></textarea>
</div>
<div class="form-group">
Content
<textarea name="content" id="summernote" class=""> <?php echo$row17['content']; ?> </textarea>
</div>
<div class="form-group">
Category
<select id="category" name="category[]" multiple class="form-control">
<?php
$q35="select * from category order by category";
$run35=mysqli_query($con,$q35);
while($row35=mysqli_fetch_array($run35)){
	?>
	<option value='<?php echo$row35['id'];?>' <?php foreach($all_category as $cat){if($cat==$row35['id']){echo"selected";}} ?>><?php echo$row35['category'];?> </option>
	<?php
}
?>
</select>
</div>
<div class="form-group">
Sub Category
<select id="sub_category" name="sub_category[]" multiple class="form-control">
<?php
$q50="select * from sub_category order by sub_category";
$run50=mysqli_query($con,$q50);
while($row50=mysqli_fetch_array($run50)){
	?>
	<option value="<?php echo$row50['id'];?>" <?php foreach($all_sub_category as $cat){if($cat==$row50['id']){echo"selected";}} ?>><?php echo$row50['sub_category']?></option>
	<?php
}
?>
</select>
</div>
<div class="form-group">
<select name="status" class="form-control">
Status
<option <?php if($row17['status']=="Publish"){echo"selected";}?>>Publish</option>
<option <?php if($row17['status']=="Draft"){echo"selected";}?>>Draft</option>
</select>
</div>
<div class="form-group">
<input type="submit" name="sub18" class="btn btn-primary btn-block" value="Update Blog">
</div>
</form>
</div>
</div>
</div>
</div><!-- main container of the page  end-->
<!-- footer start -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="js/chosen.jquery.js"></script>
<script src="https://kit.fontawesome.com/5d2911aa89.js" crossorigin="anonymous"></script>
<script>
jQuery.noConflict();
jQuery(document).ready(function($){
	$("#category").chosen();
	$("#sub_category").chosen();
$('#summernote').summernote({
	placeholder: 'Write you content here...',
	height: 350,
	callbacks: {
		onImageUpload: function(files) {
			for(let i=0; i < files.length; i++) {
				$.upload(files[i]);
			}
		}
	},
  });  
$.upload = function (file) {
	let out = new FormData();
	out.append('file', file, file.name);
	$.ajax({
		method: 'POST',
		url: 'upload.php',
		contentType: false,
		cache: false,
		processData: false,
		data: out,
		success: function (img) {
			$('#summernote').summernote('insertImage', img);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.error(textStatus + " " + errorThrown);
		}
	});
};

/*
$('#summernote').summernote({
	placeholder: 'Hello Bootstrap 4',
	height: 400,
	callbacks: {
		onImageUpload : function(files, editor, welEditable) {
			for(var i = files.length - 1; i >= 0; i--) {
				sendFile(files[i], this);
				}
			}	
		}
});
function sendFile(file, el) {
var form_data = new FormData();
form_data.append('file', file);
$.ajax({
    data: form_data,
    type: "POST",
    url: 'editor-upload.php',
    cache: false,
    contentType: false,
    processData: false,
    success: function(url) {
        $(el).summernote('editor.insertImage', url);
    }
});
}
*/
});
</script>
</body>
</html>