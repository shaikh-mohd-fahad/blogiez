<div class="navbar navbar-dark bg-primary navbar-expand-lg fixed-top"> <!-- navbar start -->
<div class="container" id="nav-container">
<?php 
if($page=="Home" || $page=="Post" || $page=="Following" || $page=="followlist" ){?>
<button class="navbar-toggler" id="opensidebar"><span class="navbar-toggler-icon"></span></button>
<?php
}?>
<a href="<?php echo$url; ?>" class="navbar-brand"><b><i>Blogiez</i></b></a>
<button class="navbar-toggler" data-toggle="collapse" data-target="#nclp1"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="nclp1"><!-- navbar collpase start -->
    <ul class="nav navbar-nav ml-auto">
    <li class="nav-item"><a href="<?php echo$url; ?>" class="nav-link <?php if(isset($page) && $page=='Home'){echo'active';} ?>"><i class="fa fa-home"></i>  Home</a></li>
    <li class="nav-item"><a href="<?php echo$url; ?>/following" class="nav-link  <?php if(isset($page) && $page=='Following'){echo'active';} ?>"><i class="fas fa-blog"></i>  Following</a></li>
    <li class="nav-item"><a href="<?php echo$url; ?>/user/<?php if(isset($_SESSION['username'])){echo$_SESSION['username'];}else{echo"profile";}?>" class="nav-link  <?php if(isset($page) && $page=='Profile'){echo'active';} ?>"><i class="fas fa-user"></i>  <?php if(isset($_SESSION['username'])){echo$_SESSION['username'];}else{echo'Profile';} ?></a></li>
    <li class="nav-item"><a href="app/Blogiez.apk" class="nav-link download_app" download><i class="fab fa-android"></i> Download Blogiez App</a></li>
    <li class="nav-item"><a href="" class="nav-link <?php if(isset($page) && $page=='Trending'){echo'active';} ?>"><i class="fas fa-poll"></i> Trending</a></li>
    <li class="nav-item">
    <?php if(!isset($_SESSION['id'])){?>
    <a href="<?php echo$url; ?>/login" class="nav-link <?php if(isset($page) && $page=='Login'){echo'active';} ?>"><i class='fas fa-sign-in-alt'></i> Log in</a>
    <?php }
    else{
    	?>
    <a href="logout" class="nav-link"><i class='fas fa-sign-in-alt'></i> Log out</a>
    <?php } ?>
    </li>
    </ul>
</div><!-- navbar collapse close -->
</div>
</div><!-- navbar close -->