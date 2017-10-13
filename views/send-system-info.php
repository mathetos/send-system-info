<div class="wrap">

        <h1 class="ssi-title"><?php _e( 'Send System Info', 'send-system-info' ); ?></h1>

	    <?php
	    //we check if the page is visited by click on the tabs or on the menu button.
	    //then we get the active tab.
	    $active_tab = "header-options";

	    if(isset($_GET["tab"])) {
		    if($_GET["tab"] == "send-as-text") {
			    $active_tab = "send-as-text";
		    }
		    elseif($_GET["tab"] == "send-as-email") {
			    $active_tab = "send-as-email";
		    }
		    elseif($_GET["tab"] == "send-as-url") {
			    $active_tab = "send-as-url";
		    }
	    } else {
		    $active_tab = "send-as-text";
	    }
	    ?>
        <h2 class="nav-tab-wrapper">
            <!-- when tab buttons are clicked we jump back to the same page but with a new parameter that represents the clicked tab. accordingly we make it active -->
            <a href="?page=send-system-info.php&tab=send-as-text" class="nav-tab <?php if($active_tab == 'send-as-text'){echo 'nav-tab-active';} ?> "><?php _e('Send as Text', 'send-system-info'); ?></a>
            <a href="?page=send-system-info.php&tab=send-as-email" class="nav-tab <?php if($active_tab == 'send-as-email'){echo 'nav-tab-active';} ?>"><?php _e('Send as Email', 'send-system-info'); ?></a>
            <a href="?page=send-system-info.php&tab=send-as-url" class="nav-tab <?php if($active_tab == 'send-as-url'){echo 'nav-tab-active';} ?>"><?php _e('Send as URL', 'send-system-info'); ?></a>
        </h2>

        <div class="ssi_options">
            <?php echo ssi_display_tab_content(); ?>
        </div>

</div>

<?php

function ssi_display_tab_content() {
        ob_start();
        echo '<div id="template">';
        $tab = ( !empty($_GET["tab"]) ? $_GET["tab"] : 'send-as-text' );

	    $path = SSI_VIEWS_DIR . 'send-as-text-page.php';

		if( $tab == "send-as-text") {

            $path = apply_filters( 'ssi_send_as_text_page_path', $path );

            include( $path );
		}
        elseif( $tab == "send-as-email") { ?>
            <?php Send_System_Info_Email::email_form_section() ?>
        <?php
		}
        elseif( $tab == "send-as-url") { ?>
            <?php Send_System_Info_Viewer::remote_viewing_section() ?>
        <?php
        }
        echo '</div>';
        $output = ob_get_clean();

		return $output;

}