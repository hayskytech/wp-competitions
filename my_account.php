<?php
if (!is_user_logged_in()) {
	echo "Please login to continue...";
	return;
}
global $wpdb;
$user_id = get_current_user_id();
if (isset($_POST["submit"])) {
	$data["full_name"] = $_POST["full_name"];
	$data["phone"] = $_POST["phone"];
	$data["email"] = $_POST["email"];
	foreach ($data as $key => $value) {
		update_user_meta($user_id, $key, $value);
	}
}
$userdata = get_userdata($user_id);
$meta = get_user_meta($user_id);
$data["full_name"] = $meta["full_name"][0];
$data["phone"] = $meta["phone"][0];
$data["email"] = $meta["email"][0];
?>
<form method="post" enctype="multipart/form-data">
	<table class="ui collapsing striped table">
		<tr>
			<td>Full Name</td>
			<td><input type="text" name="full_name">
			</td>
		</tr>
		<tr>
			<td>Phone</td>
			<td><input type="text" name="phone">
			</td>
		</tr>
		<tr>
			<td>Email</td>
			<td><input type="text" name="email">
			</td>
		</tr>
		<tr>
			<td>Membership</td>
			<td>
				<?php
				$m = get_user_meta($user_id, "com_membership_expiry", true);
				$amount = get_option('com_mem_amount');
				$days = get_option('com_mem_days');
				$date1 = date_create($m);
				$date2 = date_create(date('Y-m-d'));
				$diff = date_diff($date2, $date1);
				$apply = true;
				if ($m != '') {
					if ($date2 < $date1) {
						echo "Active. ";
						$apply = false;
						if ($diff->days < 30) {
							echo "(" . $diff->days . " days left)";
						}
					} else {
						echo "Expired " . $diff->days . " days ago";
						$apply = true;
					}
				}
				if ($apply) {
					?>
					<button onclick="showMembership()">Apply</button>
					<dialog id="mem_dialog">
						<h3>Join Membership</h3>
						<p><?php echo "Rs. $amount for $days"; ?></p>
						<button onclick="pay_now()" disabled>Pay Now</button>
						<button onclick="pay_close()">Close</button>
					</dialog>
					<script>
						const d = document.getElementById("mem_dialog")
						function showMembership() {
							event.preventDefault()
							d.showModal()
						}
						function pay_now() {
							event.preventDefault()
							// coming soon
						}
						function pay_close() {
							event.preventDefault()
							d.close()
						}
					</script>
					<?php
				}
				?>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="submit" value="Save" class="ui blue mini button"></td>
		</tr>
	</table>
</form>
<script type="text/javascript">
	document.querySelector('input[name=full_name]').value = '<?php echo $data["full_name"]; ?>'
	document.querySelector('input[name=phone]').value = '<?php echo $data["phone"]; ?>'
	document.querySelector('input[name=email]').value = '<?php echo $data["email"]; ?>'
</script>
<script type="text/javascript">
	if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
	}
</script>