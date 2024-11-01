<?php
/**
 * RSTHEME text_date field type
 *
 * @since  2.2.2
 *
 * @category  WordPress_Plugin
 * @package   RSTHEME
 * @author    RSTHEME team
 * @license   GPL-2.0+
 * @link      https://rs.io
 */
class RSTHEME_Type_Text_Date extends RSTHEME_Type_Picker_Base {

	public function render( $args = array() ) {
		$args = $this->parse_args( 'text_date', array(
			'class'           => 'rs-text-small rs-datepicker',
			'value'           => $this->field->get_timestamp_format(),
			'desc'            => $this->_desc(),
			'js_dependencies' => array( 'jquery-ui-core', 'jquery-ui-datepicker' ),
		) );

		if ( false === strpos( $args['class'], 'timepicker' ) ) {
			$this->parse_picker_options( 'date' );
		}

		return parent::render( $args );
	}

}
