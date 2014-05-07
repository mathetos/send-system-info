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
		include( SSI_VIEWS_DIR . 'email-form.php' );
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
			$message .= "\r\n\r\n---------------\r\n\r\n" . Send_System_Info_Plugin::display();

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