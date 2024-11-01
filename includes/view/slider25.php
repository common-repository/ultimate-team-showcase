<?php
/* Slider Style 25 */

$slider25 = '<div class="team-style post_' . esc_attr($post_id) . '">
    <div class="team-slider-style">
        <div class="slider-style slider-style-25  owl-carousel '.esc_attr( $slider_dots_nav ).' '.esc_attr( $slider_nav_arrow ).'" data-carousel-options="'.esc_attr( $owl_data ).'">';
if ($que->have_posts()) {
    while ($que->have_posts()) : $que->the_post();
        $designation  = get_post_meta(get_the_ID(), 'uteam_designation', true);
        $description  = get_post_meta(get_the_ID(), 'uteam_description', true);
        $member_image = get_the_post_thumbnail_url(get_the_ID());
        $link         = get_the_permalink();
        $title        = get_the_title();
        $member_social = get_post_meta(get_the_ID(), 'member_social', true);

        $slider25 .= '<div class="single-member-area">
                            <div class="team-inner-wrap">';

			        $slider25 .= '<div class="image-wrap">';
				        if (has_post_thumbnail()) {
				            $slider25 .= '<a href="' . esc_url($link) . '"><img src="' . esc_url($member_image) . '" alt="Images"></a>';
				        }

				        $slider25 .= '<span class="team-social-collaps"><i class="fas fa-share-alt"></i></span>';
				        
				        $slider25 .= '<div class="plus-team">';
					        $slider25 .= '<span class="share-excerpt">Follow Me-</span>';
					        $slider25 .= '<div class="social-icons1">';
						        foreach ($member_social as $team_social) {
						            $s_link = isset($team_social['social_url']) ? $team_social['social_url'] : '';
						            $s_icon = isset($team_social['social_class']) ? $team_social['social_class'] : '';
						            if (!empty($s_link)) {
						                $slider25 .= '<a href="' . esc_url($s_link) . '" class="social-icon"><i class="' . esc_attr($s_icon) . '"></i></a>';
						            }
						        }
					        $slider25 .= '</div>';
				        $slider25 .= '</div>';
			        
				    $slider25 .= '</div>';

			        $slider25 .= '<div class="team-content">';
				        $slider25 .= '<h5 class="team-name"><a href="' . esc_url($link) . '">' . esc_html($title) . '</a></h5>';

				        if (!empty($designation)) {
				            $slider25 .= '<span class="team-title">' . esc_html($designation) . '</span>';
				        }

			        $slider25 .= '</div>';

	        	$slider25 .= '</div>
	                        
	                    </div>';

    endwhile;
    wp_reset_query();

    $paginate = paginate_links(array(
        'total' => $que->max_num_pages
    ));

    if ($paginate && $pagination == 'true') {
        $pagination = '<div class="pagination-area"><div class="nav-links">' . sprintf("%s", $paginate) . '</div></div>';
    } else {
        $pagination = '';
    }

    $slider25 .= sprintf("%s", $pagination);
}
$slider25 .= '</div>
    </div>
</div>';

$slider25 .= '<style>';
	if( !empty( $uteam_font_size_title ) ){
        $slider25 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-25 .single-member-area .team-inner-wrap .team-content .team-name a{
			font-size: ".esc_html( $uteam_font_size_title ).";
		}";
	}
	if( !empty( $style_titlecolor ) ){
        $slider25 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-25 .single-member-area .team-inner-wrap .team-content .team-name a{
			color: ".esc_html( $style_titlecolor ).";
		}";
	}
	if( !empty( $uteam_overly_hover_titlecolor ) ){
        $slider25 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-25 .single-member-area .team-inner-wrap .team-content .team-name a:hover{
			color: ".esc_html( $uteam_overly_hover_titlecolor ).";
		}";
	}
	if( !empty( $uteam_font_size_designation ) ){
        $slider25 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-25.single-member-area .team-inner-wrap .team-content .team-title{
			font-size: ".esc_html( $uteam_font_size_designation ).";
		}";
	}
	if( !empty( $style_desicolor ) ){
        $slider25 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-25 .single-member-area .team-inner-wrap .team-content .team-title{
			color: ".esc_html( $style_desicolor ).";
		}";
		$slider25 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-25 .single-member-area .team-inner-wrap .image-wrap .plus-team .share-excerpt{
            color: ".esc_html( $style_desicolor ).";
        }";
	}
	
	if( !empty( $uteam_icon_color ) ){
        $slider25 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-25 .single-member-area .team-inner-wrap .image-wrap .plus-team .social-icons1 a i{
			color: {$uteam_icon_color};
		}";
	}
	
	if( !empty( $uteam_icon_hovercolor ) ){
        $slider25 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-25 .single-member-area .team-inner-wrap .image-wrap .plus-team .social-icons1 a i:hover{
			color: ".esc_html( $uteam_icon_hovercolor ).";
		}";
	}
	
	if( !empty( $uteam_sicon_font_size ) ){
        $slider25 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-25 .single-member-area .team-inner-wrap .team-content .social-area ul .social-item .social-icon{
			font-size: ".esc_html( $uteam_sicon_font_size ).";
		}";
	}
	if( !empty( $uteam_team_section_bg_color ) ){
        $slider25 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-25 .single-member-area .team-inner-wrap{
			background-color: ".esc_html( $uteam_team_section_bg_color ).";
		}";
	}

	if( !empty( $uteam_icon_bg ) ){
        $slider25 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-25 .single-member-area .team-inner-wrap .image-wrap .plus-team .social-icons1 a i{
            background-color: ".esc_html( $uteam_icon_bg ).";
        }";
    }
    
    if( !empty( $uteam_icon_bghover ) ){
        $slider25 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-25 .single-member-area .team-inner-wrap .image-wrap .plus-team .social-icons1 a i:hover{
            background-color: ".esc_html( $uteam_icon_bghover ).";
        }";
    }

    if( !empty( $uteam_linkcolor ) ){
        $slider25 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-25 .single-member-area .team-inner-wrap .image-wrap .team-social-collaps{
            color: ".esc_html( $uteam_linkcolor ).";
        }";
    }
    
    if( !empty( $uteam_link_bg_color ) ){
        $slider25 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-25 .single-member-area .team-inner-wrap .image-wrap .team-social-collaps{
            background: ".esc_html( $uteam_link_bg_color ).";
        }";
    }
    if( !empty( $uteam_slider_nav_color ) ){
        $slider25 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-25.owl-carousel .owl-nav button.owl-prev:hover, .team-slider-style .slider-style-25.owl-carousel .owl-nav button.owl-next:hover{
			color: ".esc_html( $uteam_slider_nav_color ).";
		}";
	}
	if( !empty( $uteam_slider_nav_bg_color ) ){
        $slider25 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-25.owl-carousel .owl-nav button.owl-prev:hover, .team-slider-style .slider-style-25.owl-carousel .owl-nav button.owl-next:hover{
			background-color: ".esc_html( $uteam_slider_nav_bg_color ).";
		}";
	}
	if( !empty( $uteam_slider_nav_bg_color ) ){
        $slider25 .= ".post_".esc_attr( $post_id )." .owl-carousel .owl-dots .owl-dot{
			border: 1px solid ".esc_html( $uteam_slider_nav_bg_color ).";
		}";
	}
	if( !empty( $uteam_slider_nav_bg_color ) ){
        $slider25 .= ".post_".esc_attr( $post_id )." .owl-carousel .owl-dots .active{
			background-color: ".esc_html( $uteam_slider_nav_bg_color ).";
		}";
	}

$slider25 .= '</style>';
?>
