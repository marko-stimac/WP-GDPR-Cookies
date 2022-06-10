# WP-GDPR-Cookies

WordPress plugin for cookie notice and conditionally including JS functions like Google Analytics. A few things should be manually adjusted since this plugin is for me just a faster way to add functionality to other websites I create.

## How to use

Requirements: ACF PRO plugin, Bootstrap 5: modal, nav-pills (nav), custom switches (forms->form check)

1. In the admin add your content under GDPR menu
2. Include shortcode [btn-cookie-policy] where you want in the footer so user can reopen cookie settings at any time
3. Insert logo in the plugin class-frontend.php@showComponent if you want and perhaps change or override color variables in CSS to customize the look