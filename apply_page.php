<?php
function custom_post_content($content) {
	if (is_singular('competition')) {
		global $post;
		ob_start();
		$deadline = get_post_meta($post->ID, 'deadline', true);
		$user_id = get_current_user_id();
		echo "<p>Last date: $deadline</p>";
		if ($deadline > date('Y-m-d') || 1) {
			if (isset($_POST['profile_picture1'])) {
				$id = wp_insert_post(
					array(
						'post_title' => "new application by $user_id",
						'post_status' => 'publish',
						'post_type' => 'application',
						'author' => $user_id
					)
				);
				update_post_meta($id, 'competition', $post->ID);
				update_post_meta($id, 'pdf', $_POST["profile_picture1"]);
			}
			$args = array(
				'post_type' => 'application',
				'post_status' => 'publish',
				'author' => $user_id,
				'meta_key' => 'competition',
				'meta_value' => $post->ID
			);
			$app = get_posts($args);
			if (count($app)) {
				$file_id = get_post_meta($app[0]->ID, 'pdf', true);
				echo "You have applied for this competitioin.<br>Your application ID is " . $app[0]->ID;
				echo '<br><a href="' . wp_get_attachment_url($file_id) . '" target="_blank">View Uploaded File</a>';
			} else {
				echo 'Apply Now';
				?>
				<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
				<form action="" method="post" enctype="multipart/form-data">
					<table>
						<tr>
							<td>Upload:</td>
							<td>
								<form id="file-upload-form" method="POST" enctype="multipart/form-data">
									<div id="uploadMsg"></div>
									<input type="button" class="button button-secondary upload-button" value="Select File" data-group="1">
									<input type="hidden" name="profile_picture1" id="profile-picture1" value="'.$picture1.'">
								</form>
								<script>
									jQuery(document).ready(function ($) {
										var mediaUploader;
										$('.upload-button').on('click', function (e) {
											e.preventDefault();
											var buttonID = $(this).data('group');
											if (mediaUploader) {
												mediaUploader.open();
												return;
											}
											mediaUploader = wp.media.frames.file_frame = wp.media({
												title: 'Choose a Hotel Picture',
												button: {
													text: 'Choose Picture'
												},
												multiple: false
											});
											mediaUploader.on('select', function () {
												attachment = mediaUploader.state().get('selection').first().toJSON();
												$('#profile-picture' + buttonID).val(attachment.id);
												$('#profile-picture-preview' + buttonID).css('background-image', 'url(' + attachment.url + ')');
												document.getElementById('uploadMsg').innerText = attachment.filename
											});
											mediaUploader.open();
										});
									});
								</script>
							</td>
						</tr>
						<tr>
							<td></td>
							<td><button>Submit</button></td>
						</tr>
					</table>
				</form>
				<?php
				wp_enqueue_media();
			}
			?>
			<script>
				if (window.history.replaceState) {
					window.history.replaceState(null, null, window.location.href);
				}
			</script>
			<?php
		} else {
			echo "$deadline was the last date.";
		}
		$message = ob_get_clean();
		$content .= $message;
	}
	return $content;
}
add_filter('the_content', 'custom_post_content');