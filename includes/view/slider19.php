<?php
/*Grid Style 19*/

$slider19 = '<div class="team-style post_'.esc_attr( $post_id ).'">
	<div class="team-slider-style">
		<div class="slider-style slider-style-19 owl-carousel '.esc_attr( $slider_dots_nav ).' '.esc_attr( $slider_nav_arrow ).'" data-carousel-options="'.esc_attr( $owl_data ).'">';
			if ( $que->have_posts() ) {
				while ( $que->have_posts() ) : $que->the_post();
					$designation  = get_post_meta(get_the_ID(), 'uteam_designation', true);
					$description  = get_post_meta(get_the_ID(), 'uteam_description', true);
					$member_image = get_the_post_thumbnail_url( get_the_ID() );
					$link         = get_the_permalink();
					$title        = get_the_title();
                    $member_social = get_post_meta( get_the_ID(), 'member_social', true );

                    $slider19 .= '<div class="single-member-area">
			          			<div class="team-wrap">';
			                    	$slider19 .='<div class="image-wrap">';                  
				            			if ( has_post_thumbnail() ) {
			                                $slider19 .= '<a href="'. esc_url( $link ) .'"><img src="' . esc_url( $member_image ) . '" alt=""></a>';
										}
			                   		$slider19 .='</div>';

			                    	$slider19 .='<div class="team-content">
			                            <h3 class="team-name">
			                            	<a href="'.esc_url( $link ).'" data-id="1" class="cl-single-item-popup">'.esc_html( $title ).'</a>
			                            </h3>';

			                            if( !empty($designation ) ){
			                                $slider19 .='<span class="team-title">'.esc_html( $designation ).'</span>';
			                            }
			                    
				                        if( !empty( $member_social ) ){
				                            $slider19 .='<div class="social-area">';
					                            
					                            $slider19 .= '<ul>';
					                            foreach ( $member_social as $team_social ) {
					                                $s_link = isset($team_social['social_url']) ? $team_social['social_url'] : '';
													$s_icon = isset($team_social['social_class']) ? $team_social['social_class'] : '';
					                                if (!empty($s_link)) {
											            $slider19 .= '<li class="social-item"><a href="' . $s_link . '" class="social-icon" target="_blank"><i class="' . $s_icon . '"></i></a></li>';
											        }
					                            }
					                            $slider19 .= '</ul>';
					                        $slider19 .='</div>';
					                    }
			                    	$slider19 .='</div>';
                    $slider19 .='			</div>
			          				</div>';

				endwhile;
				wp_reset_query();
			}
	$slider19 .='</div>
	</div>
</div>';

$slider19 .= '<style>';
	//Title
	if( !empty( $uteam_font_size_title ) ){
        $slider19 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-19 .single-member-area .team-wrap .team-content .team-name a{
			font-size: ".esc_html( $uteam_font_size_title ).";
		}";
	}
	if( !empty( $style_titlecolor ) ){
        $slider19 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-19 .single-member-area .team-wrap .team-content .team-name a{
			color: ".esc_html( $style_titlecolor ).";
		}";
	}
	//Designation
	if( !empty( $uteam_font_size_designation ) ){
        $slider19 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-19 .single-member-area .team-wrap .team-content .team-title{
			font-size: ".esc_html( $uteam_font_size_designation ).";
		}";
	}
	if( !empty( $style_desicolor ) ){
        $slider19 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-19 .single-member-area .team-wrap .team-content .team-title{
			color: ".esc_html( $style_desicolor ).";
		}";
	}
	
	//Social Icon 
	if( !empty( $uteam_icon_color ) ){
        $slider19 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-19 .single-member-area .team-wrap .social-area ul .social-item a{
			color: {$uteam_icon_color};
		}";
		$slider19 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-19 .single-member-area .team-wrap .social-area ul::before{
			border-left-color: {$uteam_icon_color};
		}";
	}
	if( !empty( $uteam_icon_hovercolor ) ){
        $slider19 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-19 .single-member-area .team-wrap .social-area ul .social-item a:hover{
			color: ".esc_html( $uteam_icon_hovercolor ).";
		}";
	}
	
	if( !empty( $uteam_sicon_font_size ) ){
        $slider19 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-19 .single-member-area .team-wrap .social-area ul .social-item a{
			font-size: ".esc_html( $uteam_sicon_font_size ).";
		}";
	}

	//Others
	if( !empty( $uteam_team_section_bg_color ) ){
        $slider19 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-19 .single-member-area .team-wrap{
			background-color: ".esc_html( $uteam_team_section_bg_color ).";
		}";
	}

	if( !empty( $uteam_sicon_section_bg_color ) ){
        $slider19 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-19 .single-member-area .team-wrap .image-wrap .social-area ul{
			background-color: ".esc_html( $uteam_sicon_section_bg_color ).";
		}";
		$slider19 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-19 .single-member-area .team-wrap .team-content .social-meta-icon{
			background-color: ".esc_html( $style_titlecolor ).";
		}";
		
	}
	if( !empty( $uteam_slider_nav_color ) ){
        $slider19 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-19.owl-carousel .owl-nav button.owl-prev:hover, .team-slider-style .slider-style-19.owl-carousel .owl-nav button.owl-next:hover{
			color: ".esc_html( $uteam_slider_nav_color ).";
		}";
	}
	if( !empty( $uteam_slider_nav_bg_color ) ){
        $slider19 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-19.owl-carousel .owl-nav button.owl-prev:hover, .team-slider-style .slider-style-19.owl-carousel .owl-nav button.owl-next:hover{
			background-color: ".esc_html( $uteam_slider_nav_bg_color ).";
		}";
	}
	if( !empty( $uteam_slider_nav_bg_color ) ){
        $slide19 .= ".post_".esc_attr( $post_id )." .owl-carousel .owl-dots .owl-dot{
			border: 1px solid ".esc_html( $uteam_slider_nav_bg_color ).";
		}";
	}
	if( !empty( $uteam_slider_nav_bg_color ) ){
        $slider19 .= ".post_".esc_attr( $post_id )." .owl-carousel .owl-dots .active{
			background-color: ".esc_html( $uteam_slider_nav_bg_color ).";
		}";
	}

$slider19 .= '</style>';