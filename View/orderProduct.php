<?php $title = 'Order product';
$css = "View/global.css";
require_once('Model/dbAccess.php');

ob_start(); ?>
	<br/>
	<h2 style="text-align: center">Order</h2>
	<form class="container" method="POST" action="">
		<label for="inputProduct">Product</label>
		<select class="form-control" name="inputProduct" id="inputProduct">
			<?= orderTable(); ?>
		</select>
		<br/>
		<div class="form-group">
			<label for="inputQuantity">Quantity</label>
			<input type="number" min="1" class="form-control" name="inputQuantity" id="inputQuantity" placeholder="Quantity" required>
		</div>
		<br/>
		<br/>
		<button type="submit" class="btn btn-primary">Submit</button>
	</form>
	<br/>

<?php $content = ob_get_clean();

require('View/template.php');

function orderTable()
	{
		require_once('Model/Auth.php');
		if (!isset($resultUsers) || empty($resultUsers)) {
			$resultProducts = (new Auth())->getProductsList();
		}
		$product_html = '';
		while ($row = $resultProducts->fetch()) {
			$product_html .= '<option value="'.$row["id"].'" label="'.$row["name"].'"></option>';
		}
		return $product_html;
	}



