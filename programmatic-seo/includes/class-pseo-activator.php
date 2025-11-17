<?php
/**
 * Plugin activation
 */

if (!defined('ABSPATH')) {
    exit;
}

class PSEO_Activator {

    /**
     * Activate plugin
     */
    public static function activate() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        // Table for templates
        $table_templates = $wpdb->prefix . 'pseo_templates';
        $sql_templates = "CREATE TABLE IF NOT EXISTS $table_templates (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            description text,
            title_template text NOT NULL,
            content_template longtext NOT NULL,
            meta_description_template text,
            slug_pattern varchar(255),
            post_type varchar(50) DEFAULT 'page',
            status varchar(20) DEFAULT 'active',
            variables text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";

        // Table for data sources
        $table_data_sources = $wpdb->prefix . 'pseo_data_sources';
        $sql_data_sources = "CREATE TABLE IF NOT EXISTS $table_data_sources (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            file_name varchar(255),
            file_path varchar(500),
            file_type varchar(50),
            total_rows int(11) DEFAULT 0,
            columns text,
            status varchar(20) DEFAULT 'active',
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";

        // Table for generated pages
        $table_generated_pages = $wpdb->prefix . 'pseo_generated_pages';
        $sql_generated_pages = "CREATE TABLE IF NOT EXISTS $table_generated_pages (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            post_id bigint(20) UNSIGNED NOT NULL,
            template_id bigint(20) UNSIGNED NOT NULL,
            data_source_id bigint(20) UNSIGNED NOT NULL,
            data_row_index int(11),
            views int(11) DEFAULT 0,
            clicks int(11) DEFAULT 0,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY post_id (post_id),
            KEY template_id (template_id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_templates);
        dbDelta($sql_data_sources);
        dbDelta($sql_generated_pages);

        // Create upload directory
        $upload_dir = wp_upload_dir();
        $pseo_dir = $upload_dir['basedir'] . '/programmatic-seo';
        if (!file_exists($pseo_dir)) {
            wp_mkdir_p($pseo_dir);
        }

        // Set default options
        add_option('pseo_version', PSEO_VERSION);
        add_option('pseo_settings', array(
            'enable_analytics' => true,
            'enable_internal_linking' => true,
            'enable_schema' => true,
            'pages_per_batch' => 50,
            'auto_publish' => false
        ));

        // Flush rewrite rules
        flush_rewrite_rules();
    }
}
