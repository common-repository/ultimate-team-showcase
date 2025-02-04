<?php
/**
 * RSTHEME text_datetime_timestamp_timezone field type
 *
 * @since  2.2.2
 *
 * @category  WordPress_Plugin
 * @package   RSTHEME
 * @author    RSTHEME team
 * @license   GPL-2.0+
 * @link      https://rs.io
 */
class RSTHEME_Type_Text_Datetime_Timestamp_Timezone extends RSTHEME_Type_Base {

	public function render( $args = array() ) {
		$field = $this->field;

		$args = wp_parse_args( $this->args, array(
			'value'                   => $field->escaped_value(),
			'desc'                    => $this->_desc( true ),
			'text_datetime_timestamp' => array(),
			'select_timezone'         => array(),
		) );

		$args['value'] = $field->escaped_value();
		if ( is_array( $args['value'] ) ) {
			$args['value'] = '';
		}

		$datetime = maybe_unserialize( $args['value'] );
		$value = $tzstring = '';

		if ( $datetime && $datetime instanceof DateTime ) {
			$tz       = $datetime->getTimezone();
			$tzstring = $tz->getName();
			$value    = $datetime->getTimestamp();
		}

		$timestamp_args = wp_parse_args( $args['text_datetime_timestamp'], array(
			'desc'     => '',
			'value'    => $value,
			'rendered' => true,
		) );
		$datetime_timestamp = $this->types->text_datetime_timestamp( $timestamp_args );

		$timezone_select_args = wp_parse_args( $args['select_timezone'], array(
			'class'    => 'rs_select rs-select-timezone',
			'name'     => $this->_name( '[timezone]' ),
			'id'       => $this->_id( '_timezone' ),
			'options'  => wp_timezone_choice( $tzstring ),
			'desc'     => $args['desc'],
			'rendered' => true,
		) );
		$select = $this->types->select( $timezone_select_args );

		return $this->rendered(
			$datetime_timestamp . "\n" . $select
		);
	}

}
