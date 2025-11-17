<?php
/**
 * Data importer class
 */

if (!defined('ABSPATH')) {
    exit;
}

class PSEO_Data_Importer {

    /**
     * Import data from file
     */
    public function import($file) {
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return array('success' => false, 'message' => 'No file uploaded');
        }

        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($file_extension, array('csv', 'json'))) {
            return array('success' => false, 'message' => 'Invalid file type. Only CSV and JSON are supported.');
        }

        // Move file to uploads directory
        $upload_dir = wp_upload_dir();
        $pseo_dir = $upload_dir['basedir'] . '/programmatic-seo';
        $file_name = sanitize_file_name($file['name']);
        $file_path = $pseo_dir . '/' . $file_name;

        if (!move_uploaded_file($file['tmp_name'], $file_path)) {
            return array('success' => false, 'message' => 'Failed to save file');
        }

        // Parse file
        if ($file_extension === 'csv') {
            $data = $this->parse_csv($file_path);
        } else {
            $data = $this->parse_json($file_path);
        }

        if (!$data) {
            return array('success' => false, 'message' => 'Failed to parse file');
        }

        // Save to database
        global $wpdb;
        $table = $wpdb->prefix . 'pseo_data_sources';

        $wpdb->insert($table, array(
            'name' => sanitize_text_field($_POST['data_source_name'] ?? $file_name),
            'file_name' => $file_name,
            'file_path' => $file_path,
            'file_type' => $file_extension,
            'total_rows' => count($data),
            'columns' => json_encode(array_keys($data[0]))
        ));

        $data_source_id = $wpdb->insert_id;

        return array(
            'success' => true,
            'message' => 'Data imported successfully',
            'data_source_id' => $data_source_id,
            'total_rows' => count($data),
            'columns' => array_keys($data[0])
        );
    }

    /**
     * Parse CSV file
     */
    private function parse_csv($file_path) {
        $data = array();
        $handle = fopen($file_path, 'r');

        if ($handle === false) {
            return false;
        }

        // Get headers
        $headers = fgetcsv($handle);
        if (!$headers) {
            fclose($handle);
            return false;
        }

        // Read data rows
        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) === count($headers)) {
                $data[] = array_combine($headers, $row);
            }
        }

        fclose($handle);
        return $data;
    }

    /**
     * Parse JSON file
     */
    private function parse_json($file_path) {
        $json_content = file_get_contents($file_path);
        $data = json_decode($json_content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        return $data;
    }

    /**
     * Get data source by ID
     */
    public function get_data_source($id) {
        global $wpdb;
        $table = $wpdb->prefix . 'pseo_data_sources';
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $id));
    }

    /**
     * Get all data sources
     */
    public function get_all_data_sources() {
        global $wpdb;
        $table = $wpdb->prefix . 'pseo_data_sources';
        return $wpdb->get_results("SELECT * FROM $table ORDER BY created_at DESC");
    }

    /**
     * Get data from file
     */
    public function get_data($data_source_id) {
        $data_source = $this->get_data_source($data_source_id);

        if (!$data_source || !file_exists($data_source->file_path)) {
            return false;
        }

        if ($data_source->file_type === 'csv') {
            return $this->parse_csv($data_source->file_path);
        } else {
            return $this->parse_json($data_source->file_path);
        }
    }
}
