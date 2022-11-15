<?php
function selectProductsQty()
{
	$conn = mysqli_connect('localhost', 'root', '', 'wordpress1', 3306);
	//melyik termékből mennyit rendelt
	$query = 'SELECT c.last_name, c.first_name, p.product_qty, pr.order_item_name FROM `wp_wc_order_product_lookup`
    as p INNER JOIN `wp_wc_customer_lookup` as c
    ON c.`customer_id`=p.customer_id
    INNER JOIN `wp_woocommerce_order_items` as pr
    ON pr.order_item_id=p.order_item_id 
    WHERE c.first_name="' . $_POST['first_name'] . '"' . ' AND c.last_name="' . $_POST['last_name'] . '";';

	$result = mysqli_query($conn, $query);
	echo '<table>
	<thead>
	 <th scope="col">Vezetéknév</th>
	 <th scope="col">Keresztnév</th>
	 <th scope="col">Termék</th>
	 <th scope="col">Vásárolt mennyiség (db)</th>
	</thead>';
	while ($row = mysqli_fetch_assoc($result)) {
		echo '<tr>' .
			'<td>' . $row['first_name'] . '</td>' .
			'<td>' . $row['last_name'] . '</td>' .
			'<td>' . $row['order_item_name'] . '</td>' .
			'<td>' . $row['product_qty'] . '</td>' .
			'</tr>';
	}
	echo '</table>';
}
function selectSumofOrders()
{
	$conn = mysqli_connect('localhost', 'root', '', 'wordpress1', 3306);
	//melyik termékből mennyit rendelt
	$query = 'SELECT p.order_id, c.last_name, c.first_name, ord.total_sales FROM `wp_wc_order_product_lookup` 
	as p INNER JOIN `wp_wc_customer_lookup` as c 
	ON c.`customer_id`= p.customer_id 
	INNER JOIN  `wp_wc_order_stats` as ord
	ON ord.order_id = p.order_id
    WHERE c.first_name="' . $_POST['first_name'] . '"' . ' AND c.last_name="' . $_POST['last_name'] . '"' .
		'AND p.date_created BETWEEN \'' . $_POST['date_from'] . '\' AND \'' . $_POST['date_from'] . '\'' .
		' GROUP BY p.order_id;';
	$result = mysqli_query($conn, $query);
	echo '<table>
	<thead>
		<th scope="col">Rendelési azonosító</th> 
		<th scope="col">Vezetéknév</th>
	 	<th scope="col">Keresztnév</th>
	 	<th scope="col">Rendelés végösszege (HUF)</th>
	</thead>';
	while ($row = mysqli_fetch_assoc($result)) {
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
	$conn = mysqli_connect('localhost', 'root', '', 'wordpress1', 3306);
	//melyik termékből mennyit rendelt
	$query = 'SELECT p.order_id, c.last_name, c.first_name, SUM(ord.total_sales) as "sum_total_sales"  FROM `wp_wc_order_product_lookup` 
	as p INNER JOIN `wp_wc_customer_lookup` as c 
	ON c.`customer_id`= p.customer_id 
	INNER JOIN  `wp_wc_order_stats` as ord
	ON ord.order_id = p.order_id
	WHERE c.first_name="' . $_POST['first_name'] . '"' . ' AND c.last_name="' . $_POST['last_name'] . '"' .
		'AND p.date_created BETWEEN \'' . $_POST['date_from'] . '\' AND \'' . $_POST['date_to'] . '\'' .
		' ORDER BY 4;';
	
	$result = mysqli_query($conn, $query);
	echo '<table>
	<thead>
		<th scope="col">Rendelési azonosító</th> 
		<th scope="col">Vezetéknév</th>
	 	<th scope="col">Keresztnév</th>
	 	<th scope="col">Rendelés végösszege (HUF)</th>
	</thead>';
	while ($row = mysqli_fetch_assoc($result)) {
		echo '<tr>' .
			'<td>' . $row['order_id'] . '</td>' .
			'<td>' . $row['last_name'] . '</td>' .
			'<td>' . $row['first_name'] . '</td>' .
			'<td>' . $row['sum_total_sales'] . '</td>' .
			'</tr>';
	}
	echo '</table>';
}
function selectAvgofOrders()
{
	$conn = mysqli_connect('localhost', 'root', '', 'wordpress1', 3306);
	//melyik termékből mennyit rendelt
	$query = 'SELECT  c.last_name, c.first_name , AVG(ord.net_total) as "avg_total_sales" FROM `wp_wc_order_product_lookup` 
	as p INNER JOIN `wp_wc_customer_lookup` as c 
	ON c.`customer_id`= p.customer_id 
	INNER JOIN  `wp_wc_order_stats` as ord
	ON ord.order_id = p.order_id
	WHERE c.first_name="' . $_POST['first_name'] . '"' . ' AND c.last_name="' . $_POST['last_name'] . '"' .
		'AND p.date_created BETWEEN \'' . $_POST['date_from'] . '\' AND \'' . $_POST['date_to'] . '\'' .
		' ORDER BY 3;';
	
	$result = mysqli_query($conn, $query);
	echo '<table>
	<thead>
		<th scope="col">Vezetéknév</th>
	 	<th scope="col">Keresztnév</th>
	 	<th scope="col">Rendelés végösszege (HUF)</th>
	</thead>';
	while ($row = mysqli_fetch_assoc($result)) {
		echo '<tr>' .
			'<td>' . $row['last_name'] . '</td>' .
			'<td>' . $row['first_name'] . '</td>' .
			'<td>' . $row['avg_total_sales'] . '</td>' .
			'</tr>';
	}
	echo '</table>';
}
function selectLatestOrder(){
	$conn = mysqli_connect('localhost', 'root', '', 'wordpress1', 3306);
	//melyik termékből mennyit rendelt
	$query = 'SELECT MAX(p.date_created) as "max_date", c.last_name, c.first_name FROM `wp_wc_order_product_lookup` 
	as p INNER JOIN `wp_wc_customer_lookup` as c 
	ON c.`customer_id`= p.customer_id 
	INNER JOIN  `wp_wc_order_stats` as ord
	ON ord.order_id = p.order_id
	WHERE c.first_name="' . $_POST['first_name'] . '"' . ' AND c.last_name="' . $_POST['last_name'] . '"' .
	'AND p.date_created BETWEEN \'' . $_POST['date_from'] . '\' AND \'' . $_POST['date_to'] . '\';';
	
	$result = mysqli_query($conn, $query);
	echo '<table>
	<thead>
		<th scope="col">Vezetéknév</th>
	 	<th scope="col">Keresztnév</th>
	 	<th scope="col">Legutóbbi rendelés időpontja</th>
	</thead>';
	while ($row = mysqli_fetch_assoc($result)) {
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
	$conn = mysqli_connect('localhost', 'root', '', 'wordpress1', 3306);
	//melyik termékből mennyit rendelt
	$query = 'SELECT p.date_created as "order_of_date", c.last_name , c.first_name FROM `wp_wc_order_product_lookup` 
	as p INNER JOIN `wp_wc_customer_lookup` as c 
	ON c.`customer_id`= p.customer_id 
	INNER JOIN  `wp_wc_order_stats` as ord
	ON ord.order_id = p.order_id
	WHERE c.first_name="' . $_POST['first_name'] . '"' . ' AND c.last_name="' . $_POST['last_name'] . '"' .
	'AND p.date_created BETWEEN \'' . $_POST['date_from'] . '\' AND \'' . $_POST['date_to'] . '\''.'
	GROUP BY 3';
	$result = mysqli_query($conn, $query);
	echo '<table>
	<thead>
		<th scope="col">Vezetéknév</th>
	 	<th scope="col">Keresztnév</th>
	 	<th scope="col">Rendelés(ek) időpontja(i)</th>
	</thead>';
	while ($row = mysqli_fetch_assoc($result)) {
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
	$conn = mysqli_connect('localhost', 'root', '', 'wordpress1', 3306);
	//melyik termékből mennyit rendelt
	$query = 'SELECT COUNT(ord.order_id) as "count_orders", c.last_name, c.first_name FROM `wp_wc_order_stats` 
	as ord INNER JOIN `wp_wc_customer_lookup` as c 
	ON c.`customer_id`= ord.customer_id 
	WHERE c.first_name="' . $_POST['first_name'] . '"' . ' AND c.last_name="' . $_POST['last_name'] . '"' .
	'AND ord.date_created BETWEEN \'' . $_POST['date_from'] . '\' AND \'' . $_POST['date_to'] . '\';';
	
	$result = mysqli_query($conn, $query);
	echo '<table>
	<thead>
		<th scope="col">Vezetéknév</th>
	 	<th scope="col">Keresztnév</th>
	 	<th scope="col">Rendelés(ek) száma</th>
	</thead>';
	while ($row = mysqli_fetch_assoc($result)) {
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