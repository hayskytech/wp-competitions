<?php
$data = array(
	'amount' => 100,
	'currency' => 'INR',
	'accept_partial' => false,
	'description' => 'For XYZ purpose',
	'customer' => array(
		'name' => 'Sufyan',
		'email' => 'sufyan@example.com',
		'contact' => '+918498000172'
	),
	'notify' => array('sms' => false, 'email' => false),
	'reminder_enable' => true,
	'notes' => array('policy_name' => 'Jeevan Bima'),
	'callback_url' => '<?php echo get_permalink(); ?>',
	'callback_method' => 'post'
);
// $response = $api->paymentLink->create($data);
// $response = $api->paymentLink->fetch('inv_M5zkl2HKXuU8E7');
if ($response->id) {
	$payment_link = $response->id;
} else {
	$payment_link = "plink_M5zkl2HKXuU8E7";
}
$user_id = get_current_user_id();
$links = get_usermeta($user_id, "comp_payments");
if (!$links) {
	$links = array();
}
$res = curll('https://api.razorpay.com/v1/payment_links/' . $link["payment_link"]);
array_push($links, $res->payment_links[0] );
$response = curll('https://api.razorpay.com/v1/payment_links/' . $payment_link);
wp_send_json($response);