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
		    else {
			    $active_tab = "send-as-text";
            }
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

		if($_GET["tab"] == "send-as-text") { ?>
            <header>
                <h3 class="ssi-text-title"><?php _e( 'Send as Text', 'send-system-info' ) ?></h3>
                <p><?php echo __('Here you can copy your System Info by clicking in the text area. Or download your System Info as a text file with the button.', 'send-system-info'); ?></p>
            </header>
            <form action="<?php echo esc_url( get_admin_url( 'admin-ajax.php' ) ); ?>" method="post" enctype="multipart/form-data" >
                <input type="hidden" name="action" value="download_system_info" />
                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e( 'Download System Info as Text File', 'send-system-info' ) ?>" />
                </p>
                <div>
                            <textarea readonly="readonly" onclick="this.focus();this.select()" id="ssi-textarea" name="send-system-info-textarea" title="<?php _e( 'To copy the System Info, click below then press Ctrl + C (PC) or Cmd + C (Mac).', 'send-system-info' ); ?>">
                            <?php //Non standard indentation needed for plain-text display ?>
                            <?php echo esc_html( Send_System_Info_Plugin::display() ) ?>
                            </textarea>
                </div>
            </form>
        <?php
		}
        elseif($_GET["tab"] == "send-as-email") { ?>
            <?php Send_System_Info_Email::email_form_section() ?>
        <?php
		}
        elseif($_GET["tab"] == "send-as-url") { ?>
            <?php Send_System_Info_Viewer::remote_viewing_section() ?>
        <?php
        }
        echo '</div>';
        $output = ob_get_clean();

		return $output;

}

//add_action('admin_init', 'ssi_display_tab_content');
