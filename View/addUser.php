<?php $title = 'Add User';
$css = "View/global.css";
require_once('Model/dbAccess.php');

ob_start(); ?>
	<br/>
	<h2 style="text-align: center">User's information</h2>
	<form class="container" method="POST" action="">
		<div class="form-group">
			<label for="inputUsername">Username</label>
			<input type="text" class="form-control" name="inputUsername" id="inputUsername" placeholder="Enter username" required>
		</div>
		<div class="form-group">
			<label for="inputPassword1">Password</label>
			<input type="password" class="form-control" name="inputPassword1" id="inputPassword1" placeholder="Password" required>
		</div>
		<div class="form-group">
			<label for="inputPassword2">Password verification</label>
			<input type="password" class="form-control" name="inputPassword2" id="inputPassword2" placeholder="Password" required>
		</div>

		<label for="inputStatus">Status</label>
		<select class="form-control" name="inputStatus" id="inputStatus">
			  <option value="admin" label="Administrator"></option>
			  <option value="responsable-commercial" label="Sales manager"></option>
			  <option value="commercial" label="Salesman"></option>
			  <option value="meca" label="Meca"></option>
			  <option value="autres" label="Other"></option>
		</select>
		<br/>
		<br/>
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>

<?php $content = ob_get_clean();

require('View/template.php'); ?>

<script>
	var password = document.getElementById("inputPassword1")
  , confirm_password = document.getElementById("inputPassword2");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>