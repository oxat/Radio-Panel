<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta name="description" content="Radio Panel v2 no licente" />
		<meta name="author" content="Ionut" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />

		<title><?php echo $title; ?></title>

		<link href="/slim/Ionicons/css/ionicons.css" rel="stylesheet">
		<link href="/slim/lib/font-awesome/css/font-awesome.css" rel="stylesheet">

		<!-- Slim CSS -->
		<link rel="stylesheet" href="/slim/slim.css">
		<link rel="stylesheet" href="/slim/slim.one.css">
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	</head>
<body>
	<div class="wrapper-page">
		<div class="signin-wrapper">
			<div class="signin-box">
				<h2 class="slim-logo"><a href="/">Radio<span> Panel</span></a></h2>
				<h2 class="signin-title-primary">Welcome back!</h2>
				<h3 class="signin-title-secondary">Log in to continue.</h3>
				<form method="POST">
					<div class="form-group row">
						<div class="col-12">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">
										<i class="icon ion-person"></i>
									</span>
								</div>
								<input class="form-control" type="text" name="user" required="" placeholder="Name" value="" autofocus>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-12">
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">
										<i class="icon ion-key"></i>
									</span>
								</div>
								<input class="form-control" type="password" name="pass" required="" placeholder="Password">
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-12">
							<div class="checkbox checkbox-primary">
								<input id="checkbox-signup" name="remember" type="checkbox" >
								<label for="checkbox-signup">
									Remember me
								</label>
							</div>
						</div>
					</div>
					<?php \App::inputCSRF(); ?>
					<div class="form-group text-right m-t-20">
						<div class="col-xs-12">
							<button class="btn btn-primary btn-block btn-signin">Log In</button>
						</div>
					</div>
					<div class="form-group row m-t-30">
						<div class="col-sm-7">
							<a href="/reset" class="text-muted"><i class="fa fa-lock m-r-5"></i> Forgot your
								password?</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php
	if($message){
		if($message['success']){
			echo '<script type="text/javascript">
					swal("", "'.$message['success'].'", "success");
				</script>';
		}
		if($message['error']){
			echo '<script type="text/javascript">
					swal("", "'.$message['error'].'", "error");
				</script>';
		}
	}
?>
</body>
</html>