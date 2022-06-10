<?php
/*
 * Plugin Name: WP GDPR Cookies
 * Description: Cookie conditional injection for maximum GDPR compliance
 * Version: 1.0.0
 * Author: Marko Štimac
 * Author URI: https://marko-stimac.github.io/
 * Text Domain: ms
 */

namespace ms\CookieNotice;

defined('ABSPATH') || exit;

require_once 'includes/class-backend.php';
require_once 'includes/class-frontend.php';

new Backend();
$cookie_notice = new Frontend();
add_action('wp_footer', array($cookie_notice, 'showComponent'));