<?php
function custom_post_content($content) {
	if (is_singular('post')) {
		global $post;
		ob_start();
		$deadline = get_post_meta($post->ID, 'deadline', true);
		$user_id = get_current_user_id();
		echo "<p>Last date: $deadline</p>";
		if ($deadline > date('Y-m-d') || 1) {
			if (isset($_POST['my_image_upload_nonce'])) {
				$id = wp_insert_post(
					array(
						'post_title' => "new application by $user_id",
						'post_status' => 'publish',
						'post_type' => 'application',
						'author' => $user_id
					)
				);
				update_post_meta($id, 'competition', $post->ID);
				update_post_meta($id, 'pdf', $_POST["my_image_upload_nonce"]);
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
				$userr = wp_get_current_user();

				echo '<pre>';
				print_r($userr->allcaps);
				echo '</pre>';
				?>
				<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script> -->
				<form action="" method="post" enctype="multipart/form-data">
					<table>
						<tr>
							<td>Upload:</td>
							<td>
								<?php wp_nonce_field('my_file', 'my_image_upload_nonce'); ?>
								<div class="image-preview-wrapper">
									<a id="link_pdf">View</a>
								</div>
								<input type="button" class="ui blue mini button" value="Choose Media" onclick="choose_media(this)" />
								<input type="hidden" name="pdf">
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
			<script type='text/javascript'>
				function choose_media(x) {
					var file_frame;
					var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
					var set_to_post_id = jQuery(x).parent().find('input[type=hidden]').val(); // Set this
					if (file_frame) {
						file_frame.uploader.uploader.param('post_id', set_to_post_id);
						file_frame.open();
						return;
					} else {
						wp.media.model.settings.post.id = set_to_post_id;
					}
					file_frame = wp.media.frames.file_frame = wp.media({
						title: 'Select a file to upload',
						button: {
							text: 'Use this File',
						},
						multiple: false
					});
					// When an image is selected, run a callback.
					file_frame.on('select', function () {
						// We set multiple to false so only get one image from the uploader
						attachment = file_frame.state().get('selection').first().toJSON();
						// Do something with attachment.id and/or attachment.url here
						jQuery(x).parent().find('img').attr('src', attachment.url).css('width', 'auto');
						jQuery(x).parent().find('input[type=hidden]').val(attachment.id);
						// Restore the main post ID
						wp.media.model.settings.post.id = wp_media_post_id;
					});
					// Finally, open the modal
					file_frame.open();
					// Restore the main ID when the add media button is pressed
					jQuery('a.add_media').on('click', function () {
						// wp.media.model.settings.post.id = wp_media_post_id;
					});
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