<?php
/**
 * Uninstall script
 * Fired when the plugin is uninstalled
 */

// If uninstall not called from WordPress, exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

global $wpdb;

// Delete plugin tables
$tables = array(
    $wpdb->prefix . 'pseo_templates',
    $wpdb->prefix . 'pseo_data_sources',
    $wpdb->prefix . 'pseo_generated_pages'
);

foreach ($tables as $table) {
    $wpdb->query("DROP TABLE IF EXISTS $table");
}

// Delete plugin options
delete_option('pseo_version');
delete_option('pseo_settings');

// Delete post meta for generated pages
$wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE meta_key LIKE '_pseo_%'");

// Delete uploaded files
$upload_dir = wp_upload_dir();
$pseo_dir = $upload_dir['basedir'] . '/programmatic-seo';

if (file_exists($pseo_dir)) {
    // Delete all files in directory
    $files = glob($pseo_dir . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    // Delete directory
    rmdir($pseo_dir);
}

// Clear any cached data
wp_cache_flush();
