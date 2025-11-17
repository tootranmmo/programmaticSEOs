<?php
/**
 * Core plugin class
 */

if (!defined('ABSPATH')) {
    exit;
}

class PSEO_Core {

    /**
     * Plugin loader
     */
    protected $loader;

    /**
     * Plugin version
     */
    protected $version;

    /**
     * Initialize the plugin
     */
    public function __construct() {
        $this->version = PSEO_VERSION;
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load required dependencies
     */
    private function load_dependencies() {
        // Admin class
        require_once PSEO_PLUGIN_DIR . 'admin/class-pseo-admin.php';

        // Core functionality classes
        require_once PSEO_PLUGIN_DIR . 'includes/class-pseo-template.php';
        require_once PSEO_PLUGIN_DIR . 'includes/class-pseo-data-importer.php';
        require_once PSEO_PLUGIN_DIR . 'includes/class-pseo-page-generator.php';
        require_once PSEO_PLUGIN_DIR . 'includes/class-pseo-seo-optimizer.php';
    }

    /**
     * Register admin hooks
     */
    private function define_admin_hooks() {
        $admin = new PSEO_Admin($this->version);

        add_action('admin_menu', array($admin, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($admin, 'enqueue_styles'));
        add_action('admin_enqueue_scripts', array($admin, 'enqueue_scripts'));

        // AJAX handlers
        add_action('wp_ajax_pseo_get_template', array($admin, 'ajax_get_template'));
        add_action('wp_ajax_pseo_save_template', array($admin, 'ajax_save_template'));
        add_action('wp_ajax_pseo_delete_template', array($admin, 'ajax_delete_template'));
        add_action('wp_ajax_pseo_duplicate_template', array($admin, 'ajax_duplicate_template'));
        add_action('wp_ajax_pseo_export_template', array($admin, 'ajax_export_template'));
        add_action('wp_ajax_pseo_import_template', array($admin, 'ajax_import_template'));
        add_action('wp_ajax_pseo_preview_template', array($admin, 'ajax_preview_template'));
        add_action('wp_ajax_pseo_import_data', array($admin, 'ajax_import_data'));
        add_action('wp_ajax_pseo_generate_pages', array($admin, 'ajax_generate_pages'));
        add_action('wp_ajax_pseo_get_analytics', array($admin, 'ajax_get_analytics'));
    }

    /**
     * Register public hooks
     */
    private function define_public_hooks() {
        $seo_optimizer = new PSEO_SEO_Optimizer();

        add_action('wp_head', array($seo_optimizer, 'output_meta_tags'));
        add_action('wp_head', array($seo_optimizer, 'output_schema_markup'));
        add_filter('the_content', array($seo_optimizer, 'add_internal_links'));
    }

    /**
     * Run the plugin
     */
    public function run() {
        // Plugin is ready
    }

    /**
     * Get plugin version
     */
    public function get_version() {
        return $this->version;
    }
}
