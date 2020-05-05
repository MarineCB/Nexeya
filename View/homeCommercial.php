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
	<h2 style="text-align: center">Commercial</h2>
	<br><br>
	<?php /*require_once("tabs.php");*/ ?>
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a href="#users" class="nav-link active" data-toggle="tab">Stocks</a>
		</li>
		<li class="nav-item">
			<a href="#products" class="nav-link" data-toggle="tab">Détails des produits</a>
		</li>
		<li class="nav-item">
			<a href="#orders" class="nav-link" data-toggle="tab">Passer commande</a>
		</li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane fade show active" id="users">
			<br /><br />
			<table class="table table-hover">
				<thead class="thead-dark">
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
				<thead class="thead-dark">
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
		</div>
		<div class="tab-pane fade" id="orders">
		<br /><br />
			<table class="table table-hover">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Order id</th>
						<th scope="col">Status</th>
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
		if (!isset($resultUsers) || empty($resultUsers)) {
			$resultProducts = (new Auth())->getOrdersList();
		}
		$product_html = '';
		while ($row = $resultProducts->fetch()) {
			$product_html .= '<tr id="' . $row["id"] . '">';
			$product_html .= '<td>' . $row["id"] . '</td>';
			$product_html .= '<td>' . $row["status"] . '</td>';
			$product_html .= '</tr>';
		} // href="DeleteUser"  pour le bouton suppression d'un userr -> passage par le controller
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
			$product_html .= '<form><td name ="productName" id="productName">' . $row["name"] . '</td>';
			$product_html .= '<td><input type="number" id="price" name="price" required value="' .  $row["price"] . '"/></td>';
			$product_html .= '<td><button type="submit" formaction="Home/ChangeProductPrice">Sauvegarder</button></td></form>';
			$product_html .= '</tr>';
		} // href="DeleteUser"  pour le bouton suppression d'un userr -> passage par le controller
		return $product_html;
	}


	require('View/template.php'); ?>
	<script>
		function deleteUser(row) {
			console.log(row.id)
			if (confirm('Do you want to delete the user ' + row.id)) {
				$.ajax({
					url: 'Home/deleteUser',
					type: 'POST',
					data: {
						usernameToDel: row.id
					},
					success: function(data) {
						console.log(data)
						location.reload()
					}
				});
			}
		}
	</script>
