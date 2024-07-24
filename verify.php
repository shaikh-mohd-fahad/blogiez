<?php
$title="Email Verification";
$page="";
include_once('include/header.php');
include_once('include/navbar.php');
?>
<div class="container">
    <?php 
    if(isset($_GET['id'])){
    $verification_id=mysqli_real_escape_string($con,$_GET['id']);
    $verification_id=htmlentities($verification_id);
    $q52="update user set verify_status='1' where verification_id='$verification_id'";
    $run52=mysqli_query($con,$q52);
    if($run52){
      //  echo"account verification query run";
            $q53="select * from user where verification_id='$verification_id'";
            $run53=mysqli_query($con,$q53);
            $row53=mysqli_fetch_array($run53);
        	setCookie("id",$row53['id'],time()+60*60*24*365);
			setCookie("username",$row53['username'],time()+60*60*24*365);
			//echo"account verified";
		echo"<script> location.href='$url/user/profile';</script>";
    }
    }else{
        echo"<script> location.href='$url';</script>";
    }
   // echo"<br><br><br>".$q52;
    ?>
</div>
<!-- footer start -->
<?php
include_once("include/footer.php");
?>