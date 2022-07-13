<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta name="description" content="Panel Radio" />
		<meta name="author" content="IoNuT" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title><?php echo TitleSite; ?> - <?php echo $title ?></title>
		<link rel="stylesheet" href="/slim/slim.css">
		<link rel="stylesheet" href="/slim/slim.one.css">
		<link href="/slim/lib/Ionicons/css/ionicons.css" rel="stylesheet">
		<link href="/slim/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	</head>
	<body>
		<div class="slim-header">
			<div class="container">
				<div class="slim-header-left">
					<h2 class="slim-logo"><a href="/">Radio<span>Panel</span></a></h2>
				</div>
				<div class="slim-header-right">
					<div class="dropdown dropdown-c">
						<a href="/" class="logged-user" data-toggle="dropdown">
							<img height="32" width="32" src="/files/img2.jpg" alt="avatar">
							<span class="group-admin"> <?php echo $user->get()->user; ?></span>
						</a>
					</div>
					<div class="dropdown dropdown-c">
						<a href="/logout" class="logged-user" data-toggle="dropdown">
							<span class="group-admin"> Logout</span>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="slim-navbar">
			<div class="container">
				<ul class="nav">
					<li class="nav-item">
						<a class="nav-link" href="/">
							<i class="icon ion-ios-home-outline"></i>
							<span>Home</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/autodj">
							<i class="icon ion-ios-gear-outline"></i>
							<span>AutoDJ</span>
						</a>
					</li>
					<?php if ($user->get()->rank == 1){ ?>
						<li class="nav-item with-sub">
							<a class="nav-link" href="#" data-toggle="dropdown">
								<i class="icon ion-ios-gear-outline"></i>
								<span>Settings</span>
							</a>
							<div class="sub-item">
								<ul>
									<li><a href="/AllServers">Servere Config</a></li>
									<li><a href="/Users">Users</a></li>
									<li><a href="/NewUsers">NewUsers</a></li>
									<li><a href="/Settings">Panel Settigns</a></li>
								</ul>
							</div>
						</li>
					<?php } ?>
					<li class="nav-item">
						<a class="nav-link" href="/Server">
							<i class="icon ion-ios-chatboxes-outline"></i>
							<span>Server Radio</span>
							<span class="square-8"></span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/ticket">
							<i class="icon ion-ios-chatboxes-outline"></i>
							<span>Ticket</span>
							<span class="square-8"></span>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="slim-mainpanel">
			<div class="container">
				<div class="slim-pageheader">
					<ol class="breadcrumb slim-breadcrumb"></ol>
					<h6 class="slim-pagetitle"><?php echo $title ?></h6>
				</div>
				<?php echo $html; ?>
			</div>
		</div>
		<div class="slim-footer">
			<div class="container">
				<p>Copyright <?php echo date('Y')?> &copy; All Rights Reserved. Radio Panel</p>
				<p>Designed by: <a href="">IoNuT</a></p>
			</div>
		</div>
	</body>
</html>