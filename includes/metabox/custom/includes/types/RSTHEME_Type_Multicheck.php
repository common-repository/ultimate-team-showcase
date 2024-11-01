<?php
/**
 * RSTHEME multicheck field type
 *
 * @since  2.2.2
 *
 * @category  WordPress_Plugin
 * @package   RSTHEME
 * @author    RSTHEME team
 * @license   GPL-2.0+
 * @link      https://rs.io
 */
class RSTHEME_Type_Multicheck extends RSTHEME_Type_Radio {

	/**
	 * The type of radio field
	 *
	 * @var string
	 */
	public $type = 'checkbox';

	public function render( $args = array() ) {
		$classes = false === $this->field->args( 'select_all_button' )
			? 'rs-checkbox-list no-select-all rs-list'
			: 'rs-checkbox-list rs-list';

		$args = $this->parse_args( $this->type, array(
			'class'   => $classes,
			'options' => $this->concat_items( array(
				'name'   => $this->_name() . '[]',
				'method' => 'list_input_checkbox',
			) ),
			'desc' => $this->_desc( true ),
		) );

		return $this->rendered( $this->ul( $args ) );
	}

}
