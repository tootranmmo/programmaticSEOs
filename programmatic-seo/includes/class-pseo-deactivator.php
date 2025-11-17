<?php
/**
 * Plugin deactivation
 */

if (!defined('ABSPATH')) {
    exit;
}

class PSEO_Deactivator {

    /**
     * Deactivate plugin
     */
    public static function deactivate() {
        // Flush rewrite rules
        flush_rewrite_rules();
    }
}
