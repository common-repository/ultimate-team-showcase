<?php
/**
 * RSTHEME Helper Functions
 *
 * @category  WordPress_Plugin
 * @package   RSTHEME
 * @author    RSTHEME team
 * @license   GPL-2.0+
 * @link      https://rstheme.io
 */

/**
 * Helper function to provide directory path to RSTHEME
 *
 * @since  2.0.0
 * @param  string $path Path to append
 * @return string        Directory with optional path appended
 */
function rstheme_dir( $path = '' ) {
	return RSTHEME_DIR . $path;
}

/**
 * Autoloads files with RSTHEME classes when needed
 *
 * @since  1.0.0
 * @param  string $class_name Name of the class being requested
 */
function rstheme_autoload_classes( $class_name ) {
	if ( 0 !== strpos( $class_name, 'RSTHEME' ) ) {
		return;
	}

	$path = 'includes';

	if ( 'RSTHEME_Type' === $class_name || 0 === strpos( $class_name, 'RSTHEME_Type_' ) ) {
		$path .= '/types';
	}

	if ( 'RSTHEME_REST' === $class_name || 0 === strpos( $class_name, 'RSTHEME_REST_' ) ) {
		$path .= '/rest-api';
	}

	include_once( rstheme_dir( "$path/{$class_name}.php" ) );
}

/**
 * Get instance of the RSTHEME_Utils class
 *
 * @since  2.0.0
 * @return RSTHEME_Utils object RSTHEME utilities class
 */
function rstheme_utils() {
	static $rstheme_utils;
	$rstheme_utils = $rstheme_utils ? $rstheme_utils : new RSTHEME_Utils();
	return $rstheme_utils;
}

/**
 * Get instance of the RSTHEME_Ajax class
 *
 * @since  2.0.0
 * @return RSTHEME_Ajax object RSTHEME ajax class
 */
function rstheme_ajax() {
	return RSTHEME_Ajax::get_instance();
}

/**
 * Get instance of the RSTHEME_Option class for the passed metabox ID
 *
 * @since  2.0.0
 * @return RSTHEME_Option object Options class for setting/getting options for metabox
 */
function rstheme_options( $key ) {
	return RSTHEME_Options::get( $key );
}

/**
 * Get a rstheme oEmbed. Handles oEmbed getting for non-post objects
 *
 * @since  2.0.0
 * @param  array $args Arguments. Accepts:
 *
 *       'url'         - URL to retrieve the oEmbed from,
 *       'object_id'   - $post_id,
 *       'object_type' - 'post',
 *       'oembed_args' - $embed_args, // array containing 'width', etc
 *       'field_id'    - false,
 *       'cache_key'   - false,
 *       'wp_error'    - true/false, // To return a wp_error object if no embed found.
 *
 * @return string        oEmbed string
 */
function rstheme_get_oembed( $args = array() ) {
	$oembed = rstheme_ajax()->get_oembed_no_edit( $args );

	// Send back our embed
	if ( $oembed['embed'] && $oembed['embed'] != $oembed['fallback'] ) {
		return '<div class="rstheme-oembed">' . $oembed['embed'] . '</div>';
	}

	$error = sprintf(
		/* translators: 1: results for. 2: link to codex.wordpress.org/Embeds */
		esc_html__( 'No oEmbed Results Found for %1$s. View more info at %2$s.', 'ultimate-team-showcase' ),
		$oembed['fallback'],
		'<a href="https://codex.wordpress.org/Embeds" target="_blank">codex.wordpress.org/Embeds</a>'
	);

	if ( isset( $args['wp_error'] ) && $args['wp_error'] ) {
		return new WP_Error( 'rstheme_get_oembed_result', $error, compact( 'oembed', 'args' ) );
	}

	// Otherwise, send back error info that no oEmbeds were found
	return '<p class="ui-state-error-text">' . $error . '</p>';
}

/**
 * Outputs the return of rstheme_get_oembed.
 *
 * @since  2.2.2
 * @see rstheme_get_oembed
 */
function rstheme_do_oembed( $args = array() ) {
	echo esc_html( rstheme_get_oembed( $args ));
}
add_action( 'rstheme_do_oembed', 'rstheme_do_oembed' );

/**
 * A helper function to get an option from a RSTHEME options array
 *
 * @since  1.0.1
 * @param  string $option_key Option key
 * @param  string $field_id   Option array field key
 * @param  mixed  $default    Optional default fallback value
 * @return array               Options array or specific field
 */
function rstheme_get_option( $option_key, $field_id = '', $default = false ) {
	return rstheme_options( $option_key )->get( $field_id, $default );
}

/**
 * A helper function to update an option in a RSTHEME options array
 *
 * @since  2.0.0
 * @param  string  $option_key Option key
 * @param  string  $field_id   Option array field key
 * @param  mixed   $value      Value to update data with
 * @param  boolean $single     Whether data should not be an array
 * @return boolean             Success/Failure
 */
function rstheme_update_option( $option_key, $field_id, $value, $single = true ) {
	if ( rstheme_options( $option_key )->update( $field_id, $value, false, $single ) ) {
		return rstheme_options( $option_key )->set();
	}

	return false;
}

/**
 * Get a RSTHEME field object.
 *
 * @since  1.1.0
 * @param  array  $meta_box    Metabox ID or Metabox config array
 * @param  array  $field_id    Field ID or all field arguments
 * @param  int    $object_id   Object ID
 * @param  string $object_type Type of object being saved. (e.g., post, user, comment, or options-page).
 *                             Defaults to metabox object type.
 * @return RSTHEME_Field|null     RSTHEME_Field object unless metabox config cannot be found
 */
function rstheme_get_field( $meta_box, $field_id, $object_id = 0, $object_type = '' ) {

	$object_id = $object_id ? $object_id : get_the_ID();
	$rstheme = $meta_box instanceof RSTHEME ? $meta_box : rstheme_get_metabox( $meta_box, $object_id );

	if ( ! $rstheme ) {
		return;
	}

	$rstheme->object_type( $object_type ? $object_type : $rstheme->mb_object_type() );

	return $rstheme->get_field( $field_id );
}

/**
 * Get a field's value.
 *
 * @since  1.1.0
 * @param  array  $meta_box    Metabox ID or Metabox config array
 * @param  array  $field_id    Field ID or all field arguments
 * @param  int    $object_id   Object ID
 * @param  string $object_type Type of object being saved. (e.g., post, user, comment, or options-page).
 *                             Defaults to metabox object type.
 * @return mixed               Maybe escaped value
 */
function rstheme_get_field_value( $meta_box, $field_id, $object_id = 0, $object_type = '' ) {
	$field = rstheme_get_field( $meta_box, $field_id, $object_id, $object_type );
	return $field->escaped_value();
}

/**
 * Because OOP can be scary
 *
 * @since  2.0.2
 * @param  array $meta_box_config Metabox Config array
 * @return RSTHEME object            Instantiated RSTHEME object
 */
function new_rstheme_box( array $meta_box_config ) {
	return rstheme_get_metabox( $meta_box_config );
}

/**
 * Retrieve a RSTHEME instance by the metabox ID
 *
 * @since  2.0.0
 * @param  mixed  $meta_box    Metabox ID or Metabox config array
 * @param  int    $object_id   Object ID
 * @param  string $object_type Type of object being saved. (e.g., post, user, comment, or options-page).
 *                             Defaults to metabox object type.
 * @return RSTHEME object
 */
function rstheme_get_metabox( $meta_box, $object_id = 0, $object_type = '' ) {

	if ( $meta_box instanceof RSTHEME ) {
		return $meta_box;
	} 

	if ( is_string( $meta_box ) ) {
		$rstheme = RSTHEME_Boxes::get( $meta_box );
	} else {
		// See if we already have an instance of this metabox
		$rstheme = RSTHEME_Boxes::get( $meta_box['id'] );
		// If not, we'll initate a new metabox
		$rstheme = $rstheme ? $rstheme : new RSTHEME( $meta_box, $object_id );
	}

	if ( $rstheme && $object_id ) {
		$rstheme->object_id( $object_id );
	}

	if ( $rstheme && $object_type ) {
		$rstheme->object_type( $object_type );
	}

	return $rstheme;
}

/**
 * Returns array of sanitized field values from a metabox (without saving them)
 *
 * @since  2.0.3
 * @param  mixed $meta_box         Metabox ID or Metabox config array
 * @param  array $data_to_sanitize Array of field_id => value data for sanitizing (likely $_POST data).
 * @return mixed                   Array of sanitized values or false if no RSTHEME object found
 */
function rstheme_get_metabox_sanitized_values( $meta_box, array $data_to_sanitize ) {
	$rstheme = rstheme_get_metabox( $meta_box );
	return $rstheme ? $rstheme->get_sanitized_values( $data_to_sanitize ) : false;
}

/**
 * Retrieve a metabox form
 *
 * @since  2.0.0
 * @param  mixed $meta_box  Metabox config array or Metabox ID
 * @param  int   $object_id Object ID
 * @param  array $args      Optional arguments array
 * @return string             RSTHEME html form markup
 */
function rstheme_get_metabox_form( $meta_box, $object_id = 0, $args = array() ) {

	$object_id = $object_id ? $object_id : get_the_ID();
	$rstheme       = rstheme_get_metabox( $meta_box, $object_id );

	ob_start();
	// Get rstheme form
	rstheme_print_metabox_form( $rstheme, $object_id, $args );
	$form = ob_get_clean();

	return apply_filters( 'rstheme_get_metabox_form', $form, $object_id, $rstheme );
}

/**
 * Display a metabox form & save it on submission
 *
 * @since  1.0.0
 * @param  mixed $meta_box  Metabox config array or Metabox ID
 * @param  int   $object_id Object ID
 * @param  array $args      Optional arguments array
 */
function rstheme_print_metabox_form( $meta_box, $object_id = 0, $args = array() ) {

	$object_id = $object_id ? $object_id : get_the_ID();
	$rstheme = rstheme_get_metabox( $meta_box, $object_id );

	// if passing a metabox ID, and that ID was not found
	if ( ! $rstheme ) {
		return;
	}

	$args = wp_parse_args( $args, array(
		'form_format' => '<form class="rstheme-form" method="post" id="%1$s" enctype="multipart/form-data" encoding="multipart/form-data"><input type="hidden" name="object_id" value="%2$s">%3$s<input type="submit" name="submit-rstheme" value="%4$s" class="button-primary"></form>',
		'save_button' => esc_html__( 'Save', 'ultimate-team-showcase' ),
		'object_type' => $rstheme->mb_object_type(),
		'rstheme_styles'  => $rstheme->prop( 'rstheme_styles' ),
		'enqueue_js'  => $rstheme->prop( 'enqueue_js' ),
	) );

	// Set object type explicitly (rather than trying to guess from context)
	$rstheme->object_type( $args['object_type'] );

	// Save the metabox if it's been submitted
	// check permissions
	// @todo more hardening?
	if (
		$rstheme->prop( 'save_fields' )
		// check nonce
		&& isset( $_POST['submit-rstheme'], $_POST['object_id'], $_POST[ $rstheme->nonce() ] )
		&& wp_verify_nonce( $_POST[ $rstheme->nonce() ], $rstheme->nonce() )
		&& $object_id && $_POST['object_id'] == $object_id
	) {
		$rstheme->save_fields( $object_id, $rstheme->object_type(), $_POST );
	}

	// Enqueue JS/CSS
	if ( $args['rstheme_styles'] ) {
		RSTHEME_hookup::enqueue_rstheme_css();
	}

	if ( $args['enqueue_js'] ) {
		RSTHEME_hookup::enqueue_rstheme_js();
	}

	$form_format = apply_filters( 'rstheme_get_metabox_form_format', $args['form_format'], $object_id, $rstheme );

	$format_parts = explode( '%3$s', $form_format );

	// Show rstheme form
	
	printf( esc_html( $format_parts[0] ), esc_attr( $rstheme->rstheme_id ), esc_attr( $object_id ) );

	$rstheme->show_form();

	if ( isset( $format_parts[1] ) && $format_parts[1] ) {
		
		printf( esc_html( str_ireplace( '%4$s', '%1$s', $format_parts[1] ) ), esc_attr( $args['save_button'] ) );
	}

}

/**
 * Display a metabox form (or optionally return it) & save it on submission
 *
 * @since  1.0.0
 * @param  mixed $meta_box  Metabox config array or Metabox ID
 * @param  int   $object_id Object ID
 * @param  array $args      Optional arguments array
 */
function rstheme_metabox_form( $meta_box, $object_id = 0, $args = array() ) {
	if ( ! isset( $args['echo'] ) || $args['echo'] ) {
		rstheme_print_metabox_form( $meta_box, $object_id, $args );
	} else {
		return rstheme_get_metabox_form( $meta_box, $object_id, $args );
	}
}

if ( ! function_exists( 'date_create_from_format' ) ) {

	/**
	 *
	 * @param $date_format
	 * @param $date_value
	 *
	 * @return DateTime
	 */
	function date_create_from_format( $date_format, $date_value ) {

		$schedule_format = str_replace(
			array( 'M', 'Y', 'm', 'd', 'H', 'i', 'a' ),
			array( '%b', '%Y', '%m', '%d', '%H', '%M', '%p' ),
			$date_format
		);

		/*
		 * %Y, %m and %d correspond to date()'s Y m and d.
		 * %I corresponds to H, %M to i and %p to a
		 */
		$parsed_time = strptime( $date_value, $schedule_format );

		$ymd = sprintf(
			/*
			 * This is a format string that takes six total decimal
			 * arguments, then left-pads them with zeros to either
			 * 4 or 2 characters, as needed
			 */
			'%04d-%02d-%02d %02d:%02d:%02d',
			$parsed_time['tm_year'] + 1900,  // This will be "111", so we need to add 1900.
			$parsed_time['tm_mon'] + 1,      // This will be the month minus one, so we add one.
			$parsed_time['tm_mday'],
			$parsed_time['tm_hour'],
			$parsed_time['tm_min'],
			$parsed_time['tm_sec']
		);

		return new DateTime( $ymd );
	}
}// End if().

if ( ! function_exists( 'date_timestamp_get' ) ) {

	/**
	 * Returns the Unix timestamp representing the date.
	 * Reimplementation of DateTime::getTimestamp for PHP < 5.3. :(
	 *
	 * @param DateTime
	 *
	 * @return int
	 */
	function date_timestamp_get( DateTime $date ) {
		return $date->format( 'U' );
	}
}// End if().
