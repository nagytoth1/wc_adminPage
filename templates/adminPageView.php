<!DOCTYPE html>
<html lang="hu">

<head>
	<title>Adatok</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body>
	<h2>Adatok lekérdezése</h2>
	<form method="post">
		<label for="first_name">Vezetéknév:</label>
		<input type="text" name="first_name" placeholder="Vezetéknév: "> <br>
		<label for="last_name">Keresztnév:</label>
		<input type="text" name="last_name" placeholder="Keresztnév: "> <br>
		<label for="date_from">Dátum (-tól)</label>
		<input type="datetime-local" id="date_from" name="date_from" value="2022-01-01 00:00" min="2018-01-01 00:00" max="2030-01-01 00:00"> <br>
		<label for="date_to">Dátum (-ig)</label>
		<input type="datetime-local" id="date_to" name="date_to" value="<?php echo date('Y-m-d H:i'); ?>" min="2018-01-01" max="2030-01-01"><br>
		<label for="query">Válaszd ki a lekérdezést: </label>
		<select name="query" id="query">
			<option value="query1">Termékekből adott időszakban mennyit rendelt</option>
			<option value="query2">Rendelésenként a végösszegek</option>
			<option value="query3">Adott felhasználó(k) rendeléseinek összege</option>
			<option value="query4">Adott felhasználó(k) rendeléseinek átlaga</option>
			<option value="query5">Adott felhasználó(k) legutóbbi rendelése</option>
			<option value="query6">Adott vásárlók mikor vásároltak</option>
			<option value="query7">Adott vásárlók vásárlásainak száma</option>
		</select><br>
		<input type="submit" value="Submit" name="execute" style="margin: 30px;"><br>
	</form>
</body>


</html>
<?php

if (isset($_POST['execute'])) {
	require_once 'queries.php';
	switch ($_POST['query']) {
		case 'query1':
			selectProductsQty();
			break;
		case 'query2':
			selectSumofOrders();
			break;
		case 'query3':
			selectSummary();
			break;
		case 'query4':
			selectAvgofOrders();
			break;
		case 'query5':
			selectLatestOrder();
			break;
		case 'query6':
			selectOrderDates();
		case 'query7':
			selectNumofOrders();
		default:
		 	"default";
			break;
	}
}
?>