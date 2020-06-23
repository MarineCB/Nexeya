<?php $title = 'New Product';
$css = "View/global.css";
require_once('Model/dbAccess.php');

ob_start(); ?>
	<br/>
	<h2 style="text-align: center">Product's information</h2>
	<form class="container" method="POST" action="">
		<div class="form-group">
			<label for="inputProductname">Name</label>
			<input type="text" class="form-control" name="inputProductname" id="inputProductname" placeholder="Enter product name" required>
		</div>
		<div class="form-group">
			<label for="inputProductPrice">Price</label>
			<input type="number" min="0" class="form-control" name="inputProductPrice" id="inputProductPrice" placeholder="Price of the product" required step="0.01">
		</div>
		<div class="form-group">
			<label for="inputProductQuantity">Quantity</label>
			<input type="number" min="0" value ="0" class="form-control" name="inputProductQuantity" id="inputProductQuantity" placeholder="Quantity in stocks">
		</div>
		<br/>
		<br/>
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>

<?php $content = ob_get_clean();

require('View/template.php'); ?>
