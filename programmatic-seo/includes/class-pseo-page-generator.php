<?php
/**
 * Page generator class
 */

if (!defined('ABSPATH')) {
    exit;
}

class PSEO_Page_Generator {

    /**
     * Generate pages from template and data
     */
    public function generate($params) {
        $template_id = intval($params['template_id']);
        $data_source_id = intval($params['data_source_id']);
        $limit = isset($params['limit']) ? intval($params['limit']) : 0;
        $auto_publish = isset($params['auto_publish']) && $params['auto_publish'] === 'true';

        // Get template
        $template_obj = new PSEO_Template();
        $template = $template_obj->get($template_id);

        if (!$template) {
            return array('success' => false, 'message' => 'Template not found');
        }

        // Get data
        $importer = new PSEO_Data_Importer();
        $data = $importer->get_data($data_source_id);

        if (!$data) {
            return array('success' => false, 'message' => 'Data source not found or empty');
        }

        // Limit rows if specified
        if ($limit > 0) {
            $data = array_slice($data, 0, $limit);
        }

        $generated_count = 0;
        $errors = array();

        global $wpdb;
        $generated_pages_table = $wpdb->prefix . 'pseo_generated_pages';

        foreach ($data as $index => $row) {
            try {
                // Render title
                $title = $template_obj->render($template->title_template, $row);

                // Render content
                $content = $template_obj->render($template->content_template, $row);

                // Render slug
                $slug = '';
                if ($template->slug_pattern) {
                    $slug = $template_obj->render($template->slug_pattern, $row);
                    $slug = sanitize_title($slug);
                }

                // Render meta description
                $meta_description = '';
                if ($template->meta_description_template) {
                    $meta_description = $template_obj->render($template->meta_description_template, $row);
                }

                // Create post
                $post_data = array(
                    'post_title' => $title,
                    'post_content' => $content,
                    'post_status' => $auto_publish ? 'publish' : 'draft',
                    'post_type' => $template->post_type,
                    'post_author' => get_current_user_id()
                );

                if ($slug) {
                    $post_data['post_name'] = $slug;
                }

                $post_id = wp_insert_post($post_data);

                if (is_wp_error($post_id)) {
                    $errors[] = "Row $index: " . $post_id->get_error_message();
                    continue;
                }

                // Save meta description
                if ($meta_description) {
                    update_post_meta($post_id, '_pseo_meta_description', $meta_description);
                }

                // Save original data as meta
                update_post_meta($post_id, '_pseo_original_data', json_encode($row));
                update_post_meta($post_id, '_pseo_template_id', $template_id);

                // Track generated page
                $wpdb->insert($generated_pages_table, array(
                    'post_id' => $post_id,
                    'template_id' => $template_id,
                    'data_source_id' => $data_source_id,
                    'data_row_index' => $index
                ));

                $generated_count++;

            } catch (Exception $e) {
                $errors[] = "Row $index: " . $e->getMessage();
            }
        }

        return array(
            'success' => true,
            'message' => "Generated $generated_count pages successfully",
            'generated_count' => $generated_count,
            'total_rows' => count($data),
            'errors' => $errors
        );
    }

    /**
     * Get generated pages stats
     */
    public function get_stats() {
        global $wpdb;
        $table = $wpdb->prefix . 'pseo_generated_pages';

        return array(
            'total_pages' => $wpdb->get_var("SELECT COUNT(*) FROM $table"),
            'total_views' => $wpdb->get_var("SELECT SUM(views) FROM $table"),
            'total_clicks' => $wpdb->get_var("SELECT SUM(clicks) FROM $table")
        );
    }
}
