<?php
/**
 * Plugin Name: Programmatic SEO
 * Plugin URI: https://github.com/tootranmmo/programmaticSEOs
 * Description: Tạo hàng loạt trang SEO tự động từ template và dữ liệu. Tối ưu SEO với meta tags, schema markup và internal linking.
 * Version: 1.0.2
 * Author: Your Name
 * Author URI: https://github.com/tootranmmo
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: programmatic-seo
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.2
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Plugin version
 */
define('PSEO_VERSION', '1.0.2');
define('PSEO_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PSEO_PLUGIN_URL', plugin_dir_url(__FILE__));
define('PSEO_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Activation hook
 */
function activate_programmatic_seo() {
    require_once PSEO_PLUGIN_DIR . 'includes/class-pseo-activator.php';
    PSEO_Activator::activate();
}

/**
 * Deactivation hook
 */
function deactivate_programmatic_seo() {
    require_once PSEO_PLUGIN_DIR . 'includes/class-pseo-deactivator.php';
    PSEO_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_programmatic_seo');
register_deactivation_hook(__FILE__, 'deactivate_programmatic_seo');

/**
 * Core plugin class
 */
require_once PSEO_PLUGIN_DIR . 'includes/class-pseo-core.php';

/**
 * Begin execution
 */
function run_programmatic_seo() {
    $plugin = new PSEO_Core();
    $plugin->run();
}
run_programmatic_seo();
