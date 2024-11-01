<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly


 /*=====================================================================
	// WP Ultimate Team ShortCode
  =======================================================================*/

function uteam_team_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'id' => "", 
		), $atts);
		global $post;
		$post_id = $atts['id'];		
		if($post_id!='xx'){	

 /*===========================================================
       //retrive settings value form settings page
   ============================================================*/
		
		$team_type                     = get_post_meta($post_id, 'uteam_team_select', true);
		$team_grid_style               = get_post_meta($post_id, 'uteam_team_grid_style', true);
		$team_light_style              = get_post_meta($post_id, 'uteam_team_light_style', true);
		$team_slider_style             = get_post_meta($post_id, 'uteam_team_slider_style', true);
		$primary_color                 = get_post_meta($post_id, 'uteam_pcolor', true);
		$secondary_color               = get_post_meta($post_id, 'uteam_scolor', true);	
		$style_titlecolor              = get_post_meta($post_id, 'uteam_tcolor', true);
		$style_desicolor               = get_post_meta($post_id, 'uteam_dcolor', true);
		$overlay_color                 = get_post_meta($post_id, 'uteam_overlay_color', true);
		$uteam_overlytitlecolor        = get_post_meta($post_id, 'uteam_overlytitlecolor', true);
		$uteam_overly_hover_titlecolor = get_post_meta($post_id, 'uteam_overly_hover_titlecolor', true);
		$uteam_overlay_desicolor       = get_post_meta($post_id, 'uteam_overlay_dcolor', true);
		$uteam_overlay_text            = get_post_meta($post_id, 'uteam_overlay_text', true);
		$uteam_font_size_designation   = get_post_meta($post_id, 'uteam_font_size_designation', true);
        $team_grid_colum               = get_post_meta($post_id, 'uteam_team_grid_colum', true);
        $team_category                 = get_post_meta($post_id, 'uteam_team_category', true);
        $uteam_short_dec_color    	   = get_post_meta($post_id, 'uteam_short_dec_color', true);
        $uteam_short_dec_font_size     = get_post_meta($post_id, 'uteam_short_dec_font_size', true);
        $posts_per_page                = get_post_meta($post_id, 'uteam_team_per_page', true);
        $order_type                    = get_post_meta($post_id, 'uteam_team_order', true);

		//setting for slider
		$cl_lg                 = get_post_meta($post_id, 'uteam_cl-lg', true);
		$cl_md                 = get_post_meta($post_id, 'uteam_cl-md', true);
		$cl_sm                 = get_post_meta($post_id, 'uteam_cl-sm', true);
		$cl_xs                 = get_post_meta($post_id, 'uteam_cl-xs', true);
		$cl_mobile             = get_post_meta($post_id, 'uteam_cl-mobile', true);
		$slider_dots           = get_post_meta($post_id, 'uteam_slider_dots', true);
		$slider_nav            = get_post_meta($post_id, 'uteam_slider_nav', true);
		$slider_autoplay       = get_post_meta($post_id, 'uteam_slider_autoplay', true);
		$slider_stop_on_hover  = get_post_meta($post_id, 'uteam_slider_stop_on_hover', true);
		$slider_interval       = get_post_meta($post_id, 'uteam_slider_interval', true);
		$slider_loop           = get_post_meta($post_id, 'uteam_slider_loop', true);
		$slider_autoplay_speed = get_post_meta($post_id, 'uteam_slider_autoplay_speed', true);
		$pagination 		   = get_post_meta($post_id, 'uteam_team_pagination', true);
	

		$slider_dots_nav  = ($slider_dots == 'true') ? 'uteam_slider_dot_show' : '';		
		$slider_nav_arrow = ($slider_nav == 'true') ? 'uteam_slider_nav_show' : '';

		//filter settings


		//data for slider
		$owl_data = array( 
			'nav'                => ( $slider_nav === 'true' ) ? true : false,
			'navText'            => array( "<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>" ),				
			'dots'               => ( $slider_dots === 'true' ) ? true : false,
			'autoplay'           => ( $slider_autoplay === 'true' ) ? true : false,
			'autoplayTimeout'    => $slider_interval,
			'autoplaySpeed'      => $slider_autoplay_speed,
			'autoplayHoverPause' => ( $slider_stop_on_hover === 'true' ) ? true : false,
			'loop'               => ( $slider_loop === 'true' ) ? true : false,
			'margin'             => 20,				
			'responsive'         => array(
				'0'    => array( 'items' => $cl_mobile ),
				'480'  => array( 'items' => $cl_xs ),
				'768'  => array( 'items' => $cl_sm ),
				'992'  => array( 'items' => $cl_md ),
				'1200' => array( 'items' => $cl_lg ),
			)				
		);

		$owl_data = wp_json_encode( $owl_data );


		//retrive category form settings
		if( !empty( $team_category ) ){
			for ($i=0; $i < count(array($team_category)); $i++) {        	
				$arr_cats[]= $team_category[$i];
			 }
		}

		$dir = plugin_dir_path( __FILE__ );

		//retrive data form member post type
		if(empty($team_category)){
			global  $paged;
			$paged = get_query_var("paged") ? get_query_var("paged"): 1; 
			$args = array(
				'post_type'      => 'wp_uteam',
				'orderby'        => 'menu_order',
				'order'          => $order_type,
				'posts_per_page' => $posts_per_page,
				'paged'			 => $paged,
			);
		}else{
			global  $paged;
			$paged = get_query_var("paged") ? get_query_var("paged"): 1; 
			$args = array(
				'post_type'      => 'wp_uteam',
				'orderby'        => 'menu_order',
				'order'          => $order_type,
				'posts_per_page' => $posts_per_page,
				'paged'			 => $paged,
				'tax_query' => array(
				    array(
			            'taxonomy' => 'wp-uteam-category',
			            'field' => 'ID', //can be set to ID
			            'terms' => $arr_cats//if field is ID you can reference by cat/term number
				    ),
				)
			);
		}
			
		$que = new WP_Query( $args );

	 /*=====================================================================
		//Grid type check 
	  =======================================================================*/
	
		if($team_type == "grid"){

		   	if( $team_grid_style == 'style1'){
                require $dir.'view/grid25.php';
				return $grid25;		
			}

			if( $team_grid_style == 'style2'){				
				require  $dir.'view/grid22.php';	
				return $grid22;		
			}

			if( $team_grid_style == 'style3'){				
				require  $dir.'view/grid21.php';	
				return $grid21;		
			}

			if( $team_grid_style == 'style4'){				
				require  $dir.'view/grid19.php';	
				return $grid19;		
			}

			if( $team_grid_style == 'style5'){				
				require  $dir.'view/grid20.php';	
				return $grid20;		
			}

			if( $team_grid_style == 'style6'){				
				require  $dir.'view/grid17.php';	
				return $grid17;		
			}

			if( $team_grid_style == 'style7'){				
				require  $dir.'view/grid18.php';	
				return $grid18;	
			}
			
		}


		/*=====================================================================
		//Slider type check 
	 	 =======================================================================*/

		elseif($team_type == "slider"){			

		   	if( $team_slider_style == 'style1'){				
				require  $dir.'view/slider25.php';	
				return $slider25;		
			}

			if( $team_slider_style == 'style2'){				
				require  $dir.'view/slider22.php';	
				return $slider22;		
			}

			if( $team_slider_style == 'style3'){				
				require  $dir.'view/slider21.php';	
				return $slider21;		
			}

			if( $team_slider_style == 'style4'){				
				require  $dir.'view/slider19.php';	
				return $slider19;		
			}

			if( $team_slider_style == 'style5'){				
				require  $dir.'view/slider20.php';	
				return $slider20;		
			}

			if( $team_slider_style == 'style6'){				
				require  $dir.'view/slider17.php';	
				return $slider17;		
			}

			if( $team_slider_style == 'style7'){				
				require  $dir.'view/slider18.php';	
				return $slider18;		
			}
		}
	
	}
}
add_shortcode( 'wp_ultimate_team_shortcode', 'uteam_team_shortcode' );

/**
 * Check single team page
 */


$settings_options = get_option( 'uteam_settings_option' );
$select_single_template_2 = isset( $settings_options['select_single_template_2'] ) ? $settings_options['select_single_template_2'] : 'theme';

if ( $select_single_template_2 !== 'theme' ) {
    // assign single template
    function uteam_get_custom_post_type_template( $single_template ) {
        global $post;
        if ( $post->post_type == 'wp_uteam' ) {
            $single_template = dirname( __FILE__ ) . '/single_team.php';
        }
        return $single_template;
    }

    add_filter( 'single_template', 'uteam_get_custom_post_type_template' );
}
