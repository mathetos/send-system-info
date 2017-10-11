<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 10/11/2017
 * Time: 01:08 PM
 */

?>

<header>
	<h3 class="ssi-text-title"><?php _e( 'Send as Text', 'send-system-info' ) ?></h3>
	<p><?php echo __('Here you can copy your System Info by clicking in the text area. Or download your System Info as a text file with the button.', 'send-system-info'); ?></p>
</header>
<form action="<?php echo esc_url( self_admin_url( 'admin-ajax.php' ) ); ?>" method="post" enctype="multipart/form-data" >
	<input type="hidden" name="action" value="download_system_info" />

	<div>
        <textarea readonly="readonly" onclick="this.focus();this.select()" id="ssi-textarea" name="send-system-info-textarea" title="<?php _e( 'To copy the System Info, click below then press Ctrl + C (PC) or Cmd + C (Mac).', 'send-system-info' ); ?>">
        <?php //Non standard indentation needed for plain-text display ?>
        <?php echo esc_html( Send_System_Info_Plugin::display() ) ?>
        </textarea>
	</div>

	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e( 'Download System Info as Text File', 'send-system-info' ) ?>" />
	</p>
</form>
