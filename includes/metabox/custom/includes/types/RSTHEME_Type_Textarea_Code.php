<?php
/**
 * RSTHEME textarea_code field type
 *
 * @since  2.2.2
 *
 * @category  WordPress_Plugin
 * @package   RSTHEME
 * @author    RSTHEME team
 * @license   GPL-2.0+
 * @link      https://rs.io
 */
class RSTHEME_Type_Textarea_Code extends RSTHEME_Type_Textarea {

	/**
	 * Handles outputting an 'textarea' element
	 *
	 * @since  1.1.0
	 * @param  array $args Override arguments
	 * @return string       Form textarea element
	 */
	public function render( $args = array() ) {
		$args = wp_parse_args( $args, array(
			'class' => 'rs-textarea-code',
			'desc'  => '</pre>' . $this->_desc( true ),
		) );

		if ( true !== $this->field->options( 'disable_codemirror' )
			&& function_exists( 'wp_enqueue_code_editor' ) ) {
			$args['js_dependencies'] = array( 'code-editor' );
		} else {
			$args['class'] = rtrim( $args['class'] ) . ' disable-codemirror';
		}

		return $this->rendered(
			sprintf( '<pre>%s', parent::render( $args ) )
		);
	}
}
