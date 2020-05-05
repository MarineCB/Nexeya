<?php
require_once("Model/Auth.php");
$conn = (new Auth())->getDb();
$category_sql = "SELECT id, name FROM categories LIMIT 10";
$resultset = mysqli_query($conn, $category_sql) or die("database error:" . mysqli_error($conn));
$active_class = 0;
$category_html = '';
$product_html = '';

while ($category = mysqli_fetch_assoc($resultset)) {
	$current_tab = "";
	$current_content = "";
	if (!$active_class) {
		$active_class = 1;
		$current_tab = 'active';
		$current_content = 'in active';
	}
	$category_html .= '<li class="' . $current_tab . '"><a href="#' . $category['id'] . '" data-toggle="tab">' .
		$category['name'] . '</a></li>';
	$product_html .= '<div id="' . $category["id"] . '" class="tab-pane fade ' . $current_content . '">';
	$product_sql = "SELECT id, p_name, p_image, price FROM category_products WHERE id = " . $category["id"];
	$product_results = mysqli_query($conn, $product_sql) or die("database error:" . mysqli_error($conn));
	if (!mysqli_num_rows($product_results)) {
		$product_html .= '<br>No product found!';
	}
	while ($product = mysqli_fetch_assoc($product_results)) {
		$product_html .= '<div class="col-md-3 product">';
		$product_html .= '<img src="images/' . $product["p_image"] . '" class="img-responsive img-thumbnail product_image" />';
		$product_html .= '<h4>' . $product["p_name"] . '</h4>';
		$product_html .= '<h4>Price: $' . $product["price"] . '</h4>';
		$product_html .= '</div>';
	}
	$product_html .= '<div class="clear_both"></div></div>';
}
