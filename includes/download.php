<?php
/**
 * Generates Text file download
 *
 * @since  1.0
 */

if ( ! isset( $_POST['send-system-info-textarea'] ) || empty( $_POST['send-system-info-textarea'] ) ) {
	return;
}

header( 'Content-type: text/plain' );

//Text file name marked with Unix timestamp
header( 'Content-Disposition: attachment; filename=systeminfo-' . time() . '.txt' );

echo $_POST['send-system-info-textarea'];
?>