<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the RSTHEME directory)
 *
 * Be sure to replace all instances of 'uteam_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category RSThemePlugin
 * @package  WP_Ultimate_Team
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://rstheme.com/portfolio-category/plugins/
 */

/**
 * Include RSTHEME Library
 */

if ( file_exists( dirname( __FILE__ ) . '/rstheme/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/rstheme/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/RSTHEME/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/RSTHEME/init.php';
}

/**
 * Conditionally displays a metabox when used as a callback in the 'show_on_cb' rstheme_box parameter
 */

function rstheme_show_if_front_page( $rstheme ) {
	// Don't show this metabox if it's not the front page template.
	if ( get_option( 'page_on_front' ) !== $rstheme->object_id ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
*/

function rstheme_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category.
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}

/**
 * Manually render a field.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  RSTHEME_Field $field      The field object.
 */
function rstheme_render_row_cb( $field_args, $field ) {
	$classes     = $field->row_classes();
	$id          = $field->args( 'id' );
	$label       = $field->args( 'name' );
	$name        = $field->args( '_name' );
	$value       = $field->escaped_value();
	$description = $field->args( 'description' );
	?>
	<div class="custom-field-row <?php echo esc_attr( $classes ); ?>">
		<p><label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label></p>
		<p><input id="<?php echo esc_attr( $id ); ?>" type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>"/></p>
		<p class="description"><?php echo esc_html( $description ); ?></p>
	</div>
	<?php
}

/**
 * Manually render a field column display.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  RSTHEME_Field $field      The field object.
 */
function rstheme_display_text_small_column( $field_args, $field ) {
	?>
	<div class="custom-column-display <?php echo esc_attr( $field->row_classes() ); ?>">
		<p><?php echo esc_html( $field->escaped_value() ); ?></p>
		<p class="description"><?php echo esc_html( $field->args( 'description' ) ); ?></p>
	</div>
	<?php
}

/**
 * Conditionally displays a message if the $post_id is 2
 *
 * @param  array      $field_args Array of field parameters.
 * @param  RSTHEME_Field $field      Field object.
 */
function rstheme_before_row_if_2( $field_args, $field ) {
	if ( 2 == $field->object_id ) {
		echo '<p>Testing <b>"before_row"</b> parameter (on $post_id 2)</p>';
	} else {
		echo '<p>Testing <b>"before_row"</b> parameter (<b>NOT</b> on $post_id 2)</p>';
	}
}


//metaboxes for team members

add_action( 'rstheme_admin_init', 'uteam_member_options_metabox' );
/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function uteam_member_options_metabox() {

	/**
	 * Registers options page menu item and form.
	 */
	$uteam_options = new_rstheme_box( array(
		'id'           => 'uteam_option_page',
		'title'        => esc_html__( 'Memeber Basic Information', 'ultimate-team-showcase' ),
		'object_types' => array( 'wp_uteam' ),
		/*
		 * The following parameters are specific to the options-page box
		 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
		 */
		'option_key'      => 'rstheme_theme_options', // The option key and admin menu page slug.
		'icon_url'        => 'dashicons-palmtree', // Menu icon. Only applicable if 'parent_slug' is left empty.
		
	) );

	/**
	 * Options fields ids only need
	 * to be unique within this box.
	 * Prefix is not needed.
	 */
	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Designation', 'ultimate-team-showcase' ),
		'id'      => 'uteam_designation',
		'type'    => 'text_medium',
	) );

	

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Phone Number', 'ultimate-team-showcase' ),		
		'id'      => 'uteam_phone',
		'type'    => 'text_medium',	
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Email Address', 'ultimate-team-showcase' ),		
		'id'      => 'uteam_email',
		'type'    => 'text_email',	
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Website', 'ultimate-team-showcase' ),		
		'id'      => 'uteam_website',
		'type'    => 'text_medium',	
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Address (Pro Only)', 'ultimate-team-showcase' ),
		'id'      => 'uteam_address',
		'type'    => 'text',	
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Short Description (Pro Only)', 'ultimate-team-showcase' ),
		'id'      => 'uteam_description',
		'type'    => 'textarea_small',	
	) );
}



add_action( 'rstheme_admin_init', 'uteam_social_register_repeatable_group_field_metabox' );
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function uteam_social_register_repeatable_group_field_metabox() {
	$prefix = 'uteam_group_';

	/**
	 * Repeatable Field Groups
	 */
	$rstheme_group = new_rstheme_box( array(
		'id'           => $prefix . 'metabox-social',
		'title'        => esc_html__( 'Member Social Information', 'ultimate-team-showcase' ),
		'object_types' => array( 'wp_uteam' ),
		'priority'     => 'low',  //  'high', 'core', 'default' or 'low'
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $rstheme_group->add_field( array(
		'id'          => 'member_social',
		'type'        => 'group',
		'description' => esc_html__( 'Team Member Social Information', 'ultimate-team-showcase' ),
		'options'     => array(
			'group_title'   => esc_html__( 'Social Info {#}', 'ultimate-team-showcase' ), // {#} gets replaced by row number
			'add_button'    => esc_html__( 'Add More info', 'ultimate-team-showcase' ),
			'remove_button' => esc_html__( 'Remove Info', 'ultimate-team-showcase' ),
			'sortable'      => true, // beta
			// 'closed'     => true, // true to have the groups closed by default
		),
	) );

	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
	
	$rstheme_group->add_group_field( $group_field_id, array(
		'name'       => esc_html__( 'Select Social Icon', 'ultimate-team-showcase' ),
		'id'         => 'social_class',
		'type'             => 'select',
		'show_option_none' => false,
		'options'          => array(
			'fab fa-facebook-f'  => esc_html__( 'Facebook', 'ultimate-team-showcase' ),
			'fab fa-x-twitter'     => esc_html__( 'Twitter', 'ultimate-team-showcase' ),
		),
	) );

	$rstheme_group->add_group_field( $group_field_id, array(
		'name'       => esc_html__( 'URL', 'ultimate-team-showcase' ),
		'id'         => 'social_url',
		'type'       => 'text',
		'desc' => esc_html__( 'Enter Your Social Media Link', 'ultimate-team-showcase' ),
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );		

}

add_action( 'rstheme_admin_init', 'uteam_member_gallery' );
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function uteam_member_gallery() {
	$prefix = 'uteam_group_';

	/**
	 * Repeatable Field Groups
	 */
	$uteam_options = new_rstheme_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => esc_html__( 'Member Single Gallery', 'ultimate-team-showcase' ),
		'object_types' => array( 'uteam_team' ),
		'priority'     => 'low',  //  'high', 'core', 'default' or 'low'
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$uteam_options->add_field( array(
	'name' => 'Upload Project Images',
	'desc' => '',
	'id'   => 'Screenshot',
	'type' => 'file_list',
	
	'text' => array(
		'add_upload_files_text' => 'Upload Files', // default: "Add or Upload Files"
		'remove_image_text' => 'Replacement', // default: "Remove Image"
		'file_text' => 'Replacement', // default: "File:"
		'file_download_text' => 'Replacement', // default: "Download"
		'remove_text' => 'Replacement', // default: "Remove"
	),
) );

}

/*
------------ metaboxes for shortcode--------------------
-------------------------------------------------
*/
add_action( 'rstheme_admin_init', 'uteam_custom_settings_shortcode' );
function uteam_custom_settings_shortcode() {

	$prefix = 'uteam_metabox_';

	$uteam_options = new_rstheme_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Shortcode Generator', 'ultimate-team-showcase' ),
		'object_types'  => array( 'wp_uteam_settings' ), // Post type
		'vertical_tabs' => true, // Set vertical tabs, default false
        'tabs' => array(
            array(
                'id'    => 'tab-1',
                'icon' => 'dashicons dashicons-groups',
                'title' => 'Member General Information',
                'fields' => array(
                   	'uteam_team_select',
                    'uteam_team_per_page',
                    'uteam_team_order',
                    'uteam_team_category'
                ),
            ),
            array(
                'id'    => 'tab-2',
                'icon' => 'dashicons-grid-view',
                'title' => 'Grid ',
                'fields' => array(
                    'uteam_team_grid_style',
                    'uteam_team_grid_colum',
                    'uteam_team_pagination',                   
                ),
            ),

            array(
                'id'    => 'tab-3',
                'icon' => 'dashicons-slides',
                'title' => 'Slider ',
                'fields' => array(
                    'uteam_team_slider_style',
                    'uteam_cl-lg',
                    'uteam_cl-md',
                    'uteam_cl-xs',
                    'uteam_cl-mobile',
                    'uteam_slider_dots',
                    'uteam_slider_nav' ,
                    'uteam_slider_autoplay',
                    'uteam_slider_stop_on_hover',
                    'uteam_slider_interval',
                    'uteam_slider_autoplay_speed',
                    'uteam_slider_loop'
                ),
            ),


            array(
                'id'    => 'tab-light',
                'icon' => 'dashicons-editor-table',
                'title' => 'LightBox ',
                'fields' => array(
                    'uteam_team_light_style',
                    'uteam_team_light_column',
                            
                ),
            ),

            array(
                'id'    => 'tab-isotope',
                'icon' => 'dashicons-layout',
                'title' => 'Isotope ',
                'fields' => array(
                    'uteam_team_isotope_style',
                    'uteam_filter_text',
                    'uteam_filter-align',
                    'uteam_isotope_grid_colum',
                    
                ),
            ),

            array(
                'id'    => 'tab-list',
                'icon' => 'dashicons-editor-table',
                'title' => 'List ',
                'fields' => array(
                    'uteam_team_list_style',
                    'uteam_team_list_column',         
                ),
            ),
            array(
                'id'    => 'tab-flip',
                'icon' => 'dashicons-editor-table',
                'title' => 'Flip ',
                'fields' => array(
                    'uteam_team_flip_style', 
                    'uteam_team_flip_column',          
                               
                ),
            ),

            array(
                'id'    => 'tab-5',
                'icon' => 'dashicons-businessman',
                'title' => 'Member Style ',
                'fields' => array(
                	
                    'uteam_title_section',
                    'uteam_tcolor',
					'uteam_title_bg_color',
					'uteam_font_size_title',
                    'uteam_designation_section',
					'uteam_dcolor',
					'uteam_designation_bg_color',
					'uteam_font_size_designation',
                    'uteam_social_icon_section',
                    'uteam_icon_color',
					'uteam_icon_bg',
					'uteam_sicon_font_size',
					'uteam_sicon_border_radious',
					
					'uteam_short_description_section',
                    'uteam_short_dec_color',
                    'uteam_short_dec_font_size',
                    'uteam_linkcolor',
                    'uteam_link_bg_color',
                    'uteam_slider_option',
					'uteam_slider_nav_color',
					'uteam_slider_nav_bg_color',
					'uteam_team_section_bg_color',
					'uteam_others',
                    'uteam_sicon_section_bg_color',
                    'uteam_team_contact_info_color',
                    
                ),
            ),

            array(
                'id'    => 'tab-6',
                'icon' => 'dashicons-admin-users',
                'title' => 'Member Style Hover ',
                'fields' => array(
                    'uteam_overlay_color',
                    'uteam_linkhover',
                    'uteam_overly_hover_titlecolor',
                    'uteam_overlay_dcolor',
                    'uteam_overlay_text',
                    'uteam_icon_bghover',
                    'uteam_icon_hovercolor',
                    'uteam_team_contact_info_hover_color',
					'uteam_team_section_border_hover_color',

                ),
            ),
        )
	) );


	//Tab1 fields

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Select Team Type', 'ultimate-team-showcase' ),		
		'id'               => 'uteam_team_select',
		'type'             => 'select',
		'show_option_none' => false,
		'options'          => array(
			'grid'   => esc_html__( 'Grid', 'ultimate-team-showcase' ),
			'slider' => esc_html__( 'Slider', 'ultimate-team-showcase' ),
			'light' => esc_html__( 'Light Box Style (Pro)', 'ultimate-team-showcase' ),
			'isotope'   => esc_html__( 'Filter Style (Pro)', 'ultimate-team-showcase' ),
			'list'   => esc_html__( 'List Style (Pro)', 'ultimate-team-showcase' ),
			'flip'   => esc_html__( 'Flip Style (Pro)', 'ultimate-team-showcase' ),
		),
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Team Per Page (Pro Only)', 'ultimate-team-showcase' ),
		'id'               => 'uteam_team_per_page',
		'type'             => 'text_medium',
		'default'		   => -1	
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Ordering (Pro Only)', 'ultimate-team-showcase' ),
		'id'               => 'uteam_team_order',
		'type'             => 'select',
		'show_option_none' => false,
		'options'          => array(
			'select'   => esc_html__( 'Select Option', 'ultimate-team-showcase' ),
			'ASC'   => esc_html__( 'Ascending Pro', 'ultimate-team-showcase' ),
			'DESC' => esc_html__( 'Descending Pro', 'ultimate-team-showcase' ),
					
		),
	) );

	$uteam_options->add_field( array(
			'name'    => esc_html__( 'Choose Category (Pro Only)', 'ultimate-team-showcase' ),
			'id'               => 'uteam_team_category',
			'type'       => 'multicheck',
			
	) );

	//Tab 2 Grid Settings//

	$uteam_grid_style_array = array(
		'style1'   => '<span></span><img class="uteam_logo" src="' . plugins_url( 'img/grid_style01.png', __FILE__ ) . '" alt="uteam"> <p>' . esc_html__( ' Style 01', 'ultimate-team-showcase' ) . '</p>',
        'style2' => '<span></span><img class="uteam_logo" src="' . plugins_url( 'img/grid_style02.png', __FILE__ ) . '" alt="uteam"> <p>' . esc_html__( ' Style 02', 'ultimate-team-showcase' ) . '</p>',
        'style3' => '<span></span><img class="uteam_logo" src="' . plugins_url( 'img/grid_style03.png', __FILE__ ) . '" alt="uteam"> <p>' . esc_html__( ' Style 03', 'ultimate-team-showcase' ) . '</p>',
        'style4' => '<span></span><img class="uteam_logo" src="' . plugins_url( 'img/grid_style04.png', __FILE__ ) . '" alt="uteam"> <p>' . esc_html__( ' Style 04', 'ultimate-team-showcase' ) . '</p>',
        'style5' => '<span></span><img class="uteam_logo" src="' . plugins_url( 'img/grid_style05.png', __FILE__ ) . '" alt="uteam"> <p>' . esc_html__( ' Style 05', 'ultimate-team-showcase' ) . '</p>',
        'style6' => '<span></span><img class="uteam_logo" src="' . plugins_url( 'img/grid_style06.png', __FILE__ ) . '" alt="uteam"> <p>' . esc_html__( ' Style 06', 'ultimate-team-showcase' ) . '</p>',
        'style7' => '<span></span><img class="uteam_logo" src="' . plugins_url( 'img/grid_style07.png', __FILE__ ) . '" alt="uteam"> <p>' . esc_html__( ' Style 07', 'ultimate-team-showcase' ) . '</p>',
	);

	$uteam_grid_style = apply_filters( 'uteam_team_grid_style_pro', $uteam_grid_style_array );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Select Style', 'ultimate-team-showcase' ),		
		'id'               => 'uteam_team_grid_style',
		'type'             => 'radio',
		'show_option_none' => false,
		'default'          => 'style1',
		'options'          => $uteam_grid_style,
		
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Select Column (Pro Only)', 'ultimate-team-showcase' ),
		'id'               => 'uteam_team_grid_colum',
		'type'             => 'select',
		'default'          => '4',
		'show_option_none' => false,
		'options'          => array(
			'select'   => esc_html__( 'Select Column', 'ultimate-team-showcase' ),
			'6'   => esc_html__( 'Column 2 (Pro)', 'ultimate-team-showcase' ),
			'4'   => esc_html__( 'Column 3', 'ultimate-team-showcase' ),
			'3'   => esc_html__( 'Column 4 (Pro)', 'ultimate-team-showcase' ),
		),
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Show Pagination', 'ultimate-team-showcase' ),		
		'id'               => 'uteam_team_pagination',
		'type'             => 'select',
		'default'          => 'false',
		'show_option_none' => false,
		'options'          => array(
			'false'   => esc_html__( 'Hide', 'ultimate-team-showcase' ),
			'true'   => esc_html__( 'true', 'ultimate-team-showcase' ),
									
		),
	) );

	//tab 3 SLider data settigns 

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Select Style', 'ultimate-team-showcase' ),		
		'id'               => 'uteam_team_slider_style',
		'type'             => 'radio',
		'default'          => 'style1',
		'show_option_none' => false,
		'options'          => array(
			'style1'   => '<span></span><img class="uteam_logo" src="' . plugins_url( 'img/grid_style01.png', __FILE__ ) . '" alt="uteam"> <p>' . esc_html__( ' Style 01', 'ultimate-team-showcase' ) . '</p>',
	        'style2' => '<span></span><img class="uteam_logo" src="' . plugins_url( 'img/grid_style02.png', __FILE__ ) . '" alt="uteam"> <p>' . esc_html__( ' Style 02', 'ultimate-team-showcase' ) . '</p>',
	        'style3' => '<span></span><img class="uteam_logo" src="' . plugins_url( 'img/grid_style03.png', __FILE__ ) . '" alt="uteam"> <p>' . esc_html__( ' Style 03', 'ultimate-team-showcase' ) . '</p>',
	        'style4' => '<span></span><img class="uteam_logo" src="' . plugins_url( 'img/grid_style04.png', __FILE__ ) . '" alt="uteam"> <p>' . esc_html__( ' Style 04', 'ultimate-team-showcase' ) . '</p>',
	        'style5' => '<span></span><img class="uteam_logo" src="' . plugins_url( 'img/grid_style05.png', __FILE__ ) . '" alt="uteam"> <p>' . esc_html__( ' Style 05', 'ultimate-team-showcase' ) . '</p>',
	        'style6' => '<span></span><img class="uteam_logo" src="' . plugins_url( 'img/grid_style06.png', __FILE__ ) . '" alt="uteam"> <p>' . esc_html__( ' Style 06', 'ultimate-team-showcase' ) . '</p>',
	        'style7' => '<span></span><img class="uteam_logo" src="' . plugins_url( 'img/grid_style07.png', __FILE__ ) . '" alt="uteam"> <p>' . esc_html__( ' Style 07', 'ultimate-team-showcase' ) . '</p>',
		),
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Number of columns Desktops > 1199px ', 'ultimate-team-showcase' ),
		'id'               => 'uteam_cl-lg',
		'type'             => 'select',
		'default'          => '3',
		'show_option_none' => false,
		'options'          => array(
			'1'   => esc_html__( 'Column 1', 'ultimate-team-showcase' ),
			'2'   => esc_html__( 'Column 2', 'ultimate-team-showcase' ),
			'3'   => esc_html__( 'Column 3', 'ultimate-team-showcase' ),
			'4'   => esc_html__( 'Column 4', 'ultimate-team-showcase' ),
			'5'   => esc_html__( 'Column 5', 'ultimate-team-showcase' ),
			'6'   => esc_html__( 'Column 6', 'ultimate-team-showcase' ),							
		),
	) );	

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Number of columns Desktops > 991px (Pro Only) ', 'ultimate-team-showcase' ),
		'id'               => 'uteam_cl-md',
		'type'             => 'select',
		'default'          => '3',
		'show_option_none' => false,
		'options'          => array(
			'1'   => esc_html__( 'Column 1', 'ultimate-team-showcase' ),
			'2'   => esc_html__( 'Column 2', 'ultimate-team-showcase' ),
			'3'   => esc_html__( 'Column 3', 'ultimate-team-showcase' ),
			'4'   => esc_html__( 'Column 4', 'ultimate-team-showcase' ),
			'5'   => esc_html__( 'Column 5', 'ultimate-team-showcase' ),
			'6'   => esc_html__( 'Column 6', 'ultimate-team-showcase' ),							
		),
	) );	

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Number of columns Tablets > 767px (Pro Only)', 'ultimate-team-showcase' ),
		'id'               => 'uteam_cl-sm',
		'type'             => 'select',
		'default'          => '2',
		'show_option_none' => false,
		'options'          => array(
			'1'   => esc_html__( 'Column 1', 'ultimate-team-showcase' ),
			'2'   => esc_html__( 'Column 2', 'ultimate-team-showcase' ),
			'3'   => esc_html__( 'Column 3', 'ultimate-team-showcase' ),
			'4'   => esc_html__( 'Column 4', 'ultimate-team-showcase' ),
			'5'   => esc_html__( 'Column 5', 'ultimate-team-showcase' ),
			'6'   => esc_html__( 'Column 6', 'ultimate-team-showcase' ),							
		),
	) );	

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Number of columns Tablets < 768px (Pro Only)', 'ultimate-team-showcase' ),
		'id'               => 'uteam_cl-xs',
		'type'             => 'select',
		'default'          => '2',
		'show_option_none' => false,
		'options'          => array(
			'1'   => esc_html__( 'Column 1', 'ultimate-team-showcase' ),
			'2'   => esc_html__( 'Column 2', 'ultimate-team-showcase' ),
			'3'   => esc_html__( 'Column 3', 'ultimate-team-showcase' ),
			'4'   => esc_html__( 'Column 4', 'ultimate-team-showcase' ),
			'5'   => esc_html__( 'Column 5', 'ultimate-team-showcase' ),
			'6'   => esc_html__( 'Column 6', 'ultimate-team-showcase' ),							
		),
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Number of columns Tablets < 480px ', 'ultimate-team-showcase' ),
		'id'               => 'uteam_cl-mobile',
		'type'             => 'select',
		'default'          => '1',
		'show_option_none' => false,
		'options'          => array(
			'1'   => esc_html__( 'Column 1', 'ultimate-team-showcase' ),
			'2'   => esc_html__( 'Column 2', 'ultimate-team-showcase' ),
			'3'   => esc_html__( 'Column 3', 'ultimate-team-showcase' ),
			'4'   => esc_html__( 'Column 4', 'ultimate-team-showcase' ),
			'5'   => esc_html__( 'Column 5', 'ultimate-team-showcase' ),
			'6'   => esc_html__( 'Column 6', 'ultimate-team-showcase' ),							
		),
	) );	

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Navigation Dots (Pro Only) ', 'ultimate-team-showcase' ),
		'id'               => 'uteam_slider_dots',
		'type'             => 'select',
		'classes_cb'             => 'rs_pro_only',
		'default'          => 'true',
		'show_option_none' => false,
		'options'          => array(
			'false'   => esc_html__( 'Disable', 'ultimate-team-showcase' ),
			'true'   => esc_html__( 'Enable', 'ultimate-team-showcase' ),
		),
	) );	

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Navigation Arrow (Pro Only)', 'ultimate-team-showcase' ),
		'id'               => 'uteam_slider_nav',
		'type'             => 'select',
		'default'          => 'false',
		'show_option_none' => false,
		'options'          => array(
			'false'   => esc_html__( 'Disable', 'ultimate-team-showcase' ),
			'true'   => esc_html__( 'Enable', 'ultimate-team-showcase' ),										
		),
	) );	

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Autoplay (Pro Only)', 'ultimate-team-showcase' ),
		'id'               => 'uteam_slider_autoplay',
		'type'             => 'select',
		'default'          => 'true',
		'show_option_none' => false,
		'options'          => array(
			'false'   => esc_html__( 'Disable', 'ultimate-team-showcase' ),
			'true'   => esc_html__( 'Enable', 'ultimate-team-showcase' ),										
		),
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Stop on Hover (Pro Only)', 'ultimate-team-showcase' ),
		'id'               => 'uteam_slider_stop_on_hover',
		'type'             => 'select',
		'default'          => 'true',
		'show_option_none' => false,
		'options'          => array(
			'false'   => esc_html__( 'Disable', 'ultimate-team-showcase' ),
			'true'   => esc_html__( 'Enable', 'ultimate-team-showcase' ),										
		),
	) );		
	
	$uteam_options->add_field( array(
		'name'              => esc_html__( 'Autoplay Interval (Pro Only)', 'ultimate-team-showcase' ),
		'id'               => 'uteam_slider_interval',
		'type'             => 'select',
		'default'          => '5000',
		'show_option_none' => false,
		'options'          => array(
			'5000'   => esc_html__( '5 Seconds', 'ultimate-team-showcase' ),
			'4000'   => esc_html__( '4 Seconds', 'ultimate-team-showcase' ),
			'3000'   => esc_html__( '3 Seconds', 'ultimate-team-showcase' ),
			'2000'   => esc_html__( '2 Seconds', 'ultimate-team-showcase' ),
			'1000'   => esc_html__( '1 Seconds', 'ultimate-team-showcase' ),										
		),
	) );	

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Autoplay Slide Speed (Pro Only)', 'ultimate-team-showcase' ),
		'id'               => 'uteam_slider_autoplay_speed',
		'type'             => 'text_medium',
		'default'          => 200,												
		
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Loop (Pro Only)', 'ultimate-team-showcase' ),
		'id'               => 'uteam_slider_loop',
		'type'             => 'select',
		'default'          => 'true',
		'show_option_none' => false,
		'options'          => array(
			'false'   => esc_html__( 'Disable', 'ultimate-team-showcase' ),
			'true'   => esc_html__( 'Enable', 'ultimate-team-showcase' ),											
		),
	) );	

	//Tab Isotope metaboxes item

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Select Style', 'ultimate-team-showcase' ),		
		'id'               => 'uteam_team_isotope_style',
		'type'             => 'select',
		'show_option_none' => false,
		'options'          => array(
			'style1'   => esc_html__( 'Style 1', 'ultimate-team-showcase' ),
			
		),
	) );
	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Select Column (Pro Only)', 'ultimate-team-showcase' ),
		'id'               => 'uteam_isotope_grid_colum',
		'type'             => 'select',
		'default'          => '4',
		'show_option_none' => false,
		'options'          => array(
			'6'   => esc_html__( 'Column 2', 'ultimate-team-showcase' ),
			'4'   => esc_html__( 'Column 3', 'ultimate-team-showcase' ),
			'3'   => esc_html__( 'Column 4', 'ultimate-team-showcase' ),						
		),
	) );
	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Filter Text (Pro Only)', 'ultimate-team-showcase' ),
		'id'               => 'uteam_filter_text',
		'type'             => 'text_medium',
		'default'		   => 'All'	
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Filter Align (Pro Only)', 'ultimate-team-showcase' ),
		'id'               => 'uteam_filter-align',
		'default'          => 'left',
		'type'             => 'select',
		'show_option_none' => false,
		'options'          => array(
			'left'   => esc_html__( 'Left', 'ultimate-team-showcase' ),
			'center'   => esc_html__( 'Center', 'ultimate-team-showcase' ),
			'right'   => esc_html__( 'Right', 'ultimate-team-showcase' ),
				
		),
	) );

	//Tab Light Box

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Select Style', 'ultimate-team-showcase' ),		
		'id'               => 'uteam_team_light_style',
		'type'             => 'select',
		'show_option_none' => false,
		'options'          => array(
			'style1'   => esc_html__( 'Style 1', 'ultimate-team-showcase' ),
			'style2'   => esc_html__( 'Style 2', 'ultimate-team-showcase' ),
			'style3'   => esc_html__( 'Style 3', 'ultimate-team-showcase' ),
			'style4'   => esc_html__( 'Style 4', 'ultimate-team-showcase' ),
			
		),
	) );

	$uteam_options->add_field( array(
        'name'    => esc_html__( 'Select Column', 'ultimate-team-showcase' ),
        'id'               => 'uteam_team_light_column',
        'type'             => 'select',
        'default'          => '4',
        'show_option_none' => false,
        'options'          => array(
            'select'   => esc_html__( 'Select Column', 'ultimate-team-showcase' ),
            '6'   => esc_html__( 'Column 2', 'ultimate-team-showcase' ),
            '4'   => esc_html__( 'Column 3', 'ultimate-team-showcase' ),
            '3'   => esc_html__( 'Column 4', 'ultimate-team-showcase' ),
        ),
    ) ); 
	//Tab list Style

    $uteam_options->add_field( array(
        'name'    => esc_html__( 'Select Style', 'uteam-pro' ),     
        'id'               => 'uteam_team_list_style',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => 'style1',
        'options'          => array(
            'style1'   => esc_html__( 'Style 1', 'ultimate-team-showcase' ),
            ),
    ) );
	
    // Flip Style

    $uteam_options->add_field( array(
        'name'             => esc_html__( 'Select Style', 'uteam-pro' ),
        'id'               => 'uteam_team_flip_style',
        'type'             => 'select',
        'default'          => 'style1',
        'show_option_none' => false,
        'options'          => array(
            'style1'   => esc_html__( 'Style 1', 'ultimate-team-showcase' ),
                
            ),
    ) );

    $uteam_options->add_field( array(
        'name'    => esc_html__( 'Select Column', 'uteam-pro' ),
        'id'               => 'uteam_team_flip_column',
        'type'             => 'select',
        'default'          => '4',
        'show_option_none' => false,
        'options'          => array(
            'select'   => esc_html__( 'Select Column', 'uteam-pro' ),
            '6'   => esc_html__( 'Column 2', 'uteam-pro' ),
            '4'   => esc_html__( 'Column 3', 'uteam-pro' ),
            '3'   => esc_html__( 'Column 4', 'uteam-pro' ),
        ),
    ) );

	//Tab 5 metaboxes item

	//Team Title Section
	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Team Title Section', 'ultimate-team-showcase' ),		
		'id'      => 'uteam_title_section',
		'type'    => '',	
		'default' => '',
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Color', 'ultimate-team-showcase' ),		
		'id'      => 'uteam_tcolor',
		'type'    => 'colorpicker',	
		'default' => '',
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Background Color (Pro Only)', 'ultimate-team-showcase' ),
		'id'      => 'uteam_title_bg_color',
		'type'    => 'colorpicker',	
		'default' => '',
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Font Size (Pro Only)', 'ultimate-team-showcase' ),
		'id'      => 'uteam_font_size_title',
		'type'    => 'text',	
		'default' => '',
	) );

	//Team Designation Section
	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Team Designation Section', 'ultimate-team-showcase' ),		
		'id'      => 'uteam_designation_section',
		'type'    => '',	
		'default' => '',
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Color', 'ultimate-team-showcase' ),		
		'id'      => 'uteam_dcolor',
		'type'    => 'colorpicker',	
		'default' => '',
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Background Color (Pro Only)', 'ultimate-team-showcase' ),
		'id'      => 'uteam_designation_bg_color',
		'type'    => 'colorpicker',	
		'default' => '',
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Font Size (Pro Only)', 'ultimate-team-showcase' ),
		'id'      => 'uteam_font_size_designation',
		'type'    => 'text',	
		'default' => '',
	) );

	//Short Description Section
	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Short Description Section', 'ultimate-team-showcase' ),		
		'id'      => 'uteam_short_description_section',
		'type'    => '',	
		'default' => '',
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Color', 'ultimate-team-showcase' ),		
		'id'      => 'uteam_short_dec_color',
		'type'    => 'colorpicker',	
		'default' => '',
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Font Size (Pro Only)', 'ultimate-team-showcase' ),
		'id'      => 'uteam_short_dec_font_size',
		'type'    => 'text',	
		'default' => '',
	) );

	//Social Icon Section
	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Social Icon Section', 'ultimate-team-showcase' ),		
		'id'      => 'uteam_social_icon_section',
		'type'    => '',	
		'default' => '',
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Social Icon Color (Pro Only)', 'ultimate-team-showcase' ),
		'id'      => 'uteam_icon_color',
		'type'    => 'colorpicker',	
		'default' => '',
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Social Icon Bg Color (Pro Only)', 'ultimate-team-showcase' ),
		'id'      => 'uteam_icon_bg',
		'type'    => 'colorpicker',	
		'default' => '',
		'options' => array( 'alpha' => true ),
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Font Size (Pro Only)', 'ultimate-team-showcase' ),
		'id'      => 'uteam_sicon_font_size',
		'type'    => 'text',	
		'default' => '',
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Border Radius (Pro Only)', 'ultimate-team-showcase' ),
		'id'      => 'uteam_sicon_border_radious',
		'type'    => 'text',	
		'default' => '',
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Link Color (Pro Only)', 'ultimate-team-showcase' ),
		'id'      => 'uteam_linkcolor',
		'type'    => 'colorpicker',	
		'default' => '',
	) );
	
	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Link BG Color (Pro Only)', 'ultimate-team-showcase' ),
		'id'      => 'uteam_link_bg_color',
		'type'    => 'colorpicker',	
		'default' => '',
	) );

	//SLider style option
	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Slider Option', 'ultimate-team-showcase' ),		
		'id'      => 'uteam_slider_option',
		'type'    => '',	
		'default' => '',
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Icon Color (Pro Only)', 'ultimate-team-showcase' ),
		'id'      => 'uteam_slider_nav_color',
		'type'    => 'colorpicker',	
		'default' => '',
	) );
	
	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Icon BG Color (Pro Only)', 'ultimate-team-showcase' ),
		'id'      => 'uteam_slider_nav_bg_color',
		'type'    => 'colorpicker',	
		'default' => '',
	) );

	//Tab 6 metaboxes item

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Image Overlay Color', 'ultimate-team-showcase' ),		
		'id'      => 'uteam_overlay_color',
		'type'    => 'colorpicker',	
		'default' => '',
		'options' => array( 'alpha' => true ),	
	) );
	
	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Link Hover Color (Pro Only)', 'ultimate-team-showcase' ),
		'id'      => 'uteam_linkhover',
		'type'    => 'colorpicker',	
		'default' => '',
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Title Color', 'ultimate-team-showcase' ),
		'id'      => 'uteam_overly_hover_titlecolor',
		'type'    => 'colorpicker',	
		'default' => '',
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Designation Color', 'ultimate-team-showcase' ),		
		'id'      => 'uteam_overlay_dcolor',
		'type'    => 'colorpicker',	
		'default' => '',
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Description Color', 'ultimate-team-showcase' ),		
		'id'      => 'uteam_overlay_text',
		'type'    => 'colorpicker',	
		'default' => '',
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Social Icon Color (Pro Only)', 'ultimate-team-showcase' ),
		'id'      => 'uteam_icon_hovercolor',
		'type'    => 'colorpicker',	
		'default' => '',
	) );

	$uteam_options->add_field( array(
		'name'    => esc_html__( 'Social Icon Bg Color (Pro Only)', 'ultimate-team-showcase' ),
		'id'      => 'uteam_icon_bghover',
		'type'    => 'colorpicker',	
		'default' => '',
		'options' => array( 'alpha' => true ),
	) );
}

add_action( 'rstheme_admin_init', 'uteam_another_generated_shortcode' );

/**
 * Hook in and register a metabox for another set of options.
 */
function uteam_another_generated_shortcode() {

	/**
	 * Registers options page menu item and form.
	 */
	$uteam_options = new_rstheme_box( array(
		'id'           => 'uteam_generated_shortcode',
		'title'        => esc_html__( 'Generated Shortcode', 'ultimate-team-showcase' ),
		'object_types' => array( 'wp_uteam_settings' ),
		'option_key'   => 'rstheme_generated_shortcode_options', // The option key and admin menu page slug.
		'priority'     => 'low',
	) );

	$shortcode_post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0;

	$uteam_options->add_field( array(
	    'name'    => esc_html__( 'Shortcode', 'ultimate-team-showcase' ),
	    'id'      => 'uteam_shortcode_1',
	    'type'    => 'text',
	    'default' => '<?      [wp_ultimate_team_shortcode id="' . esc_attr( $shortcode_post_id ) . '"]        ?>',

	) );

	$uteam_options->add_field( array(
	    'name'    => esc_html__( 'Template Include', 'ultimate-team-showcase' ),
	    'id'      => 'uteam_shortcode_2',
	    'type'    => 'textarea_small',
	    'default' => '<?php echo do_shortcode("[wp_ultimate_team_shortcode id="' . esc_attr( $shortcode_post_id ) . '"]"); ?>', // Set the default value as the current post ID
	) );

}

/**
 * @param $rstheme
 * @param $args
 * @return void
 */
function uteam_options_page_message_callback( $rstheme, $args ) {
	if ( ! empty( $args['should_notify'] ) ) {

		if ( $args['is_updated'] ) {

			// Modify the updated message.
			// translators: Modify the updated message.
			$args['message'] = sprintf( esc_html__( '%s &mdash; Updated!', 'ultimate-team-showcase' ), $rstheme->prop( 'title' ) );
		}

		add_settings_error( $args['setting'], $args['code'], $args['message'], $args['type'] );
	}
}

/**
 * @param $is_allowed
 * @param $rstheme_controller
 * @return false|mixed
 */
function uteam_limit_rest_view_to_logged_in_users( $is_allowed, $rstheme_controller ) {
	if ( ! is_user_logged_in() ) {
		$is_allowed = false;
	}

	return $is_allowed;
}

?>
