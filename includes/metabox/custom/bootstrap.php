<?php
/**
 * Bootstraps the RSTHEME process
 *
 * @category  WordPress_Plugin
 * @package   RSTHEME
 * @author    RSTHEME
 * @license   GPL-2.0+
 * @link      https://rstheme.io
 */

/**
 * Function to encapsulate the RSTHEME bootstrap process.
 *
 * @since  2.2.0
 * @return void
 */
function rstheme_bootstrap() {

	if ( is_admin() ) {
		/**
		 * Fires on the admin side when RSTHEME is included/loaded.
		 *
		 * In most cases, this should be used to add metaboxes. See example-functions.php
		 */
		do_action( 'rstheme_admin_init' );
	}

	/**
	 * Fires when RSTHEME is included/loaded
	 *
	 * Can be used to add metaboxes if needed on the front-end or WP-API (or the front and backend).
	 */
	do_action( 'rstheme_init' );

	/**
	 * For back-compat. Does the dirty-work of instantiating all the
	 * RSTHEME instances for the rstheme_meta_boxes filter
	 *
	 * @since  2.0.2
	 */
	$rstheme_config_arrays = apply_filters( 'rstheme_meta_boxes', array() );
	foreach ( (array) $rstheme_config_arrays as $rstheme_config ) {
		new RSTHEME( $rstheme_config );
	}

	/**
	 * Fires after all RSTHEME instances are created
	 */
	do_action( 'rstheme_init_before_hookup' );

	/**
	 * Get all created metaboxes, and instantiate RSTHEME_hookup
	 * on metaboxes which require it.
	 *
	 * @since  2.0.2
	 */
	foreach ( RSTHEME_Boxes::get_all() as $rstheme ) {

		/**
		 * Initiates the box "hookup" into WordPress.
		 *
		 * Unless the 'hookup' box property is `false`, the box will be hooked in as
		 * a post/user/comment/option/term box.
		 *
		 * And if the 'show_in_rest' box property is set, the box will be hooked
		 * into the RSTHEME REST API.
		 *
		 * The dynamic portion of the hook name, $rstheme->rstheme_id, is the box id.
		 *
		 * @since 2.2.6
		 *
		 * @param array $rstheme The RSTHEME object to hookup.
		 */
		do_action( "rstheme_init_hookup_{$rstheme->rstheme_id}", $rstheme );
	}

	/**
	 * Fires after RSTHEME initiation process has been completed
	 */
	do_action( 'rstheme_after_init' );
}

/* End. That's it, folks! */
