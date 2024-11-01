<?php
/*Slider Style 22*/

$slider22 = '<div class="team-style post_'.esc_attr( $post_id ).'">
	<div class="team-slider-style">
		<div class="slider-style slider-style-22 owl-carousel '.esc_attr( $slider_dots_nav ).' '.esc_attr( $slider_nav_arrow ).'" data-carousel-options="'.esc_attr( $owl_data ).'">';
			if ( $que->have_posts() ) {
				while ( $que->have_posts() ) : $que->the_post();
					$designation  = get_post_meta(get_the_ID(), 'uteam_designation', true);
					$description  = get_post_meta(get_the_ID(), 'uteam_description', true);
					$member_image = get_the_post_thumbnail_url( get_the_ID() );
					$link         = get_the_permalink();
					$title        = get_the_title();
                    $member_social = get_post_meta( get_the_ID(), 'member_social', true );

                    $slider22 .= '<div class="single-member-area">
				          			<div class="team-wrap">';
			                    	$slider22 .='<div class="image-wrap">';                  
				            			if ( has_post_thumbnail() ) {
			                                $slider22 .= '<a href="'. esc_url( $link ) .'"><img src="' . esc_url( $member_image ) . '" alt=""></a>';
										}
										$slider22 .='<div class="overlay-section">';
											$slider22 .='<h4 class="team-name">
			                            	<a href="'.esc_url( $link ).'" data-id="1" class="cl-single-item-popup">'.esc_html( $title ).'</a>
			                            	</h4>';
											if( !empty($designation ) ){
				                                $slider22 .='<span class="team-title">'.esc_html( $designation ).'</span>';
				                            }

											if( !empty( $member_social ) ){
					                            $slider22 .='<div class="social-area">';
						                            
						                            $slider22 .= '<ul>';
						                            foreach ( $member_social as $team_social ) {
						                                $s_link = isset($team_social['social_url']) ? $team_social['social_url'] : '';
														$s_icon = isset($team_social['social_class']) ? $team_social['social_class'] : '';
						                                if (!empty($s_link)) {
												            $slider22 .= '<li class="social-item"><a href="' . $s_link . '" class="social-icon" target="_blank"><i class="' . $s_icon . '"></i></a></li>';
												        }
						                            }
						                            $slider22 .= '</ul>';
						                        $slider22 .='</div>';
						                    }
						                $slider22 .='</div>';    
			                   		$slider22 .='</div>';

			                    	$slider22 .='<div class="team-content">';
			                            $slider22 .='<h4 class="team-name">
			                            	<a href="'.esc_url( $link ).'" data-id="1" class="cl-single-item-popup">'.esc_html( $title ).'</a>
			                            	</h4>';
			                        $slider22 .='</div>';    		
                    $slider22 .='			</div>
			          				</div>';

				endwhile;
				wp_reset_query();

				$paginate = paginate_links( array(
						'total' => $que->max_num_pages
					));	

				if($paginate && $pagination == 'true'){
					$pagination = '<div class="pagination-area"><div class="nav-links">'.sprintf( "%s", $paginate ).'</div></div>';
				}else{
					$pagination ='';
				}

                $slider22 .= sprintf( "%s", $pagination );
			}
	$slider22 .='</div>
	</div>
</div>';

$slider22 .= '<style>';
	if( !empty( $uteam_font_size_title ) ){
        $slider22 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-22 .single-member-area .team-wrap .team-content .team-name{
			font-size: ".esc_html( $uteam_font_size_title ).";
		}";
		$slider22 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-22 .single-member-area .team-wrap .image-wrap .overlay-section .team-name a{
			font-size: ".esc_html( $uteam_font_size_title ).";
		}";
	}
	if( !empty( $style_titlecolor ) ){
        $slider22 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-22 .single-member-area .team-wrap .team-content .team-name a{
			color: ".esc_html( $style_titlecolor ).";
		}";
		$slider22 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-22 .single-member-area .team-wrap .image-wrap .overlay-section .team-name a{
			color: ".esc_html( $style_titlecolor ).";
		}";
	}

	if( !empty( $uteam_font_size_designation ) ){
        $slider22 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-22 .single-member-area .team-wrap .image-wrap .overlay-section .team-title{
			font-size: ".esc_html( $uteam_font_size_designation ).";
		}";
	}
	if( !empty( $style_desicolor ) ){
        $slider22 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-22 .single-member-area .team-wrap .image-wrap .overlay-section .team-title{
			color: ".esc_html( $style_desicolor ).";
		}";
	}
	
	if( !empty( $uteam_icon_color ) ){
        $slider22 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-22 .single-member-area .team-wrap .image-wrap .overlay-section .social-area ul .social-item a {
			color: {$uteam_icon_color};
		}";
	}
	
	if( !empty( $uteam_sicon_border_radious ) ){
        $slider22 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-22 .single-member-area .team-wrap .image-wrap .social-area .social-icon i{
			border-radius: ".esc_html( $uteam_sicon_border_radious ).";
		}";
	}
	if( !empty( $uteam_icon_hovercolor ) ){
        $slider22 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-22 .single-member-area .team-wrap .image-wrap .overlay-section .social-area ul .social-item a:hover{
			color: ".esc_html( $uteam_icon_hovercolor ).";
		}";
	}

	if( !empty( $uteam_icon_bg ) ){
        $slider22 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-22 .single-member-area .team-wrap .image-wrap .overlay-section .social-area ul .social-item a {
            background-color: {$uteam_icon_bg};
        }";
    }
	if( !empty( $uteam_icon_bghover ) ){
        
		$border_opacity = 0.02; // Set opacity value between 0 and 1

	    $slider22 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-22 .single-member-area .team-wrap .image-wrap .overlay-section .social-area ul .social-item a:hover{
	        border-color: rgba(" . implode(', ', sscanf($uteam_icon_bghover, "#%02x%02x%02x")) . ", " . $border_opacity . ");

	    }";
	}
	if( !empty( $uteam_sicon_font_size ) ){
        $slider22 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-22 .single-member-area .team-wrap .image-wrap .social-area .social-icon i{
			font-size: ".esc_html( $uteam_sicon_font_size ).";
		}";
	}
	if( !empty( $uteam_team_section_bg_color ) ){
        $slider22 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-22 .single-member-area .team-wrap .image-wrap .overlay-section{
			background-color: ".esc_html( $uteam_team_section_bg_color ).";
		}";
	}
	if( !empty( $uteam_slider_nav_color ) ){
        $slider22 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-22.owl-carousel .owl-nav button.owl-prev:hover, .team-slider-style .slider-style-22.owl-carousel .owl-nav button.owl-next:hover{
			color: ".esc_html( $uteam_slider_nav_color ).";
		}";
	}
	if( !empty( $uteam_slider_nav_bg_color ) ){
        $slider22 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-22.owl-carousel .owl-nav button.owl-prev:hover, .team-slider-style .slider-style-22.owl-carousel .owl-nav button.owl-next:hover{
			background-color: ".esc_html( $uteam_slider_nav_bg_color ).";
		}";
	}
	if( !empty( $uteam_slider_nav_bg_color ) ){
        $slider22 .= ".post_".esc_attr( $post_id )." .owl-carousel .owl-dots .owl-dot{
			border: 1px solid ".esc_html( $uteam_slider_nav_bg_color ).";
		}";
	}
	if( !empty( $uteam_slider_nav_bg_color ) ){
        $slider22 .= ".post_".esc_attr( $post_id )." .owl-carousel .owl-dots .active{
			background-color: ".esc_html( $uteam_slider_nav_bg_color ).";
		}";
	}

$slider22 .= '</style>';