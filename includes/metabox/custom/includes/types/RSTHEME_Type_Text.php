<?php
/**
 * RSTHEME text field type
 *
 * @since  2.2.2
 *
 * @category  WordPress_Plugin
 * @package   RSTHEME
 * @author    RSTHEME team
 * @license   GPL-2.0+
 * @link      https://rs.io
 */
class RSTHEME_Type_Text extends RSTHEME_Type_Base {

	/**
	 * The type of field
	 *
	 * @var string
	 */
	public $type = 'input';

	/**
	 * Constructor
	 *
	 * @since 2.2.2
	 *
	 * @param RSTHEME_Types $types
	 * @param array      $args
	 */
	public function __construct( RSTHEME_Types $types, $args = array(), $type = '' ) {
		parent::__construct( $types, $args );
		$this->type = $type ? $type : $this->type;
	}

	/**
	 * Handles outputting an 'input' element
	 *
	 * @since  1.1.0
	 * @param  array $args Override arguments
	 * @return string       Form input element
	 */
	public function render( $args = array() ) {
		$args = empty( $args ) ? $this->args : $args;
		$a = $this->parse_args( $this->type, array(
			'type'            => 'text',
			'class'           => 'regular-text',
			'name'            => $this->_name(),
			'id'              => $this->_id(),
			'value'           => $this->field->escaped_value(),
			'desc'            => $this->_desc( true ),
			'js_dependencies' => array(),
		), $args );

		return $this->rendered(
			sprintf( '<input%s/>%s', $this->concat_attrs( $a, array( 'desc' ) ), $a['desc'] )
		);
	}
}
