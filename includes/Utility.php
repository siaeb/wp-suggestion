<?php


namespace siaeb\suggestion\includes;


class Utility {

    /**
     * Search posts
     *
     * @since 1.0
     * @param string $term
     * @return array
     */
    public function search_posts($term) {
        global $wpdb;
        $query = "SELECT * FROM {$wpdb->posts} WHERE (`post_title` LIKE %s) AND `post_status` = 'publish' AND `post_type` = 'post' ORDER BY `post_title` ASC";
        return $wpdb->get_results($wpdb->prepare($query, '%'. $wpdb->esc_like($term) . '%'));
    }

    /**
     * Search taxonomies
     *
     * @since 1.0
     * @param string $term
     * @param string $taxonomy
     * @return array|object|null
     */
    public function search_taxonomy($term, $taxonomy = 'category') {
        global $wpdb;
        $query = "SELECT * FROM `{$wpdb->terms}` `wp_terms`
	     INNER JOIN {$wpdb->term_taxonomy} `wp_term_taxonomy` ON wp_term_taxonomy.term_id = wp_terms.term_id
        	WHERE wp_term_taxonomy.taxonomy = %s AND wp_terms.name LIKE %s
    	";
        return $wpdb->get_results($wpdb->prepare($query, $taxonomy, '%' . $wpdb->esc_like($term) . '%'));
    }

}
