<?php
/*Slider Style 17*/

$slider17 = '<div class="team-style post_'.esc_attr( $post_id ).'">
	<div class="team-slider-style">
		<div class="slider-style slider-style-17 owl-carousel '.esc_attr( $slider_dots_nav ).' '.esc_attr( $slider_nav_arrow ).'" data-carousel-options="'.esc_attr( $owl_data ).'">';		
			if ( $que->have_posts() ) {
				while ( $que->have_posts() ) : $que->the_post();	
															;
					$designation  = get_post_meta(get_the_ID(), 'uteam_designation', true);
					$description  = get_post_meta(get_the_ID(), 'uteam_description', true);
					$member_image = get_the_post_thumbnail_url( get_the_ID() );
					$link         = get_the_permalink();
					$title        = get_the_title();
                    $member_social = get_post_meta( get_the_ID(), 'member_social', true );               
                   
					$slider17 .= '<div class="single-member-area">
		          			 
					<div class="team-wrap">';
                    $slider17 .='<div class="image-wrap">';
                        $slider17 .='<div class="image-inner">';
	            			if ( has_post_thumbnail() ) {
                                $slider17 .= '<a href="'.esc_url( $link ).'"><img src="' . esc_url( $member_image ) . '" alt="' .get_the_title(). '"></a>';
							}
                        $slider17 .='</div>';
						$svg_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M448 127.1C448 181 405 223.1 352 223.1C326.1 223.1 302.6 213.8 285.4 197.1L191.3 244.1C191.8 248 191.1 251.1 191.1 256C191.1 260 191.8 263.1 191.3 267.9L285.4 314.9C302.6 298.2 326.1 288 352 288C405 288 448 330.1 448 384C448 437 405 480 352 480C298.1 480 256 437 256 384C256 379.1 256.2 376 256.7 372.1L162.6 325.1C145.4 341.8 121.9 352 96 352C42.98 352 0 309 0 256C0 202.1 42.98 160 96 160C121.9 160 145.4 170.2 162.6 186.9L256.7 139.9C256.2 135.1 256 132 256 128C256 74.98 298.1 32 352 32C405 32 448 74.98 448 128L448 127.1zM95.1 287.1C113.7 287.1 127.1 273.7 127.1 255.1C127.1 238.3 113.7 223.1 95.1 223.1C78.33 223.1 63.1 238.3 63.1 255.1C63.1 273.7 78.33 287.1 95.1 287.1zM352 95.1C334.3 95.1 320 110.3 320 127.1C320 145.7 334.3 159.1 352 159.1C369.7 159.1 384 145.7 384 127.1C384 110.3 369.7 95.1 352 95.1zM352 416C369.7 416 384 401.7 384 384C384 366.3 369.7 352 352 352C334.3 352 320 366.3 320 384C320 401.7 334.3 416 352 416z"/></svg>';
                        $slider17 .='<i class="share-i">'.$svg_icon.'</i>';

                        if( !empty( $member_social ) ){
                            $slider17 .='<div class="social-area">';
                            foreach ( $member_social as $team_social ) {
                                $s_link = isset($team_social['social_url']) ? $team_social['social_url'] : '';
								$s_icon = isset($team_social['social_class']) ? $team_social['social_class'] : '';
                                if(!empty($s_link)):
                                    $slider17 .='<a href="'. esc_url($s_link).' " class="social-icon" target="_blank"><i class="'.esc_attr($s_icon).'"></i></a>';
                                endif;
                            }
                            $slider17 .='</div>';
                        }
                    $slider17 .='</div>';
                    $slider17 .='<div class="team-content">
                                <h3 class="team-name"><a href="'.esc_url( $link ).'" data-id="1" class="cl-single-item-popup">'.esc_html( $title ).'</a></h3>';

                                if( !empty($designation ) ){
                                    $slider17 .='<span class="team-title">'.esc_html( $designation ).'</span>';
                                }

                    $slider17 .='</div>';
                    $slider17 .='</div>
							
				    </div>';		   
				endwhile;
				wp_reset_query();
			}
		$slider17 .='</div>
	</div>
</div>';

$slider17 .= '<style>';
	if( !empty( $uteam_font_size_title ) ){
        $slider17 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-17 .single-member-area .team-wrap .team-content .team-name{
			font-size: ".esc_html( $uteam_font_size_title ).";
		}";
	}
	if( !empty( $style_titlecolor ) ){
        $slider17 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-17 .single-member-area .team-wrap .team-content .team-name a{
			color: ".esc_html( $style_titlecolor ).";
		}";
	}
	if( !empty( $uteam_overly_hover_titlecolor ) ){
        $slider17 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-17 .single-member-area .team-wrap .team-content .team-name:hover a{
			color: ".esc_html( $uteam_overly_hover_titlecolor ).";
		}";
	}
	if( !empty( $uteam_font_size_designation ) ){
        $slider17 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-17 .single-member-area .team-wrap .team-content .team-title{
			font-size: ".esc_html( $uteam_font_size_designation ).";
		}";
	}
	if( !empty( $style_desicolor ) ){
        $slider17 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-17 .single-member-area .team-wrap .team-content .team-title{
			color: ".esc_html( $style_desicolor ).";
		}";
	}
	if( !empty( $overlay_color ) ){
        $slider17 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-17 .single-member-area .team-wrap .image-wrap:before{
			background-color: ".esc_html( $overlay_color ).";
		}";
	}
	if( !empty( $uteam_linkcolor ) ){
        $slider17 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-17 .single-member-area .team-wrap .share-i svg{
			fill: ".esc_html( $uteam_linkcolor ).";
		}";
	}
	if( !empty( $uteam_link_bg_color ) ){
        $slider17 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-17 .single-member-area .team-wrap .share-i{
			background-color: ".esc_html( $uteam_link_bg_color ).";
		}";
	}
	if( !empty( $uteam_icon_color ) ){
        $slider17 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-17 .single-member-area .team-wrap .image-wrap .social-area .social-icon i{
			color: {$uteam_icon_color};
		}";
	}
	if( !empty( $uteam_icon_bg ) ){
        $slider17 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-17 .single-member-area .team-wrap .image-wrap .social-area .social-icon i{
			background-color: ".esc_html( $uteam_icon_bg ).";
		}";
	}
	if( !empty( $uteam_sicon_border_radious ) ){
        $slider17 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-17 .single-member-area .team-wrap .image-wrap .social-area .social-icon i{
			border-radius: ".esc_html( $uteam_sicon_border_radious ).";
		}";
	}
	if( !empty( $uteam_icon_hovercolor ) ){
        $slider17 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-17 .single-member-area .team-wrap .image-wrap .social-area .social-icon:hover i{
			color: ".esc_html( $uteam_icon_hovercolor ).";
		}";
	}
	if( !empty( $uteam_icon_bghover ) ){
        $slider17 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-17 .single-member-area .team-wrap .image-wrap .social-area .social-icon:hover i{
			background-color: ".esc_html( $uteam_icon_bghover ).";
		}";
	}
	if( !empty( $uteam_sicon_font_size ) ){
        $slider17 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-17 .single-member-area .team-wrap .image-wrap .social-area .social-icon i{
			font-size: ".esc_html( $uteam_sicon_font_size ).";
		}";
	}
	if( !empty( $uteam_slider_nav_color ) ){
        $slider17 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-17.owl-carousel .owl-nav button.owl-prev:hover, .team-slider-style .slider-style-17.owl-carousel .owl-nav button.owl-next:hover{
			color: ".esc_html( $uteam_slider_nav_color ).";
		}";
	}
	if( !empty( $uteam_slider_nav_bg_color ) ){
        $slider17 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-17.owl-carousel .owl-nav button.owl-prev:hover, .team-slider-style .slider-style-17.owl-carousel .owl-nav button.owl-next:hover{
			background-color: ".esc_html( $uteam_slider_nav_bg_color ).";
		}";
	}
	if( !empty( $uteam_slider_nav_bg_color ) ){
        $slider17 .= ".post_".esc_attr( $post_id )." .owl-carousel .owl-dots .owl-dot{
			border: 1px solid ".esc_html( $uteam_slider_nav_bg_color ).";
		}";
	}
	if( !empty( $uteam_slider_nav_bg_color ) ){
        $slider17 .= ".post_".esc_attr( $post_id )." .owl-carousel .owl-dots .active{
			background-color: ".esc_html( $uteam_slider_nav_bg_color ).";
		}";
	}

$slider17 .= '</style>';