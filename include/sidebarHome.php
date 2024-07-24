<form class="shadow px-3 pt-3 pb-1 mb-3 rounded" action='<?php echo$url; ?>' method="post">
<div class="form-group">
<input type="text" class="form-control" name="search" placeholder="Search blog..." required>
</div>
<div class="form-group">
<input type="submit" class="btn btn-muted" name="sub47" value="Search">
</div>
</form>
<div class="shadow bg-white rounded p-3 mb-3">
<a href="app/Blogiez.apk" download class="btn btn-primary btn-block shadow download_app"><i class="fab fa-android"></i> Download Blogiez App</a>
</div>
<div class="shadow bg-white rounded p-3">
<h4 class="text-primary heading">Blog Category</h4>
<ul class="list-unstyled">
<?php 
//fetching category
$q46="select * from category order by id desc";
$run46=mysqli_query($con,$q46);
while($row46=mysqli_fetch_array($run46)){
	?>
	<a href="<?php echo$url; ?>/cat/<?php echo $row46['id']; ?>">
	<li class=""><?php echo $row46['category']; ?></li></a>
	<?php
}
?>
</ul>
</div>