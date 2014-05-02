<?php

class Send_System_Info_Email {

//Render Email Form
	static function email_form() {
		?>
		<form action="" method="post" enctype="multipart/form-data">
			<table class="form-table">
				<tr>
					<th scope="row">
						<label for="send-system-info-email-address"><?php _e( 'Send To Email Address', 'send-system-info' ) ?></label>
					</th>
					<td>
						<input type="email" name="send-system-info-email-address" id="send-system-info-email-address" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="send-system-info-email-subject"><?php _e( 'Subject', 'send-system-info' ) ?></label>
					</th>
					<td>
						<input type="text" name="send-system-info-email-subject" id="send-system-info-email-subject" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="send-system-info-email-message"><?php _e( 'Additional Message', 'send-system-info' ) ?></label>
					</th>
					<td>
						<textarea style="width: 50%; height: 200px;" name="send-system-info-email-message" id="send-system-info-email-message"></textarea>
					</td>
				</tr>
			</table>
			<p>Your System Info will be attached automatically to this email form.</p>
			<?php submit_button( __( 'Send Email', 'send-system-info' ) , 'secondary' ) ?>
		</form>
		<?php
	}

	static function send_email() {
		global $current_user;
		if ( isset( $_POST['send-system-info-email-address'] ) &&
			isset( $_POST['send-system-info-email-subject'] ) &&
			isset( $_POST['send-system-info-email-message'] ) ) {
			if ( ! empty( $_POST['send-system-info-email-address'] ) ) {
				$address = $_POST['send-system-info-email-address'];
			} else {
				return 'error';
			}
			if ( ! empty( $_POST['send-system-info-email-subject'] ) ) {
				$subject = $_POST['send-system-info-email-subject'];
			} else {
				return 'error';
			}
			if ( ! empty( $_POST['send-system-info-email-message'] ) ) {
				$message = $_POST['send-system-info-email-message'];
			} else {
				$message = 'System Info';
			}
			get_currentuserinfo();

			$headers = array(
				'From: ' . $current_user->display_name . ' <' . $current_user->user_email . '>',
				'Reply-To: ' . $current_user->user_email,
			);

			$message .= "\r\n\r\n---------------\r\n\r\n" . Send_System_Info_Plugin::display( true );

			//var_dump( file_get_contents($temp) );
			$sent = wp_mail( $address, $subject, $message, $headers );
			if ( $sent ) {
				return 'sent';
			} else {
				return 'error';
			}
		}
		return false;
	}

	static function info_file() {

	}
}