<?php $title = 'Connection';
$css = "View/loginStyle.css";
require_once('Model/dbAccess.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href=<?= $css ?> media="screen">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<title><?= $title ?></title>
	</head>

	<body>
		<div class="wrapper">
			<form class="form-signin" method="POST" action="Login/ConnectionAttempt">
				<h2 class="form-signin-heading text-center">Login :</h2>
				<input  class="form-control"type="text" placeholder="login" name="login" id="login" pattern="^[a-zA-Z0-9.@]*$" title="Username can not contain special characters" required/><br/>
				<input class="form-control" type="password" placeholder="password" name="password" id="password" required/><br/>
				<input class="btn btn-primary btn-block" type="submit" name="connectForm" value="Login"/>
			</form>
		</div>
	</body>
</html>

<?php