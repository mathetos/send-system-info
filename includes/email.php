<?php

/**
 * Handles Remote Viewing of System Info
 *
 * @package     SSI
 * @subpackage  Classes/Email
 * @author      John Regan
 * @since       1.0
 */

class Send_System_Info_Email {

	/**
	 * Renders Email section of Plugin Settings Page
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	static function email_form_section() {
		?>
		<form action="" method="post" enctype="multipart/form-data">
			<table class="form-table ssi-email-form">
				<tr>
					<th scope="row">
						<label for="send-system-info-email-address"><?php _e( 'Send To Email Address', 'send-system-info' ) ?>*</label>
					</th>
					<td>
						<input type="email" name="send-system-info-email-address" id="send-system-info-email-address" placeholder="user@email.com" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="send-system-info-email-subject"><?php _e( 'Subject', 'send-system-info' ) ?>*</label>
					</th>
					<td>
						<input type="text" name="send-system-info-email-subject" id="send-system-info-email-subject" placeholder="Subject" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="send-system-info-email-message"><?php _e( 'Additional Message', 'send-system-info' ) ?></label>
						<p class="description"><?php _e( 'Your System Info will be attached automatically to this email form', 'send-system-info' ) ?>.</p>
					</th>
					<td>
						<textarea class="ssi-email-textarea" name="send-system-info-email-message" id="send-system-info-email-message"></textarea>
					</td>
				</tr>
			</table>
			<?php submit_button( __( 'Send Email', 'send-system-info' ) , 'secondary' ) ?>
		</form>
		<?php
	}


	/**
	 * Sends plain-text email, inserting the System Info
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
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
				$message = '- System Info Message -';
			}

			get_currentuserinfo();

			$headers = array(
				'From: ' . $current_user->display_name . ' <' . $current_user->user_email . '>',
				'Reply-To: ' . $current_user->user_email,
			);

			// Insert System Info into email
			$message .= "\r\n\r\n---------------\r\n\r\n" . Send_System_Info_Plugin::display( true );

			$sent = wp_mail( $address, $subject, $message, $headers );

			if ( $sent ) {
				return 'sent';
			} else {
				return 'error';
			}
		}

		return false;
	}

}