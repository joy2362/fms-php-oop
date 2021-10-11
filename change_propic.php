<?php

use lib\userManagement\userManagement;

include_once (__DIR__. "/config.php");
include_once (__DIR__. "/lib/userManagement/userManagement.php");

//read user information from database
$userInfo = userManagement::userInfo();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width , initial-scale=1">
	<title><?php echo App_name ; ?> | Update</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/f717478b5d.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Atomic+Age|Eagle+Lake|Fjalla+One|Merriweather|Orbitron&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/signup_in.css">
</head>
<body>
	<div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 name_head" >
                <a href="index.php"><h2 class="float-left some"><?php echo App_name;?></h2></a>
                <p class="float-right ">Keep your file safe</p>
            </div>
        </div>
	</div>
	<nav class="navbar navbar-expand-sm navbar-dark bg-dark sticky-top ">
		<a href="#" class="navbar-brand">
			<img src="img/img1.jpg" style="width: 50px; height: 25px;">
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsenav">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="collapsenav">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a href="index.php" class="nav-link active">Home</a>
				</li>
				<li class="nav-item">
					<div class="dropdown">
						<button class="btn btn-dark dropdown-toggle" data-toggle="dropdown"><?php echo $userInfo['name']; ?></button>
						<div class="dropdown-menu">
							<a href="change_propic.php" class="dropdown-item">Update Profile Pictute</a>
							<a href="change.php" class="dropdown-item">Change password</a>
							<a href="delete.php" class="dropdown-item">Delete profile</a>
							<a href="logout.php" class="dropdown-item">log out</a>
						</div>
					</div>
				</li>
				<li class="nav-item">
					<a href="upload.php" class="nav-link ">upload</a>
				</li>
				<li class="nav-item">
					<a href="about.php" class="nav-link">About us</a>
				</li>
			</ul>
		</div>
	</nav>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-4"></div>
				<div class="col-sm-4 signup_css">
					<h2 class="text-center" style="font-family: 'Atomic Age', cursive;">Change</h2>
                    <?php
                    if (isset($_SESSION['error'])){
                        ?>
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Error!</strong> <?php echo $_SESSION['error'];  unset($_SESSION['error']);?>
                        </div>
                        <?php
                    }
                    ?>
						<form action="confirm.php" method="POST" enctype="multipart/form-data">

							<div class="custom-file mb-3">
     	 						<input type="file" class="custom-file-input" id="customFile" name="fileup" accept="image/*">
     							 <label class="custom-file-label" for="customFile">Choose image</label>
   							 </div>
							<input type="Submit" class="btn btn-outline-secondary" name="changeprofileImage" value="Change">
						</form>
				
			<div class="col-sm-4"></div>
		</div>
	</div>
	<script>
		$(".custom-file-input").on("change", function() {
  		var fileName = $(this).val().split("\\").pop();
  		$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
		});
	</script>
        <footer id="footer" class="bg-dark fixed-bottom">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <p class="text-primary">Copyright &copy;2019 All right reserved by <?php echo App_name;?> </p>
                    </div>
                    <div class="col-sm-4"></div>
                </div>
            </div>
        </footer>
</body>
</html>