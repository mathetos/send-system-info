<header>
    <h3 class="ssi-email-title"><?php _e( 'Send via Email', 'send-system-info' ) ?></h3>
    <p><?php echo __('Use this form to email your System Info to your Support technician.', 'send-system-info'); ?></p>
</header>
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
				<textarea class="ssi-email-textarea" name="send-system-info-email-message" id="send-system-info-email-message" placeholder="- System Info Message -"></textarea>
			</td>
		</tr>
	</table>
	<?php submit_button( __( 'Send Email', 'send-system-info' ) , 'primary' ) ?>
</form>
