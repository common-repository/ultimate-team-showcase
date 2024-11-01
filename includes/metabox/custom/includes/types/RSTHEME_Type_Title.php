<?php
/**
 * RSTHEME title field type
 *
 * @since  2.2.2
 *
 * @category  WordPress_Plugin
 * @package   RSTHEME
 * @author    RSTHEME team
 * @license   GPL-2.0+
 * @link      https://rs.io
 */
class RSTHEME_Type_Title extends RSTHEME_Type_Base {

	/**
	 * Handles outputting an 'title' element
	 *
	 * @return string Heading element
	 */
	public function render() {
		$name = $this->field->args( 'name' );
		$tag  = 'span';

		if ( ! empty( $name ) ) {
			$tag = $this->field->object_type == 'post' ? 'h5' : 'h3';
		}

		$a = $this->parse_args( 'title', array(
			'tag'   => $tag,
			'class' => empty( $name ) ? 'rs-metabox-title-anchor' : 'rs-metabox-title',
			'name'  => $name,
			'desc'  => $this->_desc( true ),
			'id'    => str_replace( '_', '-', sanitize_html_class( $this->field->id() ) ),
		) );

		return $this->rendered(
			sprintf(
				'<%1$s %2$s>%3$s</%1$s>%4$s',
				$a['tag'],
				$this->concat_attrs( $a, array( 'tag', 'name', 'desc' ) ),
				$a['name'],
				$a['desc']
			)
		);
	}

}
