
<?php
include '../db.php';
session_start();

header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.



$arr = explode("_", $_POST['ORDERID']);
$cust_id = $arr[1];

$_SESSION['cust_id'] = $cust_id;

if ($isValidChecksum == "TRUE") {
	echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";

	if ($_POST["STATUS"] == "TXN_SUCCESS") {
		echo "<b>Transaction status is success</b>" . "<br/>";
		//$insert = mysqli_query($conn, "INSERT into cart ");
		// $cust_id = $_SESSION["cust_id"];
		$sql = "SELECT * from cart where cust_id = '$cust_id'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			$ORDERID = $_POST['ORDERID'];

			while ($row = $result->fetch_assoc()) {
				$product_id = $row['product_id'];
				$quantity = $row['quantity'];
				$sql2 = "SELECT discount_price from products where id = $product_id";
				$result2 = $conn->query($sql2);
				$total = 0;
				while ($row2 = $result2->fetch_assoc()) {
					$discount_price = $row2['discount_price'];
					$total = $discount_price * $quantity;
				}
				$result3 = mysqli_query($conn, "INSERT into orders ( `cust_id`, `product_id`, `quantity`, `amount`, `payment_mode`, `transcation_details`) 
											values ('$cust_id', '$product_id', '$quantity', '$total', 'online', '$ORDERID')");
				// echo "INSERT into orders ( `cust_id`, `product_id`, `quantity`, `amount`, `payment_mode`, `transcation_details`) 
				// 							values ('$cust_id', '$product_id', '$quantity', '$total', 'online', $ORDERID)\n";
			}
			$result4 = mysqli_query($conn, "DELETE FROM cart where cust_id=$cust_id");

			$TXNID = $_POST['TXNID'];
			$GATEWAYNAME = $_POST['GATEWAYNAME'];
			$BANKNAME = $_POST['BANKNAME'];
			$PAYMENTMODE = $_POST['PAYMENTMODE'];
			$TXNDATE = $_POST['TXNDATE'];
			$result5 = mysqli_query($conn, "INSERT INTO `transaction_details`(`id`, `txn_id`, `gateway_name`, `bank_name`, `payment_mode`, `transcation_date`) 
											VALUES ('$ORDERID', '$TXNID','$GATEWAYNAME', '$BANKNAME', '$PAYMENTMODE', '$TXNDATE')");
			echo "
				<script>
				window.open('/checkout/success.php', '_self');
				</script>";
			// echo "
			// 		<script>
			// 		alert($cust_id);
			// 		</script>";
		}
		//Process your transaction here as success transaction.
		//Verify amount & order id received from Payment gateway with your application's order id and amount.

		// } else {
		// 	// echo "<b>Transaction status is failure</b>" . "<br/>";
		// 	// echo "
		// 	// <script>
		// 	// window.open('/checkout/error.php', '_self');
		// 	// </script>";

		// }

		if (isset($_POST) && count($_POST) > 0) {
			foreach ($_POST as $paramName => $paramValue) {
				echo "<br/>" . $paramName . " = " . $paramValue;
			}
		}
	} else {
		// echo "<b>Checksum mismatched.</b>";
		//Process transaction as suspicious.
		echo "
			<script>
			window.open('/checkout/error.php', '_self');
			</script>";
	}
}
?>