<?php

/**
 * A RSTHEME object instance registry for storing every RSTHEME instance.
 *
 * @category  WordPress_Plugin
 * @package   RSTHEME
 * @author    RSTHEME team
 * @license   GPL-2.0+
 * @link      https://rstheme.io
 */
class RSTHEME_Boxes {

	/**
	 * Array of all metabox objects.
	 *
	 * @since 2.0.0
	 * @var array
	 */
	protected static $rstheme_instances = array();

	/**
	 * Add a RSTHEME instance object to the registry.
	 *
	 * @since 1.X.X
	 *
	 * @param RSTHEME $rstheme_instance RSTHEME instance.
	 */
	public static function add( RSTHEME $rstheme_instance ) {
		self::$rstheme_instances[ $rstheme_instance->rstheme_id ] = $rstheme_instance;
	}

	/**
	 * Remove a RSTHEME instance object from the registry.
	 *
	 * @since 1.X.X
	 *
	 * @param string $rstheme_id A RSTHEME instance id.
	 */
	public static function remove( $rstheme_id ) {
		if ( array_key_exists( $rstheme_id, self::$rstheme_instances ) ) {
			unset( self::$rstheme_instances[ $rstheme_id ] );
		}
	}

	/**
	 * Retrieve a RSTHEME instance by rstheme id.
	 *
	 * @since 1.X.X
	 *
	 * @param string $rstheme_id A RSTHEME instance id.
	 *
	 * @return RSTHEME|bool False or RSTHEME object instance.
	 */
	public static function get( $rstheme_id ) {
		if ( empty( self::$rstheme_instances ) || empty( self::$rstheme_instances[ $rstheme_id ] ) ) {
			return false;
		}

		return self::$rstheme_instances[ $rstheme_id ];
	}

	/**
	 * Retrieve all RSTHEME instances registered.
	 *
	 * @since  1.X.X
	 * @return RSTHEME[] Array of all registered rstheme instances.
	 */
	public static function get_all() {
		return self::$rstheme_instances;
	}

	/**
	 * Retrieve all RSTHEME instances that have the specified property set.
	 *
	 * @since  2.4.0
	 * @param  string $property Property name.
	 * @param  mixed  $compare  (Optional) The value to compare.
	 * @return RSTHEME[]           Array of matching rstheme instances.
	 */
	public static function get_by( $property, $compare = 'nocompare' ) {
		$boxes = array();

		foreach ( self::$rstheme_instances as $rstheme_id => $rstheme ) {
			$prop = $rstheme->prop( $property );

			if ( 'nocompare' === $compare ) {
				if ( ! empty( $prop ) ) {
					$boxes[ $rstheme_id ] = $rstheme;
				}
				continue;
			}

			if ( $compare === $prop ) {
				$boxes[ $rstheme_id ] = $rstheme;
			}
		}

		return $boxes;
	}

	/**
	 * Retrieve all RSTHEME instances as long as they do not include the ignored property.
	 *
	 * @since  2.4.0
	 * @param  string $property  Property name.
	 * @param  mixed  $to_ignore The value to ignore.
	 * @return RSTHEME[]            Array of matching rstheme instances.
	 */
	public static function filter_by( $property, $to_ignore = null ) {
		$boxes = array();

		foreach ( self::$rstheme_instances as $rstheme_id => $rstheme ) {

			if ( $to_ignore === $rstheme->prop( $property ) ) {
				continue;
			}

			$boxes[ $rstheme_id ] = $rstheme;
		}

		return $boxes;
	}

	/**
	 * Deprecated and left for back-compatibility. The original `get_by_property`
	 * method was misnamed and never actually used by RSTHEME core.
	 *
	 * @since  2.2.3
	 *
	 * @param  string $property  Property name.
	 * @param  mixed  $to_ignore The value to ignore.
	 * @return RSTHEME[]            Array of matching rstheme instances.
	 */
	public static function get_by_property( $property, $to_ignore = null ) {
		_deprecated_function( __METHOD__, '2.4.0', 'RSTHEME_Boxes::filter_by()' );
		return self::filter_by( $property  );
	} 
}
