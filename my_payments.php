<form action="" method="post">
	<input type="submit" value="Refresh All" name="refresh_all_links">
	<input type="submit" value="New Link" name="new_link">
</form>
<?php
$user_id = get_current_user_id();
if ($_POST["new_link"]) {
	$d = get_usermeta($user_id, "comp_payments");
	if (!$d) {
		$d = array();
	}
	$pay_load = array(
		array(
			'amount' => 100,
			'currency' => 'INR',
			'description' => 'For New purpose',
			'customer' => array(
				'name' => 'Sufyan',
				'email' => 'mdsufyan7@gmail.com',
				'contact' => '+919490828909'
			),
			'notify' => array('sms' => false, 'email' => false),
		)
	);
	$res = curll('https://api.razorpay.com/v1/payment_links/', $pay_load);
	$res = $res->payment_links[0];
	array_push($d, $res);
	update_user_meta($user_id, "comp_payments", $d);
}

if (isset($_POST["refresh_all_links"]) || isset($_GET["razorpay_payment_link_id"])) {
	$links = get_usermeta($user_id, "comp_payments");
	$data = array();
	foreach ($links as $link) {
		$res = curll('https://api.razorpay.com/v1/payment_links/' . $link->id);
		array_push($data, $res);
	}
	update_user_meta($user_id, "comp_payments", $data);
}
$links = get_usermeta($user_id, "comp_payments");
echo "<table>
	<tr>
		<th>Payment ID</th>
		<th>Created</th>
		<th>Updated</th>
		<th>Action</th>
	</tr>";
foreach ($links as $link) {
	echo "<tr><td>$link->id</td>";
	echo "<td>" . date('Y-m-d h:i', $link->created_at) . "</td>";
	echo "<td>" . date('Y-m-d h:i', $link->updated_at) . "</td>";
	if ($link->status != 'paid') {
		echo "<td><a href=\"$link->short_url\">Pay Now</a></td>";
	} else {
		echo "<td>$link->status</td>";
	}
	echo "</tr>";
}
echo "</table>";
echo '<pre>';

print_r(curll('https://api.razorpay.com/v1/payment_links/plink_M5zkAKvOixCqyi'));
echo '</pre>';

?>