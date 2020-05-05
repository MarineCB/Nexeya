<?php $title = 'Connection';
$css = "View/loginStyle.css";
require_once('Model/dbAccess.php');

ob_start();?>
<div class="wrapper">
	<form class="form-signin" method="POST" action="Login/ConnectionAttempt">
		<h2 class="form-signin-heading text-center">Login :</h2>
		<input  class="form-control"type="text" placeholder="login" name="login" id="login" pattern="^[a-zA-Z0-9.@]*$" title="Username can not contain special characters" required/><br/>
		<!--<label for="password">Password :</label>-->
		<input class="form-control" type="password" placeholder="password" name="password" id="password" required/><br/>
		<input class="btn btn-primary btn-block" type="submit" name="connectForm" value="Login"/>
	</form>
</div>


<?php $content = ob_get_clean();

require('View/template.php'); ?>