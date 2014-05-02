<?php
/**
 * Handles Remote Viewing of System Info
 *
 * @package     SSI
 * @subpackage  Classes/Viewer
 * @author      John Regan
 * @since       1.0
 */
class Send_System_Info_Viewer {


	/**
	 * Renders Remote Viewing portion of Plugin Settings Page
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	static function remote_viewing_section() {
		$value = get_option( 'system_info_remote_url' );
		$url   = home_url() . '/?systeminfo=' . $value;
		?>
		<p><?php _e( 'Users with this URL can view a plain-text version of your System Info.<br />Generating a new URL will void access to all who have the existing URL.', 'send-system-info' ) ?></p>
		<p><input type="text" readonly="readonly" class="ssi-url ssi-url-text" onclick="this.focus();this.select()" value="<?php echo esc_url( $url ) ?>" title="<?php _e( 'To copy the System Info, click below then press Ctrl + C (PC) or Cmd + C (Mac).', 'send-system-info' ); ?>" />&nbsp;&nbsp;<a href="<?php echo esc_url( $url ) ?>" target="_blank" class="ssi-tiny ssi-url-text-link"><?php _e( 'test url', 'send-system-info' ) ?></a></p>
		<p class="submit">
			<input type="submit" onClick="return false;" class="button-secondary" name="generate-new-url" value="<?php _e( 'Generate New URL', 'send-system-info' ) ?>" />
		</p>
		<?php
	}


	/**
	 * Renders Remote View using $_GET value
	 *
	 * @since   1.0
	 * @action  template_redirect
	 *
	 * @return  void
	 */
	static function remote_view() {

		if ( ! isset( $_GET['systeminfo'] ) || empty( $_GET['systeminfo'] ) ) {
			return;
		}

		$query_value = $_GET['systeminfo'];
		$value       = get_option( 'system_info_remote_url' );

		echo '<pre>';
		if ( $query_value == $value ) {
			Send_System_Info_Plugin::display();
			exit();
		} else {
			exit( 'Invalid System Info URL.' );
		}
		echo '</pre>';
	}

}