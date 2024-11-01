<?php
/**
 * RSTHEME select field type
 *
 * @since  2.2.2
 *
 * @category  WordPress_Plugin
 * @package   RSTHEME
 * @author    RSTHEME team
 * @license   GPL-2.0+
 * @link      https://rs.io
 */
class RSTHEME_Type_Select extends RSTHEME_Type_Multi_Base {

	public function render() {
		$a = $this->parse_args( 'select', array(
			'class'   => 'rs_select',
			'name'    => $this->_name(),
			'id'      => $this->_id(),
			'desc'    => $this->_desc( true ),
			'options' => $this->concat_items(),
		) );

		$attrs = $this->concat_attrs( $a, array( 'desc', 'options' ) );

		return $this->rendered(
			sprintf( '<select %s>%s</select>%s', $attrs, $a['options'], $a['desc'] )
		);
	}
}
