<?php
/**
 * RSTHEME radio field type
 *
 * @since  2.2.2
 *
 * @category  WordPress_Plugin
 * @package   RSTHEME
 * @author    RSTHEME team
 * @license   GPL-2.0+
 * @link      https://rs.io
 */
class RSTHEME_Type_Radio extends RSTHEME_Type_Multi_Base {

	/**
	 * The type of radio field
	 *
	 * @var string
	 */
	public $type = 'radio';

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

	public function render() {
		$args = $this->parse_args( $this->type, array(
			'class'   => 'rs-radio-list rs-list',
			'options' => $this->concat_items( array(
				'label'  => 'test',
				'method' => 'list_input',
			) ),
			'desc' => $this->_desc( true ),
		) );

		return $this->rendered( $this->ul( $args ) );
	}

	protected function ul( $a ) {
		return sprintf( '<ul class="%s">%s</ul>%s', $a['class'], $a['options'], $a['desc'] );
	}

}
