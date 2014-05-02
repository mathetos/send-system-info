<?php

class Send_System_Info_Viewer {

	static function front_end_display() {
		if ( ! isset( $_GET['systeminfo'] ) || empty( $_GET['systeminfo'] ) ) {
			return;
		}
		$query_value = $_GET['systeminfo'];
		$value       = get_option( 'system_info_remote_url' );

		echo '<pre>';
		if ( $query_value == $value ) {
			Send_System_Info_Plugin::display();
			exit;
		} else {
			exit( 'Invalid System Info URL.' );
		}
		echo '</pre>';
	}

	static function remote_viewing() {
		$value = get_option( 'system_info_remote_url' );
		$url   = home_url() . '/?systeminfo=' . $value;
		?>
		<p>Users with this URL can view a plain-text version of your System Data.</p>
		<p><span style="font-family: Consolas, Monaco, monospace;" class="send-system-info-url"><?php echo esc_url( $url ) ?></span></p>
		<p>Generating a new URL will void access to all who have the existing URL.  To remove access for everyone, simply generate a new URL.</p>
		<input type="submit" onClick="return false;" class="button-secondary" name="generate-new-url" value="<?php _e( 'Generate New URL', 'send-system-info' ) ?>" />

		<?php
	}

}