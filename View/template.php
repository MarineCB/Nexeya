<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href=<?= $css ?> media="screen">
		<link rel="stylesheet" type="text/css" href="global.css" media="screen">
		<link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet"  type='text/css'>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<title><?= $title ?></title>
	</head>

	<body>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li style="margin-right:10px;" class="nav-item">
						<a class="nav-link" href="#" onclick="window.location='Home';"><i class="fa fa-home"></i>  Home</a>
					</li>
					<li style="margin-right:10px;" class="nav-item">
						<a class="nav-link" href="#" onclick="window.location='Profile';"><i class="fa fa-user"></i>  Profile</a>
					</li>


				</ul>
				
				<a href="Login"><input class="btn btn-outline-secondary my-2 my-sm-0 form-inline my-2 my-lg-0" type="submit" value="Logout"></a>

			</div>
		</nav>

		<?= $content; ?>
		<br/>
	</body>
</html>