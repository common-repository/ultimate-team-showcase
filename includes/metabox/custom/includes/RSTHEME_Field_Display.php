<?php
/**
 * RSTHEME field display base.
 *
 * @since 2.2.2
 *
 * @category  WordPress_Plugin
 * @package   RSTHEME
 * @author    RSTHEME team
 * @license   GPL-2.0+
 * @link      https://rstheme.io
 */
class RSTHEME_Field_Display {

	/**
	 * A RSTHEME field object
	 *
	 * @var   RSTHEME_Field object
	 * @since 2.2.2
	 */
	public $field;

	/**
	 * The RSTHEME field object's value.
	 *
	 * @var   mixed
	 * @since 2.2.2
	 */
	public $value;

	/**
	 * Get the corresponding display class for the field type.
	 *
	 * @since  2.2.2
	 * @param  RSTHEME_Field $field
	 * @return RSTHEME_Field_Display
	 */
	public static function get( RSTHEME_Field $field ) {
		switch ( $field->type() ) {
			case 'text_url':
				$type = new RSTHEME_Display_Text_Url( $field );
				break;
			case 'text_money':
				$type = new RSTHEME_Display_Text_Money( $field );
				break;
			case 'colorpicker':
				$type = new RSTHEME_Display_Colorpicker( $field );
				break;
			case 'checkbox':
				$type = new RSTHEME_Display_Checkbox( $field );
				break;
			case 'wysiwyg':
			case 'textarea_small':
				$type = new RSTHEME_Display_Textarea( $field );
				break;
			case 'textarea_code':
				$type = new RSTHEME_Display_Textarea_Code( $field );
				break;
			case 'text_time':
				$type = new RSTHEME_Display_Text_Time( $field );
				break;
			case 'text_date':
			case 'text_date_timestamp':
			case 'text_datetime_timestamp':
				$type = new RSTHEME_Display_Text_Date( $field );
				break;
			case 'text_datetime_timestamp_timezone':
				$type = new RSTHEME_Display_Text_Date_Timezone( $field );
				break;
			case 'select':
			case 'radio':
			case 'radio_inline':
				$type = new RSTHEME_Display_Select( $field );
				break;
			case 'multicheck':
			case 'multicheck_inline':
				$type = new RSTHEME_Display_Multicheck( $field );
				break;
			case 'taxonomy_radio':
			case 'taxonomy_radio_inline':
			case 'taxonomy_select':
			case 'taxonomy_radio_hierarchical':
				$type = new RSTHEME_Display_Taxonomy_Radio( $field );
				break;
			case 'taxonomy_multicheck':
			case 'taxonomy_multicheck_inline':
			case 'taxonomy_multicheck_hierarchical':
				$type = new RSTHEME_Display_Taxonomy_Multicheck( $field );
				break;
			case 'file':
				$type = new RSTHEME_Display_File( $field );
				break;
			case 'file_list':
				$type = new RSTHEME_Display_File_List( $field );
				break;
			case 'oembed':
				$type = new RSTHEME_Display_oEmbed( $field );
				break;
			default:
				$type = new self( $field );
				break;
		}// End switch().

		return $type;
	}

	/**
	 * Setup our class vars
	 *
	 * @since 2.2.2
	 * @param RSTHEME_Field $field A RSTHEME field object
	 */
	public function __construct( RSTHEME_Field $field ) {
		$this->field = $field;
		$this->value = $this->field->value;
	}

	/**
	 * Catchall method if field's 'display_cb' is NOT defined, or field type does
	 * not have a corresponding display method
	 *
	 * @since 2.2.2
	 */
	public function display() {
		// If repeatable
		if ( $this->field->args( 'repeatable' ) ) {

			// And has a repeatable value
			if ( is_array( $this->field->value ) ) {

				// Then loop and output.
				echo '<ul class="rstheme-' . esc_attr( str_replace( '_', '-', $this->field->type() ) ) . '">';

				foreach ( $this->field->value as $val ) {
					$this->value = $val;
					echo '<li>', esc_html( $this->_display() ), '</li>';
					;
				}
				echo '</ul>';
			}
		} else {
			$this->_display();
		}
	}

	/**
	 * Default fallback display method.
	 *
	 * @since 2.2.2
	 */
	protected function _display() {
		print_r( $this->value );
	}
}

class RSTHEME_Display_Text_Url extends RSTHEME_Field_Display {
	/**
	 * Display url value.
	 *
	 * @since 2.2.2
	 */
	protected function _display() {
		echo wp_kses( make_clickable( esc_url( $this->value ) ));
	}
}

class RSTHEME_Display_Text_Money extends RSTHEME_Field_Display {
	/**
	 * Display text_money value.
	 *
	 * @since 2.2.2
	 */
	protected function _display() {
    $this->value = $this->value ? $this->value : '0';
    echo esc_html( ( ! $this->field->get_param_callback_result( 'before_field' ) ? '$' : ' ' ) . $this->value );
}

}

class RSTHEME_Display_Colorpicker extends RSTHEME_Field_Display {
	/**
	 * Display color picker value.
	 *
	 * @since 2.2.2
	 */
	protected function _display() {
		echo '<span class="rstheme-colorpicker-swatch"><span style="background-color:', esc_attr( $this->value ), '"></span> ', esc_html( $this->value ), '</span>';
	}
}

class RSTHEME_Display_Checkbox extends RSTHEME_Field_Display {
	/**
	 * Display multicheck value.
	 *
	 * @since 2.2.2
	 */
	protected function _display() {
		print $this->value === 'on' ? 'on' : 'off';
	}
}

class RSTHEME_Display_Select extends RSTHEME_Field_Display {
	/**
	 * Display select value.
	 *
	 * @since 2.2.2
	 */
	protected function _display() {
		$options = $this->field->options();

		$fallback = $this->field->args( 'show_option_none' );
		if ( ! $fallback && isset( $options[''] ) ) {
			$fallback = $options[''];
		}
		if ( ! $this->value && $fallback ) {
			echo esc_attr( $fallback );
		} elseif ( isset( $options[ $this->value ] ) ) {
			echo esc_attr( $options[ $this->value ] );
		} else {
			echo esc_attr( $this->value );
		}
	}
}

class RSTHEME_Display_Multicheck extends RSTHEME_Field_Display {
	/**
	 * Display multicheck value.
	 *
	 * @since 2.2.2
	 */
	protected function _display() {
	    if ( empty( $this->value ) || ! is_array( $this->value ) ) {
	        return;
	    }

	    $options = $this->field->options();

	    $output = array();
	    foreach ( $this->value as $val ) {
	        if ( isset( $options[ $val ] ) ) {
	            $output[] = esc_html( $options[ $val ] ); // Escaping HTML attributes
	        } else {
	            $output[] = esc_attr( $val ); // Escaping HTML attributes
	        }
	    }

	    echo implode( ', ', esc_attr($output) );
	}

}

class RSTHEME_Display_Textarea extends RSTHEME_Field_Display {
	/**
	 * Display textarea value.
	 *
	 * @since 2.2.2
	 */
	protected function _display() {
	    echo esc_html( wpautop( wp_kses_post( $this->value ) ) );
	}

}

class RSTHEME_Display_Textarea_Code extends RSTHEME_Field_Display {
	/**
	 * Display textarea_code value.
	 *
	 * @since 2.2.2
	 */
	protected function _display() {
	    echo '<xmp class="rstheme-code">' . esc_html( print_r( $this->value, true ) ) . '</xmp>';
	}

}

class RSTHEME_Display_Text_Time extends RSTHEME_Field_Display {
	/**
	 * Display text_time value.
	 *
	 * @since 2.2.2
	 */
	protected function _display() {
	    echo esc_html( $this->field->get_timestamp_format( 'time_format', $this->value ) );
	}

}

class RSTHEME_Display_Text_Date extends RSTHEME_Field_Display {
	/**
	 * Display text_date value.
	 *
	 * @since 2.2.2
	 */
	protected function _display() {
		echo esc_html( $this->field->get_timestamp_format( 'date_format', $this->value ));
	}
}

class RSTHEME_Display_Text_Date_Timezone extends RSTHEME_Field_Display {
	/**
	 * Display text_datetime_timestamp_timezone value.
	 *
	 * @since 2.2.2
	 */
	protected function _display() {
		$field = $this->field;

		if ( empty( $this->value ) ) {
			return;
		}

		$datetime = maybe_unserialize( $this->value );
		$this->value = $tzstring = '';

		if ( $datetime && $datetime instanceof DateTime ) {
			$tz       = $datetime->getTimezone();
			$tzstring = $tz->getName();
			$this->value    = $datetime->getTimestamp();
		}

		$date = $this->field->get_timestamp_format( 'date_format', $this->value );
		$time = $this->field->get_timestamp_format( 'time_format', $this->value );
	}
}

class RSTHEME_Display_Taxonomy_Radio extends RSTHEME_Field_Display {
	/**
	 * Display single taxonomy value.
	 *
	 * @since 2.2.2
	 */
	protected function _display() {
		$taxonomy = $this->field->args( 'taxonomy' );
		$types    = new RSTHEME_Types( $this->field );
		$type     = $types->get_new_render_type( $this->field->type(), 'RSTHEME_Type_Taxonomy_Radio' );
		$terms    = $type->get_object_terms();
		$term     = false;

		if ( is_wp_error( $terms ) || empty( $terms ) && ( $default = $this->field->get_default() ) ) {
			$term = get_term_by( 'slug', $default, $taxonomy );
		} elseif ( ! empty( $terms ) ) {
			$term = $terms[ key( $terms ) ];
		}

		if ( $term ) {
			$link = get_edit_term_link( $term->term_id, $taxonomy );
			echo '<a href="', esc_url( $link ), '">', esc_html( $term->name ), '</a>';
		}
	}
}

class RSTHEME_Display_Taxonomy_Multicheck extends RSTHEME_Field_Display {
	/**
	 * Display taxonomy values.
	 *
	 * @since 2.2.2
	 */
	protected function _display() {
		$taxonomy = $this->field->args( 'taxonomy' );
		$types    = new RSTHEME_Types( $this->field );
		$type     = $types->get_new_render_type( $this->field->type(), 'RSTHEME_Type_Taxonomy_Multicheck' );
		$terms    = $type->get_object_terms();

		if ( is_wp_error( $terms ) || empty( $terms ) && ( $default = $this->field->get_default() ) ) {
			$terms = array();
			if ( is_array( $default ) ) {
				foreach ( $default as $slug ) {
					$terms[] = get_term_by( 'slug', $slug, $taxonomy );
				}
			} else {
				$terms[] = get_term_by( 'slug', $default, $taxonomy );
			}
		}

		if ( is_array( $terms ) ) {

			$links = array();
			foreach ( $terms as $term ) {
				$link = get_edit_term_link( $term->term_id, $taxonomy );
				$links[] = '<a href="' . esc_url( $link ) . '">' . esc_html( $term->name ) . '</a>';
			}
			// Then loop and output.
			echo '<div class="rstheme-taxonomy-terms-', esc_attr( $taxonomy ), '">';
			// echo implode( ', ', $links );
			implode( ', ', $links );
			echo '</div>';
		}
	}
}

class RSTHEME_Display_File extends RSTHEME_Field_Display {
	/**
	 * Display file value.
	 *
	 * @since 2.2.2
	 */
	protected function _display() {
		if ( empty( $this->value ) ) {
			return;
		}

		$this->value = esc_url_raw( $this->value );

		$types = new RSTHEME_Types( $this->field );
		$type  = $types->get_new_render_type( $this->field->type(), 'RSTHEME_Type_File_Base' );

		$id = $this->field->get_field_clone( array(
			'id' => $this->field->_id() . '_id',
		) )->escaped_value( 'absint' );

		$this->file_output( $this->value, $id, $type );
	}

	protected function file_output( $url_value, $id, RSTHEME_Type_File_Base $field_type ) {
		// If there is no ID saved yet, try to get it from the url
		if ( $url_value && ! $id ) {
			$id = RSTHEME_Utils::image_id_from_url( esc_url_raw( $url_value ) );
		}

		if ( $field_type->is_valid_img_ext( $url_value ) ) {
			$img_size = $this->field->args( 'preview_size' );

			if ( $id ) {
				$image = wp_get_attachment_image( $id, $img_size, null, array(
					'class' => 'rstheme-image-display',
				) );
			} else {
				$size = is_array( $img_size ) ? $img_size[0] : 200;
				$image = '<img class="rstheme-image-display" style="max-width: ' . absint( $size ) . 'px; width: 100%; height: auto;" src="' . $url_value . '" alt="" />';
			}

			echo wp_kses_post( $image );

		} else {

			printf(
			    '<div class="file-status"><span>%1$s <strong><a href="%2$s">%3$s</a></strong></span></div>',
			    esc_html( $field_type->_text( 'file_text', esc_html__( 'File:', 'ultimate-team-showcase' ) ) ),
			    esc_url( $url_value ), // Escaping URL
			    esc_html( RSTHEME_Utils::get_file_name_from_path( $url_value ) ) // Escaping file name
			);
		}
	}
}

class RSTHEME_Display_File_List extends RSTHEME_Display_File {
	/**
	 * Display file_list value.
	 *
	 * @since 2.2.2
	 */
	protected function _display() {
		if ( empty( $this->value ) || ! is_array( $this->value ) ) {
			return;
		}

		$types = new RSTHEME_Types( $this->field );
		$type  = $types->get_new_render_type( $this->field->type(), 'RSTHEME_Type_File_Base' );

		echo '<ul class="rstheme-display-file-list">';
		foreach ( $this->value as $id => $fullurl ) {
		    echo '<li>', esc_html( $this->file_output( esc_url_raw( $fullurl ), esc_attr( $id ), esc_attr( $type ) ) ), '</li>';
		}


		echo '</ul>';
	}
}

class RSTHEME_Display_oEmbed extends RSTHEME_Field_Display {
	/**
	 * Display oembed value.
	 *
	 * @since 2.2.2
	 */
	protected function _display() {
		if ( ! $this->value ) {
			return;
		}

		rstheme_do_oembed( array(
			'url'         => $this->value,
			'object_id'   => $this->field->object_id,
			'object_type' => $this->field->object_type,
			'oembed_args' => array(
				'width' => '300',
			),
			'field_id'    => $this->field->id(),
		) );
	}
}
