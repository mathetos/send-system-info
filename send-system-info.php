<?php
/**
 * Plugin Name: Send System Info
 * Plugin URI: http://johnregan3.github.io/send-system-info
 * Description: Displays System Info for debugging.  This info can be emailed and/or displayed to support personnel via unique URL.
 * Version: 1.0
 * Author: johnregan3
 * Author URI: http://johnregan3.me
 * License: GPLv2+
 * textdomain: send-system-info
 */

/**
 * Copyright (c) 2014 John Regan (http://johnregan3.me/)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * System Info textarea based on Easy Digital Downloads by Pippin Williamson.
 * http://easydigitaldownloads.com/
 *
 * @package SSI
 * @author  John Regan
 * @version 1.0
 */

include( 'includes/email.php' );
include( 'includes/viewer.php' );
include( 'includes/browser.php' );

class Send_System_Info_Plugin {

	/**
	 * Load hooks
	 *
	 * @since  1.0
	 * @action plugins_loaded
	 *
	 * @return void
	 */
	static function setup() {
		register_activation_hook( __FILE__, array( __CLASS__, 'generate_url' ) );
		register_uninstall_hook( __FILE__, array( __CLASS__, 'uninstall' ) );
		add_action( 'admin_menu', array( __CLASS__, 'register_submenu_page' ) );
		add_action( 'wp_ajax_regenerate_url', array( __CLASS__, 'generate_url' ) );
		add_action( 'template_redirect', array( 'Send_System_Info_Viewer', 'remote_view' ) );
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( __CLASS__, 'action_link' ) );
	}


	/**
	 * Print direct link to Send System Info page from Plugins Page
	 *
	 * @since  1.0
	 * @filter plugin_action_links_
	 *
	 * @param  array  Array of links
	 * @return array  Updated Array of links
	 */
	static function action_link( $links ) {
		$links[] = '<a href="' . admin_url( 'tools.php?page=send-system-info.php' ) . '">' . __( 'View System Info', 'send-system-info' ) . '</a>';
		return $links;
	}


	/**
	 * Enqueue Javascript
	 *
	 * @since  1.0
	 * @action admin_print_scripts-
	 *
	 * @return void
	 */
	static function enqueue_js() {
		wp_register_script( 'ssi-script', plugins_url( '/includes/send-system-info.js', __FILE__ ), array( 'jquery' ) );
		wp_localize_script( 'ssi-script', 'systemInfoAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script( 'ssi-script' );
	}


	/**
	 * Enqueue CSS
	 *
	 * @since  1.0
	 * @action admin_print_styles-
	 *
	 * @return void
	 */
	static function enqueue_css() {
		wp_enqueue_style( 'ssi-style', plugins_url( '/includes/style.css', __FILE__ ) );
	}


	/**
	 * Register submenu page and enqueue styles and scripts.
	 * Only viewable by Administrators
	 *
	 * @since  1.0
	 * @action admin_menu
	 *
	 * @return void
	 */
	static function register_submenu_page() {
		$page = add_submenu_page(
			'tools.php',
			__( 'System Info', 'send-system-info' ),
			__( 'Send System Info', 'send-system-info' ),
			'manage_options',
			'send-system-info',
			array( __CLASS__, 'render_info' )
		);

		//Enqueue scripts and styles on the Plugin Settings page only
		add_action( 'admin_print_styles-' . $page, array( __CLASS__, 'enqueue_css' ) );
		add_action( 'admin_print_scripts-' . $page, array( __CLASS__, 'enqueue_js' ) );
	}


	/**
	 * Render plugin page title, information and info textarea
	 *
	 * @since  1.0
	 *
	 * @return void
	 */
	static function render_info() {

		$email_sent = Send_System_Info_Email::send_email();
		if ( $email_sent && 'sent' == $email_sent ) : ?>
			<div id="message" class="updated"><p><?php _e( 'Email sent successfully.', 'send-system-info' ); ?></p></div>
		<?php elseif ( $email_sent && 'error' == $email_sent ) : ?>
			<div id="message" class="error"><p><?php _e( 'Error sending Email.', 'send-system-info' ); ?></p></div>
		<?php endif; ?>

		<div class="wrap">
			<h2 class="ssi-title"><?php _e( 'Send System Info', 'send-system-info' ); ?></h2>
				<div id="templateside">
					<p class="instructions"><?php _e( 'Send System Info displays data useful to support personnel.  This information can be sent via email using the from below.', 'send-system-info' ) ?></p>
					<p class="instructions"><?php _e( 'Additionally, a URL can be given to your support provider to allow them to view this information at any time.  This access can be revoked by generating a new URL.  This link may be handy to use in support forums, as access to this information can be removed after you recieve the help you need.', 'send-system-info' ) ?></p>
				</div>
				<div id="template">
					<?php // Form used to download .txt file ?>
					<form action="<?php echo plugins_url( 'includes/download.php', __FILE__ ) //xss okay ?>" method="post" enctype="multipart/form-data" >
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
	<?php

	}


	/**
	 * Gather data, then generate System Info
	 *
	 * Based on System Info sumbmenu page in Easy Digital Downloads
	 * by Pippin Williamson
	 *
	 * @since  1.0
	 *
	 * @return void
	 */
	static function display( $return = false ) {

		$browser = new Browser();
		if ( get_bloginfo( 'version' ) < '3.4' ) {
			$theme_data = get_theme_data( get_stylesheet_directory() . '/style.css' );
			$theme      = $theme_data['Name'] . ' ' . $theme_data['Version'];
		} else {
			$theme_data = wp_get_theme();
			$theme      = $theme_data->Name . ' ' . $theme_data->Version;
		}

		// Try to identifty the hosting provider
		$host = false;
		if ( defined( 'WPE_APIKEY' ) ) {
			$host = 'WP Engine';
		} elseif ( defined( 'PAGELYBIN' ) ) {
			$host = 'Pagely';
		}

		$request['cmd'] = '_notify-validate';

		$params = array(
			'sslverify' => false,
			'timeout'   => 60,
			'body'      => $request,
		);

		$response = wp_remote_post( 'https://www.paypal.com/cgi-bin/webscr', $params );

		if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
			$WP_REMOTE_POST = 'wp_remote_post() works' . "\n";
		} else {
			$WP_REMOTE_POST = 'wp_remote_post() does not work' . "\n";
		}

		if ( $return ) {
			return self::display_output( $browser, $theme, $host, $WP_REMOTE_POST );
		} else {
			echo esc_html( self::display_output( $browser, $theme, $host, $WP_REMOTE_POST ) );
		}
	}


	/**
	 * Render System Info
	 * Non-standard indentation required for plain-text display
	 *
	 * Based on System Info sumbmenu page in Easy Digital Downloads
	 * by Pippin Williamson
	 *
	 * @since  1.0
	 *
	 * @param   string  Browser information
	 * @param   string  Theme Data
	 * @param   string  Theme name
	 * @param   string  Host
	 * @param   string  WP Remote Host
	 * @return  string  Output of System Info display
	 */
	//Render Info Display
	static function display_output( $browser, $theme, $host, $WP_REMOTE_POST ) {
		global $wpdb;
		ob_start(); ?>
// Generated by the Send System Info Plugin //

Multisite:                <?php echo is_multisite() ? 'Yes' . "\n" : 'No' . "\n" ?>

SITE_URL:                 <?php echo site_url() . "\n"; ?>
HOME_URL:                 <?php echo home_url() . "\n"; ?>

WordPress Version:        <?php echo get_bloginfo( 'version' ) . "\n"; ?>
Permalink Structure:      <?php echo get_option( 'permalink_structure' ) . "\n"; ?>
Active Theme:             <?php echo $theme . "\n"; ?>
<?php if( $host ) : ?>
Host:                     <?php echo $host . "\n"; ?>
<?php endif; ?>

Registered Post Stati:    <?php echo implode( ', ', get_post_stati() ) . "\n\n"; ?>
<?php if ( isset( $_GET['systeminfo'] ) ) {
	echo '// Browser of Current Viewer //';
	echo "\r\n\r\n";
} ?>
<?php echo $browser ; ?>
<?php if ( isset( $_GET['systeminfo'] ) ) {
	echo "\r\n";
	echo '// End Browser of Current Viewer //';
	echo "\r\n\r\n";
} ?>

PHP Version:              <?php echo PHP_VERSION . "\n"; ?>
MySQL Version:            <?php echo mysql_get_server_info() . "\n"; ?>
Web Server Info:          <?php echo $_SERVER['SERVER_SOFTWARE'] . "\n"; ?>

WordPress Memory Limit:   <?php echo ( self::let_to_num( WP_MEMORY_LIMIT )/( 1024 ) )."MB"; ?><?php echo "\n"; ?>
PHP Safe Mode:            <?php echo ini_get( 'safe_mode' ) ? "Yes" : "No\n"; ?>
PHP Memory Limit:         <?php echo ini_get( 'memory_limit' ) . "\n"; ?>
PHP Upload Max Size:      <?php echo ini_get( 'upload_max_filesize' ) . "\n"; ?>
PHP Post Max Size:        <?php echo ini_get( 'post_max_size' ) . "\n"; ?>
PHP Upload Max Filesize:  <?php echo ini_get( 'upload_max_filesize' ) . "\n"; ?>
PHP Time Limit:           <?php echo ini_get( 'max_execution_time' ) . "\n"; ?>
PHP Max Input Vars:       <?php echo ini_get( 'max_input_vars' ) . "\n"; ?>
PHP Arg Separator:        <?php echo ini_get( 'arg_separator.output' ) . "\n"; ?>
PHP Allow URL File Open:  <?php echo ini_get( 'allow_url_fopen' ) ? "Yes" : "No\n"; ?>

WP_DEBUG:                 <?php echo defined( 'WP_DEBUG' ) ? WP_DEBUG ? 'Enabled' . "\n" : 'Disabled' . "\n" : 'Not set' . "\n" ?>

WP Table Prefix:          <?php echo 'Length: ' . strlen( $wpdb->prefix ); echo ' Status:'; if ( strlen( $wpdb->prefix ) >16 ) { echo ' ERROR: Too Long'; } else { echo ' Acceptable'; } echo "\n"; ?>

Show On Front:            <?php echo get_option( 'show_on_front' ) . "\n" ?>
Page On Front:            <?php $id = get_option( 'page_on_front' ); echo get_the_title( $id ) . ' (#' . $id . ')' . "\n" ?>
Page For Posts:           <?php $id = get_option( 'page_for_posts' ); echo get_the_title( $id ) . ' (#' . $id . ')' . "\n" ?>

WP Remote Post:           <?php echo $WP_REMOTE_POST; ?>

Session:                  <?php echo isset( $_SESSION ) ? 'Enabled' : 'Disabled'; ?><?php echo "\n"; ?>
Session Name:             <?php echo esc_html( ini_get( 'session.name' ) ); ?><?php echo "\n"; ?>
Cookie Path:              <?php echo esc_html( ini_get( 'session.cookie_path' ) ); ?><?php echo "\n"; ?>
Save Path:                <?php echo esc_html( ini_get( 'session.save_path' ) ); ?><?php echo "\n"; ?>
Use Cookies:              <?php echo ini_get( 'session.use_cookies' ) ? 'On' : 'Off'; ?><?php echo "\n"; ?>
Use Only Cookies:         <?php echo ini_get( 'session.use_only_cookies' ) ? 'On' : 'Off'; ?><?php echo "\n"; ?>

DISPLAY ERRORS:           <?php echo ( ini_get( 'display_errors' ) ) ? 'On (' . ini_get( 'display_errors' ) . ')' : 'N/A'; ?><?php echo "\n"; ?>
FSOCKOPEN:                <?php echo ( function_exists( 'fsockopen' ) ) ? 'Your server supports fsockopen.' : 'Your server does not support fsockopen.'; ?><?php echo "\n"; ?>
cURL:                     <?php echo ( function_exists( 'curl_init' ) ) ? 'Your server supports cURL.' : 'Your server does not support cURL.'; ?><?php echo "\n"; ?>
SOAP Client:              <?php echo ( class_exists( 'SoapClient' ) ) ? 'Your server has the SOAP Client enabled.' : 'Your server does not have the SOAP Client enabled.'; ?><?php echo "\n"; ?>
SUHOSIN:                  <?php echo ( extension_loaded( 'suhosin' ) ) ? 'Your server has SUHOSIN installed.' : 'Your server does not have SUHOSIN installed.'; ?><?php echo "\n"; ?>

ACTIVE PLUGINS:

<?php $plugins = get_plugins();
$active_plugins = get_option( 'active_plugins', array() );

foreach ( $plugins as $plugin_path => $plugin ) {
	// If the plugin isn't active, don't show it.
	if ( ! in_array( $plugin_path, $active_plugins ) )
		continue;

	echo $plugin['Name'] . ': ' . $plugin['Version'] ."\n";
}

if ( is_multisite() ) : ?>

NETWORK ACTIVE PLUGINS:

	<?php $plugins  = wp_get_active_network_plugins();
	$active_plugins = get_site_option( 'active_sitewide_plugins', array() );

	foreach ( $plugins as $plugin_path ) {
		$plugin_base = plugin_basename( $plugin_path );

		// If the plugin isn't active, don't show it.
		if ( ! array_key_exists( $plugin_base, $active_plugins ) )
			continue;

		$plugin = get_plugin_data( $plugin_path );

echo $plugin['Name'] . ' :' . $plugin['Version'] ."\n";
	}
endif;

		$output = ob_get_clean();
		return $output;
}


	/**
	 * Size Conversions
	 *
	 * @author Chris Christoff
	 * @since 1.0
	 *
	 * @param  unknown    $v
	 * @return int|string
	 */
	static function let_to_num( $v ) {
		$l   = substr( $v, -1 );
		$ret = substr( $v, 0, -1 );

		switch ( strtoupper( $l ) ) {
			case 'P': // fall-through
			case 'T': // fall-through
			case 'G': // fall-through
			case 'M': // fall-through
			case 'K': // fall-through
				$ret *= 1024;
				break;
			default:
				break;
		}

		return $ret;
	}


	/**
	 * Generate Random URL for the remote view.
	 * Saves result to options.  If it's an ajax request
	 * the new query value is sent back to the js script.
	 *
	 * @since  1.0
	 * @action wp_ajax_regenerate_url
	 *
	 * @return void
	 */
	static function generate_url() {
		$alphabet    = 'abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789';
		$value       = array();
		$alphaLength = strlen( $alphabet ) - 1;
		for ( $i = 0; $i < 32; $i++ ) {
			$n     = rand( 0, $alphaLength );
			$value[] = $alphabet[$n];
		}
		$value = implode( $value );
		update_option( 'system_info_remote_url', $value );
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			$output = home_url() . '/?systeminfo=' . $value;
			wp_send_json( $output );
		}
	}


	/**
	 * Delete URL option on uninstall.
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	static function uninstall() {
		delete_option( 'system_info_remote_url' );
	}

}
//Load Plugin on 'plugins_loaded'
add_action( 'plugins_loaded', array( 'Send_System_Info_Plugin', 'setup' ) );