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

        // Validate required fields
        if (empty($data['name']) || empty($data['title_template']) || empty($data['content_template'])) {
            return false;
        }

        // Sanitize slug pattern without removing {{}} variables
        $slug_pattern = '';
        if (!empty($data['slug_pattern'])) {
            // Temporarily replace {{variables}} with placeholders
            $slug_pattern = $data['slug_pattern'];
            preg_match_all('/\{\{([^}]+)\}\}/', $slug_pattern, $matches);
            $placeholders = array();
            foreach ($matches[0] as $i => $match) {
                $placeholder = '___VAR' . $i . '___';
                $placeholders[$placeholder] = $match;
                $slug_pattern = str_replace($match, $placeholder, $slug_pattern);
            }
            // Sanitize the rest
            $slug_pattern = sanitize_title($slug_pattern);
            // Restore variables
            foreach ($placeholders as $placeholder => $original) {
                $slug_pattern = str_replace(strtolower($placeholder), $original, $slug_pattern);
            }
        }

        // Sanitize template fields while preserving {{variables}}
        $title_template = $this->sanitize_template($data['title_template']);
        $content_template = $this->sanitize_template($data['content_template']);
        $meta_description = sanitize_textarea_field($data['meta_description_template'] ?? '');

        $template_data = array(
            'name' => sanitize_text_field($data['name']),
            'description' => sanitize_textarea_field($data['description'] ?? ''),
            'title_template' => $title_template,
            'content_template' => $content_template,
            'meta_description_template' => $meta_description,
            'slug_pattern' => $slug_pattern,
            'post_type' => sanitize_text_field($data['post_type'] ?? 'page'),
            'status' => sanitize_text_field($data['status'] ?? 'active'),
            'variables' => sanitize_text_field($data['variables'] ?? '')
        );

        // Debug log
        error_log('PSEO: Template data prepared: ' . print_r(array_keys($template_data), true));

        if (isset($data['template_id']) && $data['template_id']) {
            // Update existing template
            $result = $wpdb->update(
                $table,
                $template_data,
                array('id' => intval($data['template_id']))
            );

            // Check for errors
            if ($result === false) {
                error_log('PSEO Template Update Error: ' . $wpdb->last_error);
                return false;
            }

            return intval($data['template_id']);
        } else {
            // Insert new template
            $result = $wpdb->insert($table, $template_data);

            // Check for errors
            if ($result === false) {
                error_log('PSEO Template Insert Error: ' . $wpdb->last_error);
                return false;
            }

            return $wpdb->insert_id;
        }
    }

    /**
     * Duplicate template
     */
    public function duplicate($id) {
        $template = $this->get($id);

        if (!$template) {
            return false;
        }

        global $wpdb;
        $table = $wpdb->prefix . 'pseo_templates';

        $template_data = array(
            'name' => $template->name . ' (Copy)',
            'description' => $template->description,
            'title_template' => $template->title_template,
            'content_template' => $template->content_template,
            'meta_description_template' => $template->meta_description_template,
            'slug_pattern' => $template->slug_pattern,
            'post_type' => $template->post_type,
            'status' => 'inactive', // Set as inactive by default
            'variables' => $template->variables
        );

        $wpdb->insert($table, $template_data);
        return $wpdb->insert_id;
    }

    /**
     * Export template to JSON
     */
    public function export($id) {
        $template = $this->get($id);

        if (!$template) {
            return false;
        }

        // Remove ID and timestamps for portability
        $export_data = array(
            'name' => $template->name,
            'description' => $template->description,
            'title_template' => $template->title_template,
            'content_template' => $template->content_template,
            'meta_description_template' => $template->meta_description_template,
            'slug_pattern' => $template->slug_pattern,
            'post_type' => $template->post_type,
            'variables' => $template->variables,
            'status' => $template->status,
            'exported_at' => current_time('mysql'),
            'plugin_version' => PSEO_VERSION
        );

        return json_encode($export_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Import template from JSON
     */
    public function import($json_string) {
        $data = json_decode($json_string, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        // Validate required fields
        if (empty($data['name']) || empty($data['title_template']) || empty($data['content_template'])) {
            return false;
        }

        // Add " (Imported)" to name to avoid duplicates
        $data['name'] = $data['name'] . ' (Imported)';

        return $this->save($data);
    }

    /**
     * Sanitize template content while preserving {{variables}}
     */
    private function sanitize_template($template) {
        // Temporarily replace {{variables}} with placeholders
        preg_match_all('/\{\{([^}]+)\}\}/', $template, $matches);
        $placeholders = array();

        foreach ($matches[0] as $i => $match) {
            $placeholder = '___TEMPLATEVAR' . $i . '___';
            $placeholders[$placeholder] = $match;
            $template = str_replace($match, $placeholder, $template);
        }

        // Sanitize HTML content
        $template = wp_kses_post($template);

        // Restore variables
        foreach ($placeholders as $placeholder => $original) {
            $template = str_replace($placeholder, $original, $template);
        }

        return $template;
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
