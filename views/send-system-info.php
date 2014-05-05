<div class="wrap">
	<h2 class="ssi-title"><?php _e( 'Send System Info', 'send-system-info' ); ?></h2>
		<div id="templateside">
			<p class="instructions"><?php _e( 'Send System Info displays data useful to support personnel.  This information can be sent via email using the from below.', 'send-system-info' ) ?></p>
			<p class="instructions"><?php _e( 'Additionally, a URL can be given to your support provider to allow them to view this information at any time.  This access can be revoked by generating a new URL.  This link may be handy to use in support forums, as access to this information can be removed after you recieve the help you need.', 'send-system-info' ) ?></p>
		</div>
		<div id="template">
			<?php // Form used to download .txt file ?>
			<form action="<?php echo esc_url( self_admin_url( 'admin-ajax.php' ) ); ?>" method="post" enctype="multipart/form-data" >
				<input type="hidden" name="action" value="download_system_info" />
				<div>
					<textarea readonly="readonly" onclick="this.focus();this.select()" id="ssi-textarea" name="send-system-info-textarea" title="<?php _e( 'To copy the System Info, click below then press Ctrl + C (PC) or Cmd + C (Mac).', 'send-system-info' ); ?>">
<?php //Non standard indentation needed for plain-text display ?>
<?php self::display() ?>
					</textarea>
				</div>
				<p class="submit">
					<input type="submit" class="button-secondary" value="<?php _e( 'Download Sytem Info as Text File', 'send-system-info' ) ?>" />
				</p>
			</form>
			<h3 class="ssi-email-title"><?php _e( 'Send via Email', 'send-system-info' ) ?></h3>
			<?php Send_System_Info_Email::email_form_section() ?>
			<h3 class="ssi-remote-title"><?php _e( 'Remote Viewing', 'send-system-info' ) ?></h3>
			<?php Send_System_Info_Viewer::remote_viewing_section() ?>
		</div>
</div>
