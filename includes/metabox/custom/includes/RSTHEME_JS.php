<?php
/**
 * Handles the dependencies and enqueueing of the RSTHEME JS scripts
 *
 * @category  WordPress_Plugin
 * @package   RSTHEME
 * @author    RSTHEME team
 * @license   GPL-2.0+
 * @link      https://rstheme.io
 */
class RSTHEME_JS {

	/**
	 * The RSTHEME JS handle
	 *
	 * @var   string
	 * @since 2.0.7
	 */
	protected static $handle = 'rstheme-scripts';

	/**
	 * The RSTHEME JS variable name
	 *
	 * @var   string
	 * @since 2.0.7
	 */
	protected static $js_variable = 'rstheme_l10';

	/**
	 * Array of RSTHEME JS dependencies
	 *
	 * @var   array
	 * @since 2.0.7
	 */
	protected static $dependencies = array(
		'jquery' => 'jquery',
	);

	/**
	 * Array of RSTHEME fields model data for JS.
	 *
	 * @var   array
	 * @since 2.4.0
	 */
	protected static $fields = array();

	/**
	 * Add a dependency to the array of RSTHEME JS dependencies
	 *
	 * @since 2.0.7
	 * @param array|string $dependencies Array (or string) of dependencies to add
	 */
	public static function add_dependencies( $dependencies ) {
		foreach ( (array) $dependencies as $dependency ) {
			self::$dependencies[ $dependency ] = $dependency;
		}
	}

	/**
	 * Add field model data to the array for JS.
	 *
	 * @since 2.4.0
	 *
	 * @param RSTHEME_Field $field Field object.
	 */
	public static function add_field_data( RSTHEME_Field $field ) {
		$hash = $field->hash_id();
		if ( ! isset( self::$fields[ $hash ] ) ) {
			self::$fields[ $hash ] = $field->js_data();
		}
	}

	/**
	 * Enqueue the RSTHEME JS
	 *
	 * @since  2.0.7
	 */
	public static function enqueue() {
		// Filter required script dependencies
		$dependencies = self::$dependencies = apply_filters( 'rstheme_script_dependencies', self::$dependencies );

		// Only use minified files if SCRIPT_DEBUG is off
		$debug = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;

		$min = $debug ? '' : '.min';

		// if colorpicker
		if ( isset( $dependencies['wp-color-picker'] ) ) {
			if ( ! is_admin() ) {
				self::colorpicker_frontend();
			}

			if ( isset( $dependencies['wp-color-picker-alpha'] ) ) {
				self::register_colorpicker_alpha();
			}
		}

		// if file/file_list
		if ( isset( $dependencies['media-editor'] ) ) {
			wp_enqueue_media();
			RSTHEME_Type_File_Base::output_js_underscore_templates();
		}

		// if timepicker
		if ( isset( $dependencies['jquery-ui-datetimepicker'] ) ) {
			self::register_datetimepicker();
		}

		// if rstheme-wysiwyg
		$enqueue_wysiwyg = isset( $dependencies['rstheme-wysiwyg'] ) && $debug;
		unset( $dependencies['rstheme-wysiwyg'] );

		// Enqueue rstheme JS
		wp_enqueue_script( self::$handle, RSTHEME_Utils::url( "js/rstheme{$min}.js" ), $dependencies, RSTHEME_VERSION, true );

		// if SCRIPT_DEBUG, we need to enqueue separately.
		if ( $enqueue_wysiwyg ) {
			wp_enqueue_script( 'rstheme-wysiwyg', RSTHEME_Utils::url( 'js/rstheme-wysiwyg.js' ), array( 'jquery', 'wp-util' ), RSTHEME_VERSION,true );
		}

		self::localize( $debug );

		do_action( 'rstheme_footer_enqueue' );
	}

	/**
	 * Register or enqueue the wp-color-picker-alpha script.
	 *
	 * @since  2.2.7
	 *
	 * @param  boolean $enqueue
	 *
	 * @return void
	 */
	public static function register_colorpicker_alpha( $enqueue = false ) {
		// Only use minified files if SCRIPT_DEBUG is off
		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$func = $enqueue ? 'wp_enqueue_script' : 'wp_register_script';
		$func( 'wp-color-picker-alpha', RSTHEME_Utils::url( "js/wp-color-picker-alpha{$min}.js" ), array( 'wp-color-picker' ), '2.1.3' );
	}

	/**
	 * Register or enqueue the jquery-ui-datetimepicker script.
	 *
	 * @since  2.2.7
	 *
	 * @param  boolean $enqueue
	 *
	 * @return void
	 */
	public static function register_datetimepicker( $enqueue = false ) {
		$func = $enqueue ? 'wp_enqueue_script' : 'wp_register_script';
		$func( 'jquery-ui-datetimepicker', RSTHEME_Utils::url( 'js/jquery-ui-timepicker-addon.min.js' ), array( 'jquery-ui-slider' ), '1.5.0' );
	}

	/**
	 * We need to register colorpicker on the front-end
	 *
	 * @since  2.0.7
	 */
	protected static function colorpicker_frontend() {
		wp_register_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), RSTHEME_VERSION,true );
		wp_register_script( 'wp-color-picker', admin_url( 'js/color-picker.min.js' ), array( 'iris' ), RSTHEME_VERSION ,true);
		wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', array(
			'clear'         => esc_html__( 'Clear', 'ultimate-team-showcase' ),
			'defaultString' => esc_html__( 'Default', 'ultimate-team-showcase' ),
			'pick'          => esc_html__( 'Select Color', 'ultimate-team-showcase' ),
			'current'       => esc_html__( 'Current Color', 'ultimate-team-showcase' ),
		) );
	}

	/**
	 * Localize the php variables for RSTHEME JS
	 *
	 * @since  2.0.7
	 */
	protected static function localize( $debug ) {
		static $localized = false;
		if ( $localized ) {
			return;
		}

		$localized = true;
		$l10n = array(
			'fields'            => self::$fields,
			'ajax_nonce'        => wp_create_nonce( 'ajax_nonce' ),
			'ajaxurl'           => admin_url( '/admin-ajax.php' ),
			'script_debug'      => $debug,
			'up_arrow_class'    => 'dashicons dashicons-arrow-up-alt2',
			'down_arrow_class'  => 'dashicons dashicons-arrow-down-alt2',
			'user_can_richedit' => user_can_richedit(),
			'defaults'          => array(
				'code_editor'  => false,
				'color_picker' => false,
				'date_picker'  => array(
					'changeMonth'     => true,
					'changeYear'      => true,
					'dateFormat'      => _x( 'mm/dd/yy', 'Valid formatDate string for jquery-ui datepicker', 'ultimate-team-showcase' ),
					'dayNames'        => explode( ',', esc_html__( 'Sunday, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday', 'ultimate-team-showcase' ) ),
					'dayNamesMin'     => explode( ',', esc_html__( 'Su, Mo, Tu, We, Th, Fr, Sa', 'ultimate-team-showcase' ) ),
					'dayNamesShort'   => explode( ',', esc_html__( 'Sun, Mon, Tue, Wed, Thu, Fri, Sat', 'ultimate-team-showcase' ) ),
					'monthNames'      => explode( ',', esc_html__( 'January, February, March, April, May, June, July, August, September, October, November, December', 'ultimate-team-showcase' ) ),
					'monthNamesShort' => explode( ',', esc_html__( 'Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep, Oct, Nov, Dec', 'ultimate-team-showcase' ) ),
					'nextText'        => esc_html__( 'Next', 'ultimate-team-showcase' ),
					'prevText'        => esc_html__( 'Prev', 'ultimate-team-showcase' ),
					'currentText'     => esc_html__( 'Today', 'ultimate-team-showcase' ),
					'closeText'       => esc_html__( 'Done', 'ultimate-team-showcase' ),
					'clearText'       => esc_html__( 'Clear', 'ultimate-team-showcase' ),
				),
				'time_picker'  => array(
					'timeOnlyTitle' => esc_html__( 'Choose Time', 'ultimate-team-showcase' ),
					'timeText'      => esc_html__( 'Time', 'ultimate-team-showcase' ),
					'hourText'      => esc_html__( 'Hour', 'ultimate-team-showcase' ),
					'minuteText'    => esc_html__( 'Minute', 'ultimate-team-showcase' ),
					'secondText'    => esc_html__( 'Second', 'ultimate-team-showcase' ),
					'currentText'   => esc_html__( 'Now', 'ultimate-team-showcase' ),
					'closeText'     => esc_html__( 'Done', 'ultimate-team-showcase' ),
					'timeFormat'    => _x( 'hh:mm TT', 'Valid formatting string, as per http://trentrichardson.com/examples/timepicker/', 'ultimate-team-showcase' ),
					'controlType'   => 'select',
					'stepMinute'    => 5,
				),
			),
			'strings' => array(
				'upload_file'  => esc_html__( 'Use this file', 'ultimate-team-showcase' ),
				'upload_files' => esc_html__( 'Use these files', 'ultimate-team-showcase' ),
				'remove_image' => esc_html__( 'Remove Image', 'ultimate-team-showcase' ),
				'remove_file'  => esc_html__( 'Remove', 'ultimate-team-showcase' ),
				'file'         => esc_html__( 'File:', 'ultimate-team-showcase' ),
				'download'     => esc_html__( 'Download', 'ultimate-team-showcase' ),
				'check_toggle' => esc_html__( 'Select / Deselect All', 'ultimate-team-showcase' ),
			),
		);

		if ( isset( self::$dependencies['code-editor'] ) && function_exists( 'wp_enqueue_code_editor' ) ) {
			$l10n['defaults']['code_editor'] = wp_enqueue_code_editor( array(
				'type' => 'text/html',
			) );
		}

		wp_localize_script( self::$handle, self::$js_variable, apply_filters( 'rstheme_localized_data', $l10n ) );
	}

}
