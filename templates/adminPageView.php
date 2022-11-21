<!DOCTYPE html>
<html lang="hu">

<head>
	<title>Adatok</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<body>
	<h2>Adatok lekérdezése</h2>
	<?php date_default_timezone_set("Europe/Budapest");?>
	<form method="POST">
		<table>
			<tr>
				<td style="width: 100px;"><label for="email">E-mail cím:</label></td>
				<td><input type="text" name="email" placeholder="Felhasználó e-mail címe: " style="width: 22vw;"></td>
			</tr>
			<tr>
				<td><label for="date_from">Dátum (-tól)</label></td>
				<td><input type="datetime-local" id="date_from" name="date_from" value="2022-01-01 00:00" min="2018-01-01 00:00" max="2030-01-01 00:00" style="width: 22vw;"></td>
			</tr>
			<tr>
				<td><label for="date_to">Dátum (-ig)</label></td>
				<td><input type="datetime-local" id="date_to" name="date_to" value="<?php echo date('Y-m-d H:i'); ?>" min="2018-01-01" max="2030-01-01" style="width: 22vw;"></td>
			</tr>
			<tr>
				<td><label for="query">Válaszd ki a lekérdezést: </label></td>
				<td>
					<select name="query" id="query" style="width: auto;">
						<option value="query1">Termékekből mennyit rendelt</option>
						<option value="query2">Minden egyes rendelés végösszege</option>
						<option value="query3">Rendeléseinek összege</option>
						<option value="query4">Rendeléseinek átlaga</option>
						<option value="query5">Legutóbbi rendelése</option>
						<option value="query6">Rendeléseinek időpontja</option>
						<option value="query7">Vásárlásainak száma</option>
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Lekérdez" name="execute" style="margin: 30px; height: 50px; font-weight: bolder; font-size: medium;"><br></td>
			</tr>
		</table>
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
			break;
		case 'query7':
			selectNumofOrders();
			break;
		default:
		 	"default";
			break;
	}
}
?>