=== Send System Info ===
Contributors: webdevmattcrom, shelob9, benmeredithgmailcom
Donate Link: https://www.paypal.me/MattCromwell
Tags: support, system, version, php, php version,
Requires at least: 4.2
Tested up to: 4.8
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Send Information about your WP install, Server, and Browser to Support personnel.

== Description ==

Send System Info is a handy WordPress plugin that displays System Information for debugging. This information can be downloaded as a .txt file, sent via email directly from the plugin, and/or remotely viewed via generated URL.  This plugin is a must-recommend for those who deal with support every day.

This plugin displays WordPress, Server and Browser information, including fields like PHP version, active plugins, current browser, etc.  It also tests for FSOCKOPEN, cURL, SOAP client, as well as many other features.

**Plugin Features**

* Quickly and easily presents a snapshot of the user's site configuration
* Send System Info via email
* Download System Info as .txt file
* Option to allow remote viewing of System Information
* Multisite Support

**Full List of Information Displayed**

* Multisite
* SITE_URL
* HOME_URL
* WordPress Version
* Permalink Structure
* Active Theme
* Registered Post Stati
* Platform
* Browser Name
* Browser Version
* User Agent String
* PHP Version
* MySQL Version
* Web Server Info
* WordPress Memory Limit
* PHP Safe Mode
* PHP Memory Limit
* PHP Upload Max Size
* PHP Post Max Size
* PHP Upload Max Filesize
* PHP Time Limit
* PHP Max Input Vars
* PHP Arg Separator
* PHP Allow URL File Open
* WP_DEBUG
* WP Table Prefix
* Show On Front
* Page On Front
* Page For Posts
* WP Remote Post
* Session
* Session Name
* Cookie Path
* Save Path
* Use Cookies
* Use Only Cookies
* DISPLAY ERRORS
* FSOCKOPEN
* cURL
* SOAP Client
* SUHOSIN
* ACTIVE PLUGINS
* NETWORK ACTIVE PLUGINS

**Contribute to Send System Info**

[Send System Info on GitHub](https://github.com/mathetos/send-system-info "Send System Info on GitHub")

== Installation ==

Install Send System Info just as you would any other WP Plugin:

1.  [Download Send System Info](http://wordpress.org/plugins/send-system-info "Send System Info") from WordPress.org.

2.  Unzip the .zip file.

3.  Upload the Plugin folder (send-system-info/) to the wp-content/plugins folder.

4. Go to [Plugins Admin Panel](http://codex.wordpress.org/Administration_Panels#Plugins "Plugins Admin Panel") and find the newly uploaded Plugin, "Send System Info" in the list.

5. Click Activate Plugin to activate it.

[More help installing Plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins "WordPress Codex: Installing Plugins")

After installation and activation, this plugin's administration screen can be found under Tools > Send System Info.

== Screenshots ==

1. The Send System Info "Send as Text" Screen (Tools > Send System Info)
2. The "Send as Email" screen (Tools > Send System Info > Send as Email)
3. The "Send as URL" Screen and the actions available (Tools > Send System Info > Send as URL)

== Changelog ==

= 1.3 (October 11, 2017) =
* ADOPTION DAY: [Matt Cromwell](https://www.mattcromwell.com) has officially adopted Send System Info and will be maintaining it and developing it further. See [issues on Github](https://github.com/mathetos/send-system-info/issues) to contribute.
* NEW: New tabbed interface and general UI clean-up ([Issue #10](https://github.com/mathetos/send-system-info/issues/10))
* NEW: Delete the generated URL with a click of a button ([Issue #14](https://github.com/mathetos/send-system-info/issues/14))
* NEW: Added filters to paths for view for plugin authors to extend the views. Thanks Josh! ([PR #7](https://github.com/mathetos/send-system-info/pull/7))

= 1.1 =
* Updating method for determining MySQL version
* Minor Bugfixes

= 1.0 =
* Inital Release

== Upgrade Notice ==

= 1.1 =
* Updating method for determining MySQL version
* Minor Bugfixes

= 1.0 =
* Inital Release