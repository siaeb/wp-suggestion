<?php

namespace siaeb\suggestion\includes;


class Ajax {

    /**
     * Ajax constructor.
     */
    public function __construct() {
        // AutoComplete terms
        add_action('wp_ajax_spt-suggest-terms', [$this, 'suggest_terms']);

        // Autocomplete search posts
        add_action('wp_ajax_spt-suggest-posts', [$this, 'ajax_search_admin_posts']);
    }

    /**
     * Suggest Terms
     *
     * @since 1.0
     * @access public
     * @return void
     */
    function suggest_terms() {
        check_ajax_referer('spt-nonce');
        if (!isset($_GET['term']) || empty(trim($_GET['term']))) wp_send_json_error();
        $result = SPT()->util->search_taxonomy(sanitize_text_field($_GET['term']), sanitize_text_field($_GET['taxonomy']));
        $result = array_map(function($item) {
            return [
                'id'   => $item->term_id,
                'name' => $item->name,
            ];
        }, $result);

        wp_send_json_success($result);
    }

    /**
     * Ajax search posts
     *
     * @since 1.0
     * @access public
     * @return void
     */
    function ajax_search_admin_posts() {
        if (!isset($_GET['keyword']) || empty($_GET['keyword'])) wp_send_json_error();
        $posts = SPT()->util->search_posts(sanitize_text_field($_GET['keyword']));
        if ($posts) {
            $results = '<ul>';
            foreach ($posts as $item) {
                $results .= sprintf('<li><a href="%s" target="_blank">%s</a></li>', get_permalink($item->ID), $item->post_title);
            }
            $results .= '</ul>';
            wp_send_json_success($results);
        }
        wp_send_json_success(__("Nothing found !", "wp-su"));
    }

}
