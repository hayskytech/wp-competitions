<h1>Settings</h1>
<?php
global $wpdb;
$user_id = get_current_user_id();
if (isset($_POST["submit"])) {
	$data["razorpay_key"] = $_POST["razorpay_key"];
	$data["razorpay_secret"] = $_POST["razorpay_secret"];
	$data["com_mem_days"] = $_POST["com_mem_days"];
	$data["com_mem_amount"] = $_POST["com_mem_amount"];
	foreach ($data as $key => $value) {
		update_option($key, $value);
	}
}
?>
<form method="post" enctype="multipart/form-data">
	<table class="ui collapsing striped table">
		<tr>
			<td>Razorpay Key</td>
			<td><input type="text" name="razorpay_key">
			</td>
		</tr>
		<tr>
			<td>Razorpay Secret</td>
			<td><input type="text" name="razorpay_secret">
			</td>
		</tr>
		<tr>
			<td>Membership Days</td>
			<td><input type="number" name="com_mem_days"> days
			</td>
		</tr>
		<tr>
			<td>Membership Amount (Rs.)</td>
			<td><input type="text" name="com_mem_amount">
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="submit" value="Save" class="ui blue mini button"></td>
		</tr>
	</table>
</form>
<?php
$data["razorpay_key"] = get_option("razorpay_key");
$data["razorpay_secret"] = get_option("razorpay_secret");
$data["com_mem_days"] = get_option("com_mem_days");
$data["com_mem_amount"] = get_option("com_mem_amount");
?>
<script type="text/javascript">
	document.querySelector('input[name=razorpay_key]').value = '<?php echo $data["razorpay_key"]; ?>'
	document.querySelector('input[name=razorpay_secret]').value = '<?php echo $data["razorpay_secret"]; ?>'
	document.querySelector('input[name=com_mem_days]').value = '<?php echo $data["com_mem_days"]; ?>'
	document.querySelector('input[name=com_mem_amount]').value = '<?php echo $data["com_mem_amount"]; ?>'
</script>
<script type="text/javascript">
	if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
	}
</script>


<?php
/*
include 'razorpay-php/Razorpay.php';
use Razorpay\Api\Api;

$apiKey = get_option('razorpay_key');
$apiSecret = get_option('razorpay_secret');
$api = new Api($apiKey, $apiSecret);

$response = $api->paymentLink->fetch('plink_M5zkl2HKXuU8E7 ');
print_r($response);

// https://haysky.com/?razorpay_payment_id=pay_M5zu8WKKN6MNq0&razorpay_payment_link_id=plink_M5zkl2HKXuU8E7&razorpay_payment_link_reference_id&razorpay_payment_link_status=paid&razorpay_signature=7c16ea2ebf747270c0c45b362853b0812ba1550f99d15ba6608e3c4305990b77

*/