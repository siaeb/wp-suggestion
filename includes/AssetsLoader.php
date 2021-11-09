<?php

namespace siaeb\suggestion\includes;

class AssetsLoader {

	/**
	 * AssetsLoader constructor.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'loadAdminAssets' ] );
	}

	/**
	 * Load admin assets
	 *
	 * @return void
	 * @since 1.0
	 * @access public
	 */
	function loadAdminAssets( $hook ) {
		$scripts_version = "1.0";
		if ( ! in_array( $hook, [ 'edit-tags.php', 'post-new.php' ] ) ) {
			return;
		}

		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script( SPT_PREFIX . 'typewatch', SPT_JS_URL . 'typewatch.js', [], $scripts_version, true );
		wp_enqueue_script( SPT_PREFIX . 'terms', SPT_JS_URL . 'terms.js', [], $scripts_version, true );
		wp_localize_script( SPT_PREFIX . 'terms', SPT_PREFIX . 'params', [
			'taxonomy' => $_GET['taxonomy'] ?? "",
			'ajaxurl'  => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'spt-nonce' ),
		] );

	}

}
