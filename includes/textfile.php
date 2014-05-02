<?php

if ( ! isset( $_POST['send-system-info-textarea'] ) || empty( $_POST['send-system-info-textarea'] ) ) {
	return;
}

header( 'Content-type: text/plain' );
header( 'Content-Disposition: attachment; filename=systeminfo-' . time() . '.txt' );

echo $_POST['send-system-info-textarea'];
?>