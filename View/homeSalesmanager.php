<?php $title = 'Home';
$css = "";// "View/loginStyle.css";
require_once('Model/dbAccess.php');

ob_start(); ?>
<!--
<div class="wrapper">
	<div class="list-group">
		<a href="Home/users" class="list-group-item list-group-item-action">List of users</a>
		<a href="#" class="list-group-item list-group-item-action">Materials list</a>
		<a href="#" class="list-group-item list-group-item-action">Logout</a>
	</div>
</div>
-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<div class="container">
	<br />
	<h2 style="text-align: center">Sales Manager</h2>
	<br><br>
	<?php /*require_once("tabs.php");*/ ?>
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a href="#users" class="nav-link active" data-toggle="tab">Stocks</a>
		</li>
		<li class="nav-item">
			<a href="#products" class="nav-link" data-toggle="tab">Products details</a>
		</li>
		<li class="nav-item">
			<a href="#orders" class="nav-link" data-toggle="tab">Orders list</a>
		</li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane fade show active" id="users">
			<br /><br />
			<table class="table table-hover">
				<thead class="table-primary">
					<tr>
						<th scope="col">Nom du produit</th>
						<th scope="col">Quantité</th>
					</tr>
				</thead>
				<tbody>
					<?= stockTable(); ?>
				</tbody>
			</table>
		</div>
		<div class="tab-pane fade" id="products">
			<br /><br />
			<table class="table table-hover">
				<thead class="table-primary">
					<tr>
						<th scope="col">Produit</th>
						<th scope="col">Prix d'achat (€)</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?= productTable(); ?>
				</tbody>
			</table>
			<input class="btn btn-outline-primary my-2 my-sm-0 form-inline my-2 my-lg-0" type="submit" value="New product" onclick="window.location='Home/addProduct';" />
		</div>
		<div class="tab-pane fade" id="orders">
		<br /><br />
			<table class="table table-hover">
				<thead class="table-primary">
					<tr>
						<th scope="col">Order id</th>
						<th scope="col">Product</th>
						<th scope="col">Quantity</th>
						<th scope="col">Status</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?= orderTable(); ?>
				</tbody>
			</table>
			<input class="btn btn-outline-primary my-2 my-sm-0 form-inline my-2 my-lg-0" type="submit" value="Order product" onclick="window.location='Home/orderProduct';" />
		</div>
	</div>



	<?php $content = ob_get_clean();

	function stockTable()
	{
		require_once('Model/Auth.php');
		if (!isset($resultUsers) || empty($resultUsers)) {
			$resultUsers = (new Auth())->getStock();
		}
		$product_html = '';
		while ($row = $resultUsers->fetch()) {
			$product_html .= '<tr>';
			$product_html .= '<td>' . $row["name"] . '</td>';
			$product_html .= '<td>' .  $row["quantity"] . '</td>';
			$product_html .= '</tr>';
		}
		return $product_html;
	}

	function orderTable()
	{
		require_once('Model/Auth.php');
		$auth = new Auth();
		if (!isset($resultUsers) || empty($resultUsers)) {
			$resultOrders = $auth->getOrdersList();
		}
		$product_html = '';
		while ($row = $resultOrders->fetch()) {
			$product_html .= '<tr id="' . $row["id"] . '">';
			$product_html .= '<form method="POST" action="Home/ValidateOrder"><td><input type="hidden" value="'. $row["id"] .'" name ="orderId" id="orderId">' . $row["id"] . '</span></td>';
			$product_html .= '<td>' . $auth->getProduct($row["product_id"])["name"] . '</td>';
			$product_html .= '<td>' . $row["quantity"] . '</td>';
			$product_html .= '<td>' . $row["status"] . '</td>';
			$product_html .= ($row["status"] == "En attente de validation") ? '<td><button title="Validate order" type="submit" class="btn btn-default btn-sm"><i class="fa fa-check-circle fa-lg"></i></button></td></form>' : '<td></td></form>';
			$product_html .= '</tr>';
		}	
		return $product_html;
	}

	function productTable()
	{
		require_once('Model/Auth.php');
		if (!isset($resultUsers) || empty($resultUsers)) {
			$resultProducts = (new Auth())->getProductsList();
		}
		$product_html = '';
		while ($row = $resultProducts->fetch()) {
			$product_html .= '<tr id="' . $row["id"] . '">';
			$product_html .= '<form method="POST" action="Home/ChangeProductPrice"><td><input type="hidden" value="'. $row["name"] .'" name ="productName" id="productName">' . $row["name"] . '</span></td>';
			$product_html .= '<td><input min="1" step="0.01" class="form-control" type="number" id="price" name="price" required value="' .  $row["price"] . '"/></td>';
			$product_html .= '<td><button class="btn btn-outline-primary my-2 my-sm-0 form-inline my-2 my-lg-0" type="submit" >Sauvegarder</button></td></form>';
			$product_html .= '</tr>';
		}
		return $product_html;
	}


	require('View/template.php'); ?>
