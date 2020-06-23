<?php $title = 'Home';
$css = "";// "View/loginStyle.css";
require_once('Model/dbAccess.php');

ob_start(); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<div class="container">
	<br />
	<h2 style="text-align: center">Meca</h2>
	<br><br>
	<?php /*require_once("tabs.php");*/ ?>
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a href="#stock" class="nav-link active" data-toggle="tab">Stocks</a>
		</li>
		<li class="nav-item">
			<a href="#orders" class="nav-link" data-toggle="tab">Orders list</a>
		</li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane fade show active" id="stock">
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
			$product_html .= '<form method="POST" action="Home/OrderDelivered"><td><input type="hidden" value="'. $row["id"] .'" name ="orderIdDeliv" id="orderIdDeliv">' . $row["id"] . '</span></td>';
			$product_html .= '<td>' . $auth->getProduct($row["product_id"])["name"] . '</td>';
			$product_html .= '<td>' . $row["quantity"] . '</td>';
			$product_html .= '<td>' . $row["status"] . '</td>';
			$product_html .= ($row["status"] == "Commandé") ? '<td><button title="confirm delivery" type="submit" class="btn btn-default btn-sm"><i class="fa fa-check-circle fa-lg"></i></button></td></form>' : '<td></td></form>';
			$product_html .= '</tr>';
		}
		return $product_html;
	}

	require('View/template.php'); ?>
