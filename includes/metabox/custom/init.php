<?php
/**
 * The initation loader for RSTHEME, and the main plugin file.
 *
 */

if ( ! class_exists( 'RSTHEME_Bootstrap_242', false ) ) {

	/**
	 * Handles checking for and loading the newest version of RSTHEME
	 *
	 */
	class RSTHEME_Bootstrap_242 {

		/**
		 * Current version number
		 */
		const VERSION = '1.0.5';

		/**
		 * Current version hook priority.
		 * Will decrement with each release
		 */
		const PRIORITY = 9966;

		/**
		 * Single instance of the RSTHEME_Bootstrap_242 object
		 *
		 * @var RSTHEME_Bootstrap_242
		 */
		public static $single_instance = null;

		/**
		 * Creates/returns the single instance RSTHEME_Bootstrap_242 object
		 */
		public static function initiate() {
			if ( null === self::$single_instance ) {
				self::$single_instance = new self();
			}
			return self::$single_instance;
		}

		/**
		 * Starts the version checking process.
		 * Creates RSTHEME_LOADED definition for early detection by other scripts
		 */
		private function __construct() {
			/**
			 * A constant you can use to check if RSTHEME is loaded
			 * for your plugins/themes with RSTHEME dependency
			 */
			if ( ! defined( 'RSTHEME_LOADED' ) ) {
				define( 'RSTHEME_LOADED', self::PRIORITY );
			}

			add_action( 'init', array( $this, 'include_rstheme' ), self::PRIORITY );
		}

		/**
		 * A final check if RSTHEME exists before kicking off our RSTHEME loading.
		 */
		public function include_rstheme() {
			if ( class_exists( 'RSTHEME', false ) ) {
				return;
			}

			if ( ! defined( 'RSTHEME_VERSION' ) ) {
				define( 'RSTHEME_VERSION', self::VERSION );
			}

			if ( ! defined( 'RSTHEME_DIR' ) ) {
				define( 'RSTHEME_DIR', trailingslashit( dirname( __FILE__ ) ) );
			}

			$this->l10ni18n();

			// Include helper functions.
			require_once RSTHEME_DIR . 'includes/RSTHEME_Base.php';
			require_once RSTHEME_DIR . 'includes/RSTHEME.php';
			require_once RSTHEME_DIR . 'includes/helper-functions.php';

			// Now kick off the class autoloader.
			spl_autoload_register( 'rstheme_autoload_classes' );

			// Kick the whole thing off.
			require_once( rstheme_dir( 'bootstrap.php' ) );
			rstheme_bootstrap();
		}

		/**
		 * Registers RSTHEME text domain path
		 */
		public function l10ni18n() {

			$loaded = load_plugin_textdomain( 'rstheme', false, '/languages/' );

			if ( ! $loaded ) {
				$loaded = load_muplugin_textdomain( 'rstheme', '/languages/' );
			}

			if ( ! $loaded ) {
				$loaded = load_theme_textdomain( 'rstheme', get_stylesheet_directory() . '/languages/' );
			}

			if ( ! $loaded ) {
				$locale = apply_filters( 'plugin_locale', get_locale(), 'rstheme' );
				$mofile = dirname( __FILE__ ) . '/languages/rstheme-' . $locale . '.mo';
				load_textdomain( 'rstheme', $mofile );
			}

		}

	}

	// Make it so...
	RSTHEME_Bootstrap_242::initiate();

}
/*---- Team Tab initail code----
------------------------------*/
if( !class_exists( 'RSTHEME_Tabs' ) ) {
    class RSTHEME_Tabs {

        /**
         * Current version number
         */
        const VERSION = '1.0.5';

        /**
         * Initialize the plugin by hooking into RSTHEME
         */
        public function __construct() {
            add_action( 'admin_enqueue_scripts', array( $this, 'uteam_setup_admin_scripts' ) );
            add_action( 'doing_dark_mode', array( $this, 'setup_dark_mode' ) );
            add_action( 'rstheme_before_form', array( $this, 'before_form' ), 10, 4 );
            add_action( 'rstheme_after_form', array( $this, 'after_form' ), 10, 4 );
        }

        /**
         * Render tabs
         *
         * @param array  $rstheme_id      The current box ID
         * @param int    $object_id   The ID of the current object
         * @param string $object_type The type of object you are working with.
         * @param array  $rstheme         This RSTHEME object
         */
        public function before_form( $rstheme_id, $object_id, $object_type, $rstheme ) {
            if( $rstheme->prop( 'tabs' ) && is_array( $rstheme->prop( 'tabs' ) ) ) : ?>
                <div class="rstheme-tabs-wrap rstheme-tabs-<?php echo ( ( $rstheme->prop( 'vertical_tabs' ) ) ? 'vertical' : 'horizontal' ) ?>">
                    <div class="rstheme-tabs">

                        <?php foreach( $rstheme->prop( 'tabs' ) as $tab ) :
                            $fields_selector = array();

                            if( ! isset( $tab['id'] ) ) {
                                continue;
                            }

                            if( ! isset( $tab['fields'] ) ) {
                                $tab['fields'] = array();
                            }

                            if( ! is_array( $tab['fields'] ) ) {
                                $tab['fields'] = array();
                            }

                            foreach( $tab['fields'] as $tab_field )  :
                                $fields_selector[] = '.' . 'rstheme-id-' . str_replace( '_', '-', sanitize_html_class( $tab_field ) ) . ':not(.rstheme-tab-ignore)';
                            endforeach;

                            $fields_selector = apply_filters( 'rstheme_tabs_tab_fields_selector', $fields_selector, $tab, $rstheme_id, $object_id, $object_type, $rstheme );
                            $fields_selector = apply_filters( 'rstheme_tabs_tab_' . $tab['id'] . '_fields_selector', $fields_selector, $tab, $rstheme_id, $object_id, $object_type, $rstheme );
                            ?>

                            <div id="<?php echo esc_html( $rstheme_id . '-tab-' . $tab['id'] ); ?>" class="rstheme-tab" data-fields="<?php echo esc_attr( implode( ', ', $fields_selector ) ); ?>">


                                <?php if( isset( $tab['icon'] ) && ! empty( $tab['icon'] ) ) :
                                    $tab['icon'] = strpos($tab['icon'], 'dashicons') !== false ? 'dashicons ' . $tab['icon'] : $tab['icon']?>
                                    <span class="rstheme-tab-icon"><i class="<?php echo esc_html( $tab['icon'] ); ?>"></i></span>
                                <?php endif; ?>

                                <?php if( isset( $tab['title'] ) && ! empty( $tab['title'] ) ) : ?>
                                    <span class="rstheme-tab-title"><?php echo esc_html( $tab['title'] ); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                    </div> <!-- .rstheme-tabs -->
            <?php endif;
        }

        /**
         * Close tabs
         *
         * @param array  $rstheme_id      The current box ID
         * @param int    $object_id   The ID of the current object
         * @param string $object_type The type of object you are working with.
         * @param array  $rstheme         This RSTHEME object
         */
        public function after_form( $rstheme_id, $object_id, $object_type, $rstheme ) {
            if( $rstheme->prop( 'tabs' ) && is_array( $rstheme->prop( 'tabs' ) ) ) : ?>
                </div> <!-- .rstheme-tabs-wrap -->
            <?php endif;
        }

        /**
         * Enqueue scripts and styles
         */
        public function uteam_setup_admin_scripts() {
        	
            wp_register_script( 'rstheme-tabs', plugins_url( 'js/tabs.js', __FILE__ ), array( 'jquery' ), self::VERSION, true );
            wp_enqueue_script( 'rstheme-tabs' );

            wp_enqueue_style( 'rstheme-tabs', plugins_url( 'css/tabs.css', __FILE__ ), array(), self::VERSION );
            wp_enqueue_style( 'rstheme-tabs' );

        }

        /**
         * Enqueue dark mode styles
         */
        public function setup_dark_mode() {
            wp_enqueue_style( 'rstheme-tabs-dark-mode', plugins_url( 'css/dark-mode.css', __FILE__ ), array(), self::VERSION );
            wp_enqueue_style( 'rstheme-tabs-dark-mode' );

        }

    }

    $rstheme_tabs = new RSTHEME_Tabs();
}
