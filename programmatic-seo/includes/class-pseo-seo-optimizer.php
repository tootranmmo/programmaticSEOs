<?php
/**
 * SEO optimizer class
 */

if (!defined('ABSPATH')) {
    exit;
}

class PSEO_SEO_Optimizer {

    /**
     * Output meta tags
     */
    public function output_meta_tags() {
        if (!is_singular()) {
            return;
        }

        global $post;

        $meta_description = get_post_meta($post->ID, '_pseo_meta_description', true);

        if ($meta_description) {
            echo '<meta name="description" content="' . esc_attr($meta_description) . '">' . "\n";

            // Open Graph tags
            echo '<meta property="og:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
            echo '<meta property="og:description" content="' . esc_attr($meta_description) . '">' . "\n";
            echo '<meta property="og:url" content="' . esc_url(get_permalink()) . '">' . "\n";
            echo '<meta property="og:type" content="article">' . "\n";

            // Twitter Card tags
            echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
            echo '<meta name="twitter:title" content="' . esc_attr(get_the_title()) . '">' . "\n";
            echo '<meta name="twitter:description" content="' . esc_attr($meta_description) . '">' . "\n";

            // Featured image
            if (has_post_thumbnail()) {
                $image_url = get_the_post_thumbnail_url($post->ID, 'large');
                echo '<meta property="og:image" content="' . esc_url($image_url) . '">' . "\n";
                echo '<meta name="twitter:image" content="' . esc_url($image_url) . '">' . "\n";
            }
        }
    }

    /**
     * Output schema markup
     */
    public function output_schema_markup() {
        if (!is_singular()) {
            return;
        }

        global $post;

        $template_id = get_post_meta($post->ID, '_pseo_template_id', true);

        if (!$template_id) {
            return;
        }

        $meta_description = get_post_meta($post->ID, '_pseo_meta_description', true);

        $schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => get_the_title(),
            'description' => $meta_description,
            'url' => get_permalink(),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'author' => array(
                '@type' => 'Person',
                'name' => get_the_author()
            )
        );

        if (has_post_thumbnail()) {
            $schema['image'] = get_the_post_thumbnail_url($post->ID, 'large');
        }

        echo '<script type="application/ld+json">' . "\n";
        echo wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        echo "\n" . '</script>' . "\n";
    }

    /**
     * Add internal links to content
     */
    public function add_internal_links($content) {
        if (!is_singular() || !in_the_loop() || !is_main_query()) {
            return $content;
        }

        global $post, $wpdb;

        $template_id = get_post_meta($post->ID, '_pseo_template_id', true);

        if (!$template_id) {
            return $content;
        }

        // Get related pages from the same template
        $generated_pages_table = $wpdb->prefix . 'pseo_generated_pages';

        $related_posts = $wpdb->get_results($wpdb->prepare(
            "SELECT p.ID, p.post_title
            FROM {$wpdb->posts} p
            INNER JOIN $generated_pages_table gp ON p.ID = gp.post_id
            WHERE gp.template_id = %d
            AND p.ID != %d
            AND p.post_status = 'publish'
            ORDER BY RAND()
            LIMIT 3",
            $template_id,
            $post->ID
        ));

        if (empty($related_posts)) {
            return $content;
        }

        // Add internal links section
        $links_html = '<div class="pseo-internal-links" style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-left: 4px solid #007bff;">';
        $links_html .= '<h3 style="margin-top: 0; color: #333;">Bài viết liên quan:</h3>';
        $links_html .= '<ul style="list-style: none; padding-left: 0;">';

        foreach ($related_posts as $related_post) {
            $links_html .= '<li style="margin-bottom: 10px;">';
            $links_html .= '<a href="' . get_permalink($related_post->ID) . '" style="color: #007bff; text-decoration: none;">';
            $links_html .= '<i class="fas fa-arrow-right"></i> ' . esc_html($related_post->post_title);
            $links_html .= '</a>';
            $links_html .= '</li>';
        }

        $links_html .= '</ul>';
        $links_html .= '</div>';

        return $content . $links_html;
    }
}
