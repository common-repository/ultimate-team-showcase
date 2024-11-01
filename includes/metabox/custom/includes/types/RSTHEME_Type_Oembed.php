<?php
/**
 * RSTHEME oembed field type
 *
 * @since  2.2.2
 *
 * @category  WordPress_Plugin
 * @package   RSTHEME
 * @author    RSTHEME team
 * @license   GPL-2.0+
 * @link      https://rs.io
 */
class RSTHEME_Type_Oembed extends RSTHEME_Type_Text {

	public function render( $args = array() ) {
		$field = $this->field;

		$meta_value = trim( $field->escaped_value() );

		$oembed = ! empty( $meta_value )
			? rs_ajax()->get_oembed( array(
				'url'         => $field->escaped_value(),
				'object_id'   => $field->object_id,
				'object_type' => $field->object_type,
				'oembed_args' => array(
					'width' => '640',
				),
				'field_id'    => $this->_id(),
			) )
			: '';

		return parent::render( array(
			'class'           => 'rs-oembed regular-text',
			'data-objectid'   => $field->object_id,
			'data-objecttype' => $field->object_type,
		) )
		. '<p class="rs-spinner spinner"></p>'
		. '<div id="' . $this->_id( '-status' ) . '" class="rs-media-status ui-helper-clearfix embed_wrap">' . $oembed . '</div>';
	}

}
