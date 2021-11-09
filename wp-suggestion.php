<?php
/**
 * Plugin Name: پیشنهاد دهنده
 * Plugin URI: http://www.siaeb.com
 * Version: 1.0
 * Description: این افزونه در هنگام ایجاد مطلب جدید یا دسته بندی موارد مشاهده را به شما نمایش می دهد
 * Author: سیاوش ابراهیمی
 * Author URI: http://www.siaeb.com
 */

use siaeb\suggestion\includes\Ajax;
use siaeb\suggestion\includes\AssetsLoader;
use siaeb\suggestion\includes\Initializer;
use siaeb\suggestion\includes\Utility;

if ( ! class_exists( 'SIAEB_Suggestion' ) ) :

	final class SIAEB_Suggestion {


		/**
		 * @var SIAEB_Suggestion The one true SIAEB_Suggestion
		 *
		 * @since 1.0.0
		 */
		private static $instance;

		/**
		 * @var Ajax
		 */
		public $ajax;

		/**
		 * @var Utility
		 */
		public $util;


		public static function instance() {
			if ( is_null( self::$instance instanceof SIAEB_Suggestion ) || ! self::$instance ) {

				self::$instance = new SIAEB_Suggestion();

				self::$instance->constants();
				self::$instance->includes();

				self::$instance->ajax          = new Ajax();
				self::$instance->assets_loader = new AssetsLoader();
				self::$instance->initializer   = new Initializer();
				self::$instance->util          = new Utility();

			}

			return self::$instance;
		}

		/**
		 * Throw error on object clone.
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @return void
		 * @since 1.0
		 * @access protected
		 */
		public function _clone() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', "siaeb-suggestion" ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @return void
		 * @since 1.0
		 * @access protected
		 */
		public function _wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', "siaeb-suggestion" ), '1.0.0' );
		}

		/**
		 * Setup plugin constants.
		 *
		 * @access private
		 * @return void
		 * @since 1.0
		 */
		private function constants() {
			$this->defineCosntant( "SPT_PREFIX", 'spt_' );
			$this->defineCosntant( "SPT_VERSION", "1.0" );
			$this->defineCosntant( "SPT_PLUGIN_DIR", trailingslashit( plugin_dir_path( __FILE__ ) ) );
			$this->defineCosntant( "SPT_PLUGIN_URL", trailingslashit( plugin_dir_url( __FILE__ ) ) );
			$this->defineCosntant( "SPT_PLUGIN_FILE", __FILE__ );
			$this->defineCosntant( "SPT_INC_DIR", SPT_PLUGIN_DIR . 'includes/' );
			$this->defineCosntant( "SPT_ASSETS_URL", SPT_PLUGIN_URL . 'assets/' );
			$this->defineCosntant( "SPT_IMAGES_URL", SPT_ASSETS_URL . 'imgs/' );
			$this->defineCosntant( "SPT_CSS_URL", SPT_ASSETS_URL . 'css/' );
			$this->defineCosntant( "SPT_JS_URL", SPT_ASSETS_URL . 'js/' );
		}


		/**
		 * Define constant
		 *
		 * @since 1.0
		 */
		private function defineCosntant( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Include required files.
		 *
		 * @access private
		 * @return void
		 * @since 1.0
		 */
		private function includes() {
			require_once SPT_INC_DIR . 'Ajax.php';
			require_once SPT_INC_DIR . 'AssetsLoader.php';
			require_once SPT_INC_DIR . 'Initializer.php';
			require_once SPT_INC_DIR . 'Utility.php';
		}

	}

endif;

/**
 * The main function for that returns SIAEB_Suggestion
 *
 * The main function responsible for returning the one true SPT
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $spt = SPT(); ?>
 *
 * @return object|SIAEB_Suggestion The one true SIAEB_Suggestion Instance.
 * @since 1.0
 */
function SPT() {
	return SIAEB_Suggestion::instance();
}

SPT();
