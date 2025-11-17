<?php
/**
 * Admin area functionality
 */

if (!defined('ABSPATH')) {
    exit;
}

class PSEO_Admin {

    /**
     * Plugin version
     */
    private $version;

    /**
     * Initialize the class
     */
    public function __construct($version) {
        $this->version = $version;
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            'Programmatic SEO',
            'Programmatic SEO',
            'manage_options',
            'programmatic-seo',
            array($this, 'display_dashboard'),
            'dashicons-admin-page',
            30
        );

        add_submenu_page(
            'programmatic-seo',
            'Dashboard',
            'Dashboard',
            'manage_options',
            'programmatic-seo',
            array($this, 'display_dashboard')
        );

        add_submenu_page(
            'programmatic-seo',
            'Templates',
            'Templates',
            'manage_options',
            'pseo-templates',
            array($this, 'display_templates')
        );

        add_submenu_page(
            'programmatic-seo',
            'Data Import',
            'Data Import',
            'manage_options',
            'pseo-data-import',
            array($this, 'display_data_import')
        );

        add_submenu_page(
            'programmatic-seo',
            'Generate Pages',
            'Generate Pages',
            'manage_options',
            'pseo-generate',
            array($this, 'display_page_generator')
        );

        add_submenu_page(
            'programmatic-seo',
            'Analytics',
            'Analytics',
            'manage_options',
            'pseo-analytics',
            array($this, 'display_analytics')
        );
    }

    /**
     * Enqueue admin styles
     */
    public function enqueue_styles($hook) {
        if (strpos($hook, 'programmatic-seo') === false && strpos($hook, 'pseo-') === false) {
            return;
        }

        // Bootstrap 4 CSS
        wp_enqueue_style(
            'bootstrap',
            'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css',
            array(),
            '4.6.2'
        );

        // Font Awesome
        wp_enqueue_style(
            'font-awesome',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css',
            array(),
            '5.15.4'
        );

        // Custom admin CSS
        wp_enqueue_style(
            'pseo-admin-style',
            PSEO_PLUGIN_URL . 'admin/css/admin-style.css',
            array(),
            $this->version
        );
    }

    /**
     * Enqueue admin scripts
     */
    public function enqueue_scripts($hook) {
        if (strpos($hook, 'programmatic-seo') === false && strpos($hook, 'pseo-') === false) {
            return;
        }

        // Bootstrap 4 JS
        wp_enqueue_script(
            'bootstrap',
            'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js',
            array('jquery'),
            '4.6.2',
            true
        );

        // Chart.js for analytics
        wp_enqueue_script(
            'chartjs',
            'https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js',
            array(),
            '3.9.1',
            true
        );

        // Custom admin JS
        wp_enqueue_script(
            'pseo-admin-script',
            PSEO_PLUGIN_URL . 'admin/js/admin-script.js',
            array('jquery', 'bootstrap'),
            $this->version,
            true
        );

        // Localize script
        wp_localize_script('pseo-admin-script', 'pseoAdmin', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('pseo_nonce'),
            'strings' => array(
                'confirm_delete' => __('Are you sure you want to delete this item?', 'programmatic-seo'),
                'saving' => __('Saving...', 'programmatic-seo'),
                'success' => __('Success!', 'programmatic-seo'),
                'error' => __('Error occurred!', 'programmatic-seo')
            )
        ));
    }

    /**
     * Display dashboard page
     */
    public function display_dashboard() {
        require_once PSEO_PLUGIN_DIR . 'admin/views/dashboard.php';
    }

    /**
     * Display templates page
     */
    public function display_templates() {
        require_once PSEO_PLUGIN_DIR . 'admin/views/templates.php';
    }

    /**
     * Display data import page
     */
    public function display_data_import() {
        require_once PSEO_PLUGIN_DIR . 'admin/views/data-import.php';
    }

    /**
     * Display page generator
     */
    public function display_page_generator() {
        require_once PSEO_PLUGIN_DIR . 'admin/views/page-generator.php';
    }

    /**
     * Display analytics page
     */
    public function display_analytics() {
        require_once PSEO_PLUGIN_DIR . 'admin/views/analytics.php';
    }

    /**
     * AJAX: Save template
     */
    public function ajax_save_template() {
        check_ajax_referer('pseo_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }

        $template = new PSEO_Template();
        $result = $template->save($_POST);

        if ($result) {
            wp_send_json_success(array('message' => 'Template saved successfully'));
        } else {
            wp_send_json_error('Failed to save template');
        }
    }

    /**
     * AJAX: Get template
     */
    public function ajax_get_template() {
        check_ajax_referer('pseo_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }

        $template_id = intval($_POST['template_id']);
        $template = new PSEO_Template();
        $result = $template->get($template_id);

        if ($result) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error('Template not found');
        }
    }

    /**
     * AJAX: Delete template
     */
    public function ajax_delete_template() {
        check_ajax_referer('pseo_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }

        $template_id = intval($_POST['template_id']);
        $template = new PSEO_Template();
        $result = $template->delete($template_id);

        if ($result) {
            wp_send_json_success(array('message' => 'Template deleted successfully'));
        } else {
            wp_send_json_error('Failed to delete template');
        }
    }

    /**
     * AJAX: Import data
     */
    public function ajax_import_data() {
        check_ajax_referer('pseo_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }

        $importer = new PSEO_Data_Importer();
        $result = $importer->import($_FILES['data_file']);

        if ($result['success']) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error($result['message']);
        }
    }

    /**
     * AJAX: Generate pages
     */
    public function ajax_generate_pages() {
        check_ajax_referer('pseo_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }

        $generator = new PSEO_Page_Generator();
        $result = $generator->generate($_POST);

        if ($result['success']) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error($result['message']);
        }
    }

    /**
     * AJAX: Get analytics
     */
    public function ajax_get_analytics() {
        check_ajax_referer('pseo_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }

        global $wpdb;
        $table = $wpdb->prefix . 'pseo_generated_pages';

        $stats = array(
            'total_pages' => $wpdb->get_var("SELECT COUNT(*) FROM $table"),
            'total_views' => $wpdb->get_var("SELECT SUM(views) FROM $table"),
            'total_clicks' => $wpdb->get_var("SELECT SUM(clicks) FROM $table")
        );

        wp_send_json_success($stats);
    }
}
