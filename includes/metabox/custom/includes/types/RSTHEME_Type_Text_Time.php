<?php
/**
 * RSTHEME text_time field type
 *
 * @since  2.2.2
 *
 * @category  WordPress_Plugin
 * @package   RSTHEME
 * @author    RSTHEME team
 * @license   GPL-2.0+
 * @link      https://rs.io
 */
class RSTHEME_Type_Text_Time extends RSTHEME_Type_Text_Date {

	public function render( $args = array() ) {
		$this->args = $this->parse_picker_options( 'time', wp_parse_args( $this->args, array(
			'class'           => 'rs-timepicker text-time',
			'value'           => $this->field->get_timestamp_format( 'time_format' ),
			'js_dependencies' => array( 'jquery-ui-core', 'jquery-ui-datepicker', 'jquery-ui-datetimepicker' ),
		) ) );

		return parent::render();
	}

}
