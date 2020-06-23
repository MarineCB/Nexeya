<?php $title = 'My Profile';
$css = "View/loginStyle.css";
require_once('Model/dbAccess.php');
require_once('utils.php');

ob_start(); ?>
	<br/>
	<h2 style="text-align: center">My Profile</h2>
	<form class="container" method="POST" action="">
		<div class="form-group">
			<label for="readonlyUsername">Your username</label>
			<input type="text" value=<?=$_SESSION['login']?> class="form-control" name="readonlyUsername" id="readonlyUsername" placeholder="Enter product name" readonly>
		</div>
		<div class="form-group">
			<label for="inputPassword1">Old password</label>
			<input type="password" class="form-control" name="inputPassword1" id="inputPassword1" placeholder="Password" required>
		</div>
		<div class="form-group">
			<label for="inputPassword2">New password</label>
			<input type="password" class="form-control" name="inputPassword2" id="inputPassword2" placeholder="Password" required>
		</div>
		<br/>
		<br/>
		<button type="submit" class="btn btn-primary">Change password</button>
	</form>

<?php $content = ob_get_clean();

require('View/template.php'); ?>
