<?php

/**
 * Register custom post type
 */

function uteam_team_register_post_type() {
    $settings_options = get_option( 'uteam_settings_option' );
    $print_uteam_url_rewrite = isset($settings_options['uteam_url_rewrite']) ? $settings_options['uteam_url_rewrite'] : 'wp_uteam' ;

    $labels = array(
        'name'               => esc_html__( 'Team', 'ultimate-team-showcase' ),
        'singular_name'      => esc_html__( 'Team', 'ultimate-team-showcase' ),
        'add_new'            => esc_html__( 'Add New Team', 'ultimate-team-showcase'),
        'add_new_item'       => esc_html__( 'Add New Team', 'ultimate-team-showcase' ),
        'edit_item'          => esc_html__( 'Edit Team', 'ultimate-team-showcase' ),
        'new_item'           => esc_html__( 'New Team', 'ultimate-team-showcase' ),
        'all_items'          => esc_html__( 'All Teams', 'ultimate-team-showcase' ),
        'view_item'          => esc_html__( 'View Team', 'ultimate-team-showcase' ),
        'search_items'       => esc_html__( 'Search Teams', 'ultimate-team-showcase' ),
        'not_found'          => esc_html__( 'No Teams found', 'ultimate-team-showcase' ),
        'not_found_in_trash' => esc_html__( 'No Teams found in Trash', 'ultimate-team-showcase' ),
        'parent_item_colon'  => esc_html__( 'Parent Team:', 'ultimate-team-showcase' ),
        'menu_name'          => esc_html__( 'WP Ultimate Team', 'ultimate-team-showcase' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_in_menu'       => true,
        'show_in_admin_bar'  => true,
        'can_export'         => true,
        'has_archive'        => true,
        'capability_type'   =>  'page',
        'menu_position'      => 20,
        'menu_icon'          =>  plugins_url( '../admin/assets/images/icon-admin.png', __FILE__ ),
        'supports'           => array( 'title', 'thumbnail','editor', 'page-attributes' ),
        'rewrite' => array(
            'slug' => $print_uteam_url_rewrite,
            'with_front' => false,
            'hierarchical' => true
        ),
    );
    
    register_post_type( 'wp_uteam', $args );
}
add_action( 'init', 'uteam_team_register_post_type' );


// Add the custom columns to the Ultimate Team post type:
add_filter( 'manage_wp_uteam_posts_columns', 'uteam_set_custom_wp_ultimate_team_edit_fields_columns' );
function uteam_set_custom_wp_ultimate_team_edit_fields_columns($columns) {
    unset( $columns['date'] );
   //unset( $columns['category'] );
    $columns['title'] = __('Member Name', 'ultimate-team-showcase');
    $columns['uteam_photo'] = __('Photo', 'ultimate-team-showcase');
    $columns['uteam_designation'] = __( 'Designation', 'ultimate-team-showcase' );
    return $columns;
}

// Add the data to the custom columns for the hygiena_documents post type:
add_action( 'manage_wp_uteam_posts_custom_column' , 'uteam_custom_wp_ultimate_team_column', 10, 2 );
function uteam_custom_wp_ultimate_team_column( $column, $post_id ) {
    switch ( $column ) {

        case 'uteam_photo' :
            echo get_the_post_thumbnail( $post_id, 'thumbnail');
            break;

        case 'uteam_designation' :
            echo esc_html(get_post_meta( $post_id , 'uteam_designation', true));
            break;
    }
}

/**
 * Change custom category label
 *
 * @return void
 */
function uteam_create_category() {
    $settings_options = get_option( 'uteam_settings_option' );
    $cat_lebel = isset($settings_options['uteam_cat_title_rewrite']) ? $settings_options['uteam_cat_title_rewrite'] : 'Team Categories' ;
    register_taxonomy(
        'wp-uteam-category',
        'wp_uteam',
        array(
            'label' => $cat_lebel,
            'rewrite' => array( 'slug' => 'wp-uteam-category'),
            'hierarchical' => true,
            'show_admin_column' => true,
        )
    );
}
add_action( 'init', 'uteam_create_category' );

/**
 * Rewrite category slug
 *
 * @param [type] $taxonomy
 * @param [type] $object_type
 * @param [type] $args
 * @return void
 */
function uteam_rewrite_cat_slug( $taxonomy, $object_type, $args ){
    $settings_options = get_option( 'uteam_settings_option' );
    if( 'wp-uteam-category' == $taxonomy ){
        remove_action( current_action(), __FUNCTION__ );
        $args['rewrite'] = array( 'slug' => isset($settings_options['uteam_taxonomy_rewrite']) ? $settings_options['uteam_taxonomy_rewrite'] : 'wp-uteam-category' );
        register_taxonomy( $taxonomy, $object_type, $args );
    }
}
add_action( 'registered_taxonomy', 'uteam_rewrite_cat_slug', 10, 3 );

/**
 * Generate shortcode for custom post type
 */
function uteam_custom_post_create_team_type() {
    //Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Shortcodes', 'Post Type General Name', 'ultimate-team-showcase' ),
        'singular_name'       => _x( 'Shortcode', 'Post Type Singular Name', 'ultimate-team-showcase' ),
        'menu_name'           => __( 'Shortcodes', 'ultimate-team-showcase' ),
        'parent_item_colon'   => __( 'Parent Shortcode', 'ultimate-team-showcase' ),
        'all_items'           => __( 'All Shortcodes', 'ultimate-team-showcase' ),
        'view_item'           => __( 'View Shortcode', 'ultimate-team-showcase' ),
        'add_new_item'        => __( 'Create New Shortcode', 'ultimate-team-showcase' ),
        'add_new'             => __( 'Add New Shortcode', 'ultimate-team-showcase' ),
        'edit_item'           => __( 'Edit Shortcode', 'ultimate-team-showcase' ),
        'update_item'         => __( 'Update Shortcode', 'ultimate-team-showcase' ),
        'search_items'        => __( 'Search Shortcode', 'ultimate-team-showcase' ),
        'not_found'           => __( 'Not Found', 'ultimate-team-showcase' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'ultimate-team-showcase' ),
    );

    // Set other options for Custom Post Type
    $args = array(
        'label'               => __( 'Shortcodes', 'ultimate-team-showcase' ),
        'description'         => __( 'Shortcode news and reviews', 'ultimate-team-showcase' ),
        'labels'              => $labels,
        'supports'            => array( 'title'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu' 		  => 'edit.php?post_type=wp_uteam',
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => false,
        'publicly_queryable'  => false,
        'capability_type'     => 'page',
    );

    // Registering your Custom Post Type
    register_post_type( 'wp_uteam_settings', $args );
}
add_action( 'init', 'uteam_custom_post_create_team_type');

/**
 * add submenu
 */
function uteam_add_team_menu(){
    add_submenu_page('edit.php?post_type=wp_uteam', __('Create Shortcode','ultimate-team-showcase'), __('Create Shortcode','ultimate-team-showcase'), 'manage_options', 'post-new.php?post_type=wp_uteam_settings');
}
add_action('admin_menu','uteam_add_team_menu');

/**
 * Settings text for title and save etc
 */
function uteam_settings_admin_enter_title( $input ) {
    global $post_type;
    if ( 'wp_uteam_settings' == $post_type )
        return __( 'Enter Shortcode Name', 'ultimate-team-showcase' );
    return $input;
}
add_filter( 'enter_title_here', 'uteam_settings_admin_enter_title' );

/**
 *
 */
function uteam_settings_admin_updated_messages( $messages ) {
    
    global $post, $post_id;
    
    // Add nonce to the form
    $messages['wp_uteam_settings'] = array(
        1 => __('Shortcode updated.', 'ultimate-team-showcase'),
        2 => $messages['post'][2],
        3 => $messages['post'][3],
        // translators: Shortcode updated
        4 => __('Shortcode updated.', 'ultimate-team-showcase'),
        // translators: Shortcode restored to revision
        5 => isset($_GET['revision']) ? sprintf( __('Shortcode restored to revision from %s', 'ultimate-team-showcase'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
        6 => __('Shortcode published.', 'ultimate-team-showcase'),
        7 => __('Shortcode saved.', 'ultimate-team-showcase'),
        8 => __('Shortcode submitted.', 'ultimate-team-showcase'),
         // translators: Shortcode scheduled
        9 => sprintf( __('Shortcode scheduled for: <strong>%1$s</strong>.', 'ultimate-team-showcase'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) )),
        10 => __('Shortcode draft updated.', 'ultimate-team-showcase'),
    );

    return $messages;
}

add_filter( 'post_updated_messages', 'uteam_settings_admin_updated_messages' );


/**
 * Extra column make for shotcode custom post
 */
function uteam_settings_add_shortcode_column( $columns ) {
    return array_merge( $columns,
        array( 'shortcode' => __( 'Shortcode', 'ultimate-team-showcase' ) )
    );
}
add_filter( 'manage_wp_uteam_settings_posts_columns' , 'uteam_settings_add_shortcode_column' );


/**
 * Dynamic Shortcode generator
 */
function uteam_settings_add_posts_shortcode_display( $column, $post_id ) {
    if ($column == 'shortcode'){
        ?>
    <input style="background:#ccc; width:280px" type="text" onClick="this.select();" value="[wp_ultimate_team_shortcode <?php echo 'id=&quot;'.esc_attr( $post_id ).'&quot;';?>]" />
    <br />
    <textarea cols="50" rows="3" style="background:#ddd" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[wp_ultimate_team_shortcode id='; echo "'".esc_attr( $post_id )."']"; echo '"); ?>'; ?></textarea>
    <?php
    }
}
add_action( 'manage_wp_uteam_settings_posts_custom_column' , 'uteam_settings_add_posts_shortcode_display', 10, 2 );
