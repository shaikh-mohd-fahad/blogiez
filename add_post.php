<?php
//checking if session id is started or not
if(session_id()==''){
	session_start();
}
if(isset($_COOKIE['id']) && isset($_COOKIE['username'])){
	$_SESSION['id']=$_COOKIE['id'];
	$_SESSION['username']=$_COOKIE['username'];
}
include_once("conn.php");//including conn.php file
//creating cookie for every unique visitor
if(!isset($_COOKIE['visiter'])){
setCookie('visiter','yes',time()+60*60*24*365);
mysqli_query($con,"update `visitor_counter` set count=count+1");
}
if(!isset($_SESSION['id'])){
echo"<script>location.href='<?php echo$url; ?>/php/blog/third/login';</script>";
}
$title="Add New Post";
$page="Profile";
echo"";
//inserting hyphen (-) in title for seo
function friendly_seo_string($vp_string){
	$vp_string = trim($vp_string);

	$vp_string = html_entity_decode($vp_string);

	$vp_string = strip_tags($vp_string);

	$vp_string = strtolower($vp_string);

	$vp_string = preg_replace('~[^ a-z0-9_.]~', ' ', $vp_string);

	$vp_string = preg_replace('~ ~', '-', $vp_string);

	$vp_string = preg_replace('~-+~', '-', $vp_string);
		
	return $vp_string;
}
//checking if entered title  for seo is already  present or not
function checking(){
	global $con;
	global $new_friendly_url;
	$row1=mysqli_query($con, "SELECT * FROM post WHERE url_friendly_title = '$new_friendly_url'");
	if(mysqli_num_rows($row1)>0){
		return true;
	}
	else{
		return false;
	}
}
date_default_timezone_set('Asia/Kolkata');
$date=date('j M Y');//j for day, M for 3 words of Month, Y for 4 digit of year
$time=date('g:i:sa');//g=hour, i=min, s=second a=am,pm
$id=$_SESSION['id'];
//inserting all post content
if(isset($_POST['sub6'])){
	$post_title=mysqli_real_escape_string($con,$_POST['post_title']);
	//seo friendly url
		#get seo friendly url from title using function
		$new_friendly_url = friendly_seo_string($_POST['post_title']);
		//if title is unique then counter=1
		$counter = 1;
		//copied $new_friendly_url to $intial_friendly_url to use it in re-naming of $new_friendly_url in while loop below
		$intial_friendly_url = $new_friendly_url;
		$checked=checking();
		while($checked){
			//if seo friendly url is already present in database then it will rename current title to title-2, title-3,... etc.
			$counter++;  
			$new_friendly_url = "$intial_friendly_url-$counter";
			$checked=checking();
		}
	//seo friendly url
	$content=mysqli_real_escape_string($con,$_POST['content']);
	$description=mysqli_real_escape_string($con,$_POST['description']);
	$status=mysqli_real_escape_string($con,$_POST['status']);
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
	if($_POST['status']=="Draft"){
		$date="";
		$time="";
	}
	$thumbnail_status=true;
	if($_FILES['thumbnail']['name']!=""){
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
	}else{
		$thumbnail="not_available.png";
		$thumbnail_tmp="";
	}
	if($thumbnail_status==true){
	$q6="insert into post(title,url_friendly_title, content, thumbnail, date, time, user_id, category_id, sub_category_id,status,description) values('$post_title', '$new_friendly_url', '$content', '$thumbnail', '$date', '$time', '$id', '$category','$sub_category','$status','$description')";
	$run6=mysqli_query($con,$q6);
	}else{
		$run6=false;
	}
	if($run6){
		move_uploaded_file($thumbnail_tmp, "image/thumbnail/".$thumbnail);
		$msg="<span class='text-success float-right'>Post Added Successfully</span>";
	}else{
		$msg="<span class='text-danger float-right'>**Post Not Added </span>";
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,intial-scale=1.0">
<title><?php echo$title; ?></title>
<link href="image/logo/blogiez_logo.jpg" type="image" rel="icon">
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
include_once('include/navbar.php');
?>
<div class="container-fluid"><!-- main container of the page  start-->
<div class="container add-post-container" style="margin-top:56px">
<h3 class="text-center text-primary">Add New Post</h3>
<div class="row">
<div class="col-12 bg-white mb-5 p-3 shadow rounded">
<?php
if(isset($msg)){echo$msg;}
if(isset($msg1)){echo"".$msg1;}
?>
<form action="" method="post" enctype="multipart/form-data">
<div class="form-group">
Title (<span class="text-danger">**Title help your blog to rank on google</span>)
<input type="text" name="post_title" value="<?php if(isset($post_title)){echo$post_title;} ?>" class="form-control" placeholder="Enter the Title of the Blog">
</div>
<div class="form-group">
<label class="btn btn-secondary">Thumbnail
<input type="file" name="thumbnail" class="d-none"></label> <span class="text-danger">**Must Upload Thumbnail of width 1280px and height 720px</span>
</div>
<div class="form-group">
Description
<textarea name="description" class="form-control" id="description" placeholder="Briefly describe your blog for SEO and Ranking on Google"><?php if(isset($description)){echo$description;} ?></textarea>
</div>
<div class="form-group">
Content<span class="text-danger">**After adding blog if you see image error don't worry image is uploaded successfully</span>
<textarea name="content" id="summernote"><?php if(isset($content)){echo$content;} ?></textarea>
</div>
<div class="form-group">
Category
<select id="category" name="category[]" class="form-control" multiple class="form-control">
<?php
$q35="select * from category order by id";
$run35=mysqli_query($con,$q35);
while($row35=mysqli_fetch_array($run35)){
	?>
	<option value="<?php echo$row35['id'];?>" ><?php echo$row35['category']; ?></option>
<?php
}
?>
</select>
</div>
<div class="form-group">
Sub Category
<select id="sub_category" class="form-control" name="sub_category[]" multiple class="form-control">
<?php
$q50="select * from sub_category order by id";
$run50=mysqli_query($con,$q50);
while($row50=mysqli_fetch_array($run50)){
	?>
<option value="<?php echo$row50['id']?>"> <?php echo$row50['sub_category'];?></option>
<?php
}
?>
</select>
</div>
<div class="form-group">
<select name="status" class="form-control">
Status
<option>Publish</option>
<option>Draft</option>
</select>
</div>
<div class="form-group">
<input type="submit" name="sub6" class="btn btn-primary btn-block" value="Add Blog">
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
	placeholder: 'Write your content here',
	height: 400,
	callbacks: {
		onImageUpload : function(files, editor, welEditable) {
			for(var i = files.length - 1; i >= 0; i--) {
				sendFile(files[i], this);
				}
			}	
		}
});

function sendFile(file, el){
var form_data = new FormData();
form_data.append('file', file);
$.ajax({
    data: form_data,
    type: "POST",
    url: 'editor-upload.php',
    cache: false,
    contentType: false,
    processData: false,
    success: function(url){
		alert("url= "+url);
        $(el).summernote('editor.insertImage', url);
    }
});
}*/
});
</script>
</body>
</html>