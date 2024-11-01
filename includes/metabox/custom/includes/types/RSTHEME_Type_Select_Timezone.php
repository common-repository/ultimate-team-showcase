<?php
/**
 * RSTHEME select_timezone field type
 *
 * @since  2.2.2
 *
 * @category  WordPress_Plugin
 * @package   RSTHEME
 * @author    RSTHEME team
 * @license   GPL-2.0+
 * @link      https://rs.io
 */
class RSTHEME_Type_Select_Timezone extends RSTHEME_Type_Select {

	public function render() {

		$this->field->args['default'] = $this->field->get_default()
			? $this->field->get_default()
			: RSTHEME_Utils::timezone_string();

		$this->args = wp_parse_args( $this->args, array(
			'class'   => 'rs_select rs-select-timezone',
			'options' => wp_timezone_choice( $this->field->escaped_value() ),
			'desc'    => $this->_desc(),
		) );

		return parent::render();
	}
}
