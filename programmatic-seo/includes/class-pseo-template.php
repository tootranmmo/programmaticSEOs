<?php
/**
 * Template management class
 */

if (!defined('ABSPATH')) {
    exit;
}

class PSEO_Template {

    /**
     * Get all templates
     */
    public function get_all() {
        global $wpdb;
        $table = $wpdb->prefix . 'pseo_templates';
        return $wpdb->get_results("SELECT * FROM $table ORDER BY created_at DESC");
    }

    /**
     * Get template by ID
     */
    public function get($id) {
        global $wpdb;
        $table = $wpdb->prefix . 'pseo_templates';
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $id));
    }

    /**
     * Save template
     */
    public function save($data) {
        global $wpdb;
        $table = $wpdb->prefix . 'pseo_templates';

        $template_data = array(
            'name' => sanitize_text_field($data['name']),
            'description' => sanitize_textarea_field($data['description'] ?? ''),
            'title_template' => sanitize_text_field($data['title_template']),
            'content_template' => wp_kses_post($data['content_template']),
            'meta_description_template' => sanitize_textarea_field($data['meta_description_template'] ?? ''),
            'slug_pattern' => sanitize_title($data['slug_pattern'] ?? ''),
            'post_type' => sanitize_text_field($data['post_type'] ?? 'page'),
            'status' => sanitize_text_field($data['status'] ?? 'active'),
            'variables' => sanitize_text_field($data['variables'] ?? '')
        );

        if (isset($data['template_id']) && $data['template_id']) {
            // Update existing template
            $wpdb->update(
                $table,
                $template_data,
                array('id' => intval($data['template_id']))
            );
            return intval($data['template_id']);
        } else {
            // Insert new template
            $wpdb->insert($table, $template_data);
            return $wpdb->insert_id;
        }
    }

    /**
     * Delete template
     */
    public function delete($id) {
        global $wpdb;
        $table = $wpdb->prefix . 'pseo_templates';
        return $wpdb->delete($table, array('id' => intval($id)));
    }

    /**
     * Render template with data
     */
    public function render($template_string, $data) {
        // Replace variables like {{variable_name}} with actual values
        foreach ($data as $key => $value) {
            $template_string = str_replace('{{' . $key . '}}', $value, $template_string);
        }
        return $template_string;
    }

    /**
     * Extract variables from template
     */
    public function extract_variables($template_string) {
        preg_match_all('/\{\{([^}]+)\}\}/', $template_string, $matches);
        return array_unique($matches[1]);
    }
}
