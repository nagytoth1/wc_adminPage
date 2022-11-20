<?php

function selectProductsQty()
{
	global $wpdb;
	//tábláink: wp_wc_order_product_lookup, wp_wc_customer_lookup, wp_woocommerce_order_items
	$query = $wpdb->prepare("SELECT c.last_name, c.first_name, pr.order_item_name, p.product_qty, ord.date_created as 'order_date'
	FROM {$wpdb->prefix}wc_order_product_lookup as p 
	INNER JOIN {$wpdb->prefix}wc_customer_lookup as c 
	ON c.`customer_id`= p.customer_id 
	INNER JOIN {$wpdb->prefix}woocommerce_order_items as pr 
	ON pr.order_item_id=p.order_item_id 
	INNER JOIN {$wpdb->prefix}wc_order_stats as ord 
	ON pr.order_id = ord.order_id
    WHERE c.email=%s
	AND p.date_created BETWEEN %s AND %s
	ORDER BY 4 DESC;",
	array($_POST['email'], $_POST['date_from'], $_POST['date_to']));
	$result = $wpdb->get_results($query, 'ARRAY_A');
	if ( $wpdb->last_error ) {
		echo 'wpdb error: ' . $wpdb->last_error;
	}
	echo '<table>
	<thead>
	 <th scope="col">Vezetéknév</th>
	 <th scope="col">Keresztnév</th>
	 <th scope="col">Termék</th>
	 <th scope="col">Vásárolt mennyiség (db)</th>
	 <th scope="col">Rendelés dátuma</th>
	</thead>';
	foreach($result as $row)
	{
		echo '<tr>' .
			'<td style="text-align: center;">' . $row['last_name'] . '</td>' .
			'<td style="text-align: center;">' . $row['first_name'] . '</td>' .
			'<td style="text-align: center;">' . $row['order_item_name'] . '</td>' .
			'<td style="text-align: center;">' . $row['product_qty'] . '</td>' .
			'<td style="text-align: center;">' . $row['order_date'] . '</td>' .
			'</tr>';
	}
	echo '</table>';
}
function selectSumofOrders()
{
	global $wpdb;

	//rendelésenként a végösszegek
	$query = $wpdb->prepare("SELECT ord.order_id, c.last_name, c.first_name, ord.total_sales
	FROM {$wpdb->prefix}wc_customer_lookup as c 
	INNER JOIN {$wpdb->prefix}wc_order_stats as ord 
	ON ord.customer_id = c.customer_id 
	WHERE c.email=%s
	AND ord.date_created BETWEEN %s AND %s
	GROUP BY 4 
	ORDER BY 4 DESC;",
	array($_POST['email'], $_POST['date_from'], $_POST['date_to']));
	$result = $wpdb->get_results($query, 'ARRAY_A');
	if ( $wpdb->last_error )
		echo 'wpdb error: ' . $wpdb->last_error;
	echo '<table>
	<thead>
		<th scope="col">Rendelési azonosító</th> 
		<th scope="col">Vezetéknév</th>
	 	<th scope="col">Keresztnév</th>
	 	<th scope="col">Rendelés végösszege (HUF)</th>
	</thead>';
	foreach($result as $row) {
		echo '<tr>' .
			'<td>' . $row['order_id'] . '</td>' .
			'<td>' . $row['last_name'] . '</td>' .
			'<td>' . $row['first_name'] . '</td>' .
			'<td>' . $row['total_sales'] . '</td>' .
			'</tr>';
	}
	echo '</table>';
}
function selectSummary()
{
	global $wpdb;
	//összes rendelés összege
	$query = $wpdb->prepare("SELECT ord.order_id, c.last_name, c.first_name, SUM(ord.total_sales) as 'sum_total_sales'
	FROM {$wpdb->prefix}wc_customer_lookup as c 
	INNER JOIN {$wpdb->prefix}wc_order_stats as ord 
	ON ord.customer_id = c.customer_id 
	WHERE c.email=%s
	AND ord.date_created BETWEEN %s AND %s;",
	array($_POST['email'], $_POST['date_from'], $_POST['date_to']));
	$result = $wpdb->get_results($query, 'ARRAY_A');
	if ( $wpdb->last_error )
		echo 'wpdb error: ' . $wpdb->last_error;
	echo '<table>
	<thead>
		<th scope="col">Vezetéknév</th>
	 	<th scope="col">Keresztnév</th>
	 	<th scope="col">Rendelés végösszege (HUF)</th>
	</thead>';
	foreach($result as $row) {
		echo '<tr>' .
			'<td>' . $row['last_name'] . '</td>' .
			'<td>' . $row['first_name'] . '</td>' .
			'<td>' . $row['sum_total_sales'] . '</td>' .
			'</tr>';
	}
	echo '</table>';
}
function selectAvgofOrders()
{
	global $wpdb;

	$query = $wpdb->prepare("SELECT c.last_name, c.first_name , AVG(ord.net_total) as 'avg_total_sales'
	FROM {$wpdb->prefix}wc_order_product_lookup	as p 
	INNER JOIN {$wpdb->prefix}wc_customer_lookup as c 
	ON c.customer_id= p.customer_id 
	INNER JOIN  {$wpdb->prefix}wc_order_stats as ord
	ON ord.order_id = p.order_id
	WHERE c.email = %s
	AND p.date_created BETWEEN %s AND %s;",
	array($_POST['email'], $_POST['date_from'], $_POST['date_to']));
	$result = $wpdb->get_results($query, 'ARRAY_A');
	if ( $wpdb->last_error )
		echo 'wpdb error: ' . $wpdb->last_error;
	echo '<table>
	<thead>
		<th scope="col">Vezetéknév</th>
	 	<th scope="col">Keresztnév</th>
	 	<th scope="col">Rendelés végösszege (HUF)</th>
	</thead>';
	foreach($result as $row){
		echo '<tr>' .
			'<td>' . $row['last_name'] . '</td>' .
			'<td>' . $row['first_name'] . '</td>' .
			'<td>' . $row['avg_total_sales'] . '</td>' .
			'</tr>';
	}
	echo '</table>';
}
function selectLatestOrder(){
	global $wpdb;
	$query = $wpdb->prepare("SELECT c.last_name, c.first_name, MAX(p.date_created) as 'max_date'
	FROM {$wpdb->prefix}wc_order_product_lookup as p 
	INNER JOIN {$wpdb->prefix}wc_customer_lookup as c 
	ON c.customer_id= p.customer_id 
	INNER JOIN  {$wpdb->prefix}wc_order_stats as ord
	ON ord.order_id = p.order_id
	WHERE c.email = %s
	AND p.date_created BETWEEN %s AND %s;",
	array($_POST['email'], $_POST['date_from'], $_POST['date_to']));
	$result = $wpdb->get_results($query, 'ARRAY_A');
	if ( $wpdb->last_error )
		echo 'wpdb error: ' . $wpdb->last_error;
	echo '<table>
	<thead>
		<th scope="col">Vezetéknév</th>
	 	<th scope="col">Keresztnév</th>
	 	<th scope="col">Legutóbbi rendelés időpontja</th>
	</thead>';
	foreach($result as $row){
		echo '<tr>' .
			'<td>' . $row['last_name'] . '</td>' .
			'<td>' . $row['first_name'] . '</td>' .
			'<td>' . $row['max_date'] . '</td>' .
			'</tr>';
	}
	echo '</table>';
}
function selectOrderDates()
{
	global $wpdb;
	$query = $wpdb->prepare("SELECT c.last_name , c.first_name, p.date_created as 'order_of_date'
	FROM {$wpdb->prefix}wc_order_product_lookup	as p 
	INNER JOIN {$wpdb->prefix}wc_customer_lookup as c 
	ON c.customer_id= p.customer_id 
	INNER JOIN {$wpdb->prefix}wc_order_stats as ord
	ON ord.order_id = p.order_id
	WHERE c.email = %s
	AND p.date_created BETWEEN %s AND %s
	GROUP BY 3;",
	array($_POST['email'], $_POST['date_from'], $_POST['date_to']));
	$result = $wpdb->get_results($query, 'ARRAY_A');
	if ( $wpdb->last_error )
		echo 'wpdb error: ' . $wpdb->last_error;
	echo '<table>
	<thead>
		<th scope="col">Vezetéknév</th>
	 	<th scope="col">Keresztnév</th>
	 	<th scope="col">Rendelés(ek) időpontja(i)</th>
	</thead>';
	foreach($result as $row){
		echo 
			'<tr>' .
			'<td>' . $row['last_name'] . '</td>' .
			'<td>' . $row['first_name'] . '</td>' .
			'<td>' . $row['order_of_date'] . '</td>' .
			'</tr>';
	}
	echo '</table>';
}
function selectNumofOrders()
{
	global $wpdb;
	$query = $wpdb->prepare("SELECT c.last_name, c.first_name, COUNT(ord.order_id), as 'count_orders'
	FROM {$wpdb->prefix}wc_order_stats as ord 
	INNER JOIN {$wpdb->prefix}wc_customer_lookup as c 
	ON c.customer_id=ord.customer_id 
	WHERE c.email=%s
	AND ord.date_created BETWEEN %s AND %s;",
	array($_POST['email'], $_POST['date_from'], $_POST['date_to']));
	$result = $wpdb->get_results($query, 'ARRAY_A');
	if ( $wpdb->last_error )
		echo 'wpdb error: ' . $wpdb->last_error;
	echo '<table>
	<thead>
		<th scope="col">Vezetéknév</th>
	 	<th scope="col">Keresztnév</th>
	 	<th scope="col">Rendelés(ek) száma</th>
	</thead>';
	foreach($result as $row){
		echo
		'<tr>' .
		'<td>' . $row['last_name'] . '</td>' .
		'<td>' . $row['first_name'] . '</td>' .
		'<td>' . $row['count_orders'] . '</td>' .
		'</tr>';
	}
	echo '</table>';
}
?>