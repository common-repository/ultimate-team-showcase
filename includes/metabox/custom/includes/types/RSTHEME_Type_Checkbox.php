<?php
/**
 * RSTHEME checkbox field type
 *
 * @since  2.2.2
 *
 * @category  WordPress_Plugin
 * @package   RSTHEME
 * @author    RSTHEME team
 * @license   GPL-2.0+
 * @link      https://rs.io
 */
class RSTHEME_Type_Checkbox extends RSTHEME_Type_Text {

	/**
	 * If checkbox is checked
	 *
	 * @var mixed
	 */
	public $is_checked = null;

	/**
	 * Constructor
	 *
	 * @since 2.2.2
	 *
	 * @param RSTHEME_Types $types
	 * @param array      $args
	 */
	public function __construct( RSTHEME_Types $types, $args = array(), $is_checked = null ) {
		parent::__construct( $types, $args );
		$this->is_checked = $is_checked;
	}

	public function render( $args = array() ) {
		$defaults = array(
			'type'  => 'checkbox',
			'class' => 'rs-option rs-list',
			'value' => 'on',
			'desc'  => '',
		);

		$meta_value = $this->field->escaped_value();

		$is_checked = null === $this->is_checked
			? ! empty( $meta_value )
			: $this->is_checked;

		if ( $is_checked ) {
			$defaults['checked'] = 'checked';
		}

		$args = $this->parse_args( 'checkbox', $defaults );

		return $this->rendered(
			sprintf(
				'%s <label for="%s">%s</label>',
				parent::render( $args ),
				$this->_id(),
				$this->_desc()
			)
		);
	}

}
