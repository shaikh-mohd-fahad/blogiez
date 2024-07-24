<?php
include_once("conn.php");
if(isset($_POST['del_id'])){
$del_id=$_POST['del_id'];
$q19="delete from post where id='$del_id'";
$run19=mysqli_query($con,$q19);
if($run19){
	echo"true";
}else{
	echo"false";
}
}
?>