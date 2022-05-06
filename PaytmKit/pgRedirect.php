<?php
include '../db.php';
session_start();

if (!isset($_GET['cust_id'])) {
	echo "
		<script>
			window.open('/webproj/index.php', '_self');
		</script>";
}

header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

$checkSum = "";
$paramList = array();

$total_amt = 0;
$cust_id = $_GET['cust_id'];
$sql = "SELECT * from cart where cust_id =$cust_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {

	while ($row = $result->fetch_assoc()) {
		$product_id = $row['product_id'];
		$quantity = $row['quantity'];
		$sql2 = "SELECT discount_price from products where id = $product_id";
		$result2 = $conn->query($sql2);
		while ($row2 = $result2->fetch_assoc()) {
			$discount_price = $row2['discount_price'];
			$total_amt += $discount_price * $quantity;
		}
		// $total = $row['total'];

		// $sql = "INSERT into orders values('$')";
	}
}
$ORDER_ID = "ORDS" . rand(10000, 99999999) . "_" . strval($_GET['cust_id']);
$CUST_ID = $_GET['cust_id'];
$INDUSTRY_TYPE_ID = "Retail";
$CHANNEL_ID = "WEB";
$TXN_AMOUNT = $total_amt;

// Create an array having all required parameters for creating checksum.
$paramList["MID"] = PAYTM_MERCHANT_MID;
$paramList["ORDER_ID"] = $ORDER_ID;
$paramList["CUST_ID"] = $CUST_ID;
$paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
$paramList["CHANNEL_ID"] = $CHANNEL_ID;
$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
$paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
$paramList["CALLBACK_URL"] = "http://localhost:80/webproj/PaytmKit/pgResponse.php";

/*
$paramList["CALLBACK_URL"] = "http://localhost/PaytmKit/pgResponse.php";
$paramList["MSISDN"] = $MSISDN; //Mobile number of customer
$paramList["EMAIL"] = $EMAIL; //Email ID of customer
$paramList["VERIFIED_BY"] = "EMAIL"; //
$paramList["IS_USER_VERIFIED"] = "YES"; //

*/

//Here checksum string will return by getChecksumFromArray() function.
$checkSum = getChecksumFromArray($paramList, PAYTM_MERCHANT_KEY);

?>
<html>

<head>
	<title>Merchant Check Out Page</title>
</head>

<body>
	<center>
		<h1>Please do not refresh this page...</h1>
	</center>
	<form method="post" action="<?php echo PAYTM_TXN_URL ?>" name="f1">
		<table border="1">
			<tbody>
				<?php
				foreach ($paramList as $name => $value) {
					echo '<input type="hidden" name="' . $name . '" value="' . $value . '">';
				}
				?>
				<input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
			</tbody>
		</table>
		<script type="text/javascript">
			document.f1.submit();
		</script>
	</form>
</body>

</html>