<?php $title = 'Home';
$css = "View/loginStyle.css";
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
	<h2 style="text-align: center">Administrator</h2>
	<br><br>
	<?php /*require_once("tabs.php");*/ ?>
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a href="#users" class="nav-link active" data-toggle="tab">Users</a>
		</li>
		<li class="nav-item">
			<a href="#stock" class="nav-link" data-toggle="tab">Stocks</a>
		</li>
		<li class="nav-item">
			<a href="#products" class="nav-link" data-toggle="tab">Product</a>
		</li>
		<li class="nav-item">
			<a href="#orders" class="nav-link" data-toggle="tab">Orders</a>
		</li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane fade show active" id="users">
			<br /><br />
			<table class="table table-hover">
				<thead class="table-primary">
					<tr>
						<th scope="col">Username</th>
						<th scope="col">Status</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?= userTable(); ?>
				</tbody>
			</table><br/><br/>
			<input class="btn btn-outline-primary my-2 my-sm-0 form-inline my-2 my-lg-0" type="submit" value="Add a user" onclick="window.location='Home/addUser';" />
		</div>
		<div class="tab-pane fade show" id="stock">
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
						<th scope="col">Name</th>
						<th scope="col">Quantity</th>
						<th scope="col">Price (€)</th>
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

	function userTable()
	{
		require_once('Model/Auth.php');
		if (!isset($resultUsers) || empty($resultUsers)) {
			$resultUsers = (new Auth())->getUsersList();
		}
		$product_html = '';
		while ($row = $resultUsers->fetch()) {
			$product_html .= '<tr>';
			$product_html .= '<form onSubmit="return confirm(\'Do you really want delete this user?\');" method="POST" action="Home/deleteUser"><td><input type="hidden" value="'. $row["id"] .'" name ="userId" id="userId">' . $row["username"] . '</td>';
			$product_html .= '<td>' .  $row["user_type"] . '</td>';
			$product_html .= '<td><button title="Delete user" type="submit" class="btn btn-default btn-sm"><i class="fa fa-trash fa-lg blackiconcolor"></i></button></td></form>';
			$product_html .= '</tr>';
			
		} // href="DeleteUser"  pour le bouton suppression d'un userr -> passage par le controller
		return $product_html;
	}

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
			$product_html .= '<td>' . $row["id"] . '</span></td>';
			$product_html .= '<td>' . $auth->getProduct($row["product_id"])["name"] . '</td>';
			$product_html .= '<td>' . $row["quantity"] . '</td>';
			$product_html .= '<td>' . $row["status"] . '</td>';
			if($row['status'] == "En attente de validation"){
				$product_html .= '<form method="POST" action="Home/ValidateOrder"><input type="hidden" value="'. $row["id"] .'" name ="orderId" id="orderId"></span></td><td><button title="Validate order" type="submit" class="btn btn-default btn-sm"><i class="fa fa-check-circle fa-lg"></i></button></td></form>';
			}else if($row["status"] == "Commandé"){
				$product_html .='<form method="POST" action="Home/OrderDelivered"></span></td><td><button title="confirm delivery" type="submit" class="btn btn-default btn-sm"><input type="hidden" value="'. $row["id"] .'" name ="orderIdDeliv" id="orderIdDeliv"><i class="fa fa-check-circle fa-lg"></i></button></td></form>';
			}else 
				$product_html .='<td></td>';
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
