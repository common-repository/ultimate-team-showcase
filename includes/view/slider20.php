<?php
/*Grid Style 20*/

$slider20 = '<div class="team-style post_'.esc_attr( $post_id ).'">
	<div class="team-slider-style">
		<div class="slider-style slider-style-20 owl-carousel '.esc_attr( $slider_dots_nav ).' '.esc_attr( $slider_nav_arrow ).'" data-carousel-options="'.esc_attr( $owl_data ).'">';
			if ( $que->have_posts() ) {
				while ( $que->have_posts() ) : $que->the_post();
					$designation  = get_post_meta(get_the_ID(), 'uteam_designation', true);
					$description  = get_post_meta(get_the_ID(), 'uteam_description', true);
					$member_image = get_the_post_thumbnail_url( get_the_ID() );
					$link         = get_the_permalink();
					$title        = get_the_title();
                    $member_social = get_post_meta( get_the_ID(), 'member_social', true );
                    $uteam_phone = get_post_meta( get_the_ID(), 'uteam_phone', true);
                    $uteam_email = get_post_meta( get_the_ID(), 'uteam_email', true);
                    $uteam_website = get_post_meta( get_the_ID(), 'uteam_website', true);
                    $uteam_address = get_post_meta( get_the_ID(), 'uteam_address', true);  

                    $slider20 .= '<div class="single-member-area">
					          			<div class="team-wrap">';
					                    	$slider20 .='<div class="image-wrap">';                  
						            			if ( has_post_thumbnail() ) {
					                                $slider20 .= '<a href="'. esc_url( $link ) .'"><img src="' . esc_url( $member_image ) . '" alt=""></a>';
												}
					                   		$slider20 .='</div>';

					                    	$slider20 .='<div class="team-content">';

					                            if( !empty($designation ) ){
					                                $slider20 .='<span class="team-title">'.esc_html( $designation ).'</span>';
					                            }

					                            $slider20 .='<h3 class="team-name">
					                            	<a href="'.esc_url( $link ).'" data-id="1" class="cl-single-item-popup">'.esc_html( $title ).'</a>
					                            </h3>';

						                        if(!empty($uteam_phone) || !empty($uteam_email) || !empty($uteam_address) || !empty($uteam_website)){
						                            $slider20 .='<div class="contact-info">';
							                            
							                            $slider20 .= '<ul>';
							                            	if (!empty($uteam_email)) {
														    $slider20 .= '<li><span><a href="mailto:' . esc_attr($uteam_email) . '">' . esc_html($uteam_email) . '</a></span></li>';
															}

															if (!empty($uteam_phone)) {
															    $slider20 .= '<li><span><a href="tel:' . esc_attr($uteam_phone) . '">' . esc_html($uteam_phone) . '</a></span></li>';
															}
							                            
							                            $slider20 .= '</ul>';
							                        $slider20 .='</div>';
							                    }
					                    	$slider20 .='</div>';
                    $slider20 .='			</div>
			          				</div>';

				endwhile;
				wp_reset_query();
			}
	$slider20 .='</div>
	</div>
</div>';

$slider20 .= '<style>';

	//Title
	if( !empty( $uteam_font_size_title ) ){
        $slider20 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-20 .single-member-area .team-wrap .team-content .team-name a{
			font-size: ".esc_html( $uteam_font_size_title ).";
		}";
	}
	if( !empty( $style_titlecolor ) ){
        $slider20 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-20 .single-member-area .team-wrap .team-content .team-name a{
			color: ".esc_html( $style_titlecolor ).";
		}";
	}
	if( !empty( $uteam_overly_hover_titlecolor ) ){
        $slider20 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-20 .single-member-area .team-wrap .team-content .team-name:hover a{
			color: ".esc_html( $uteam_overly_hover_titlecolor ).";
		}";
	}

	//Designation
	if( !empty( $uteam_font_size_designation ) ){
        $slider20 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-20 .single-member-area .team-wrap .team-content .team-title{
			font-size: ".esc_html( $uteam_font_size_designation ).";
		}";
	}
	if( !empty( $style_desicolor ) ){
        $slider20 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-20 .single-member-area .team-wrap .team-content .team-title{
			color: ".esc_html( $style_desicolor ).";
		}";

		$slider20 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-20 .single-member-area .team-wrap .team-content .contact-info ul{
			    border-top-color: ".esc_html( $style_desicolor ).";
		}";
	}
	
	

	//Others
	if( !empty( $uteam_team_section_bg_color ) ){
        $slider20 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-20 .single-member-area .team-wrap .team-content{
			background-color: ".esc_html( $uteam_team_section_bg_color ).";
		}";
	}

	if( !empty( $uteam_team_contact_info_color ) ){
        $slider20 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-20 .single-member-area .team-wrap .team-content .contact-info ul li a{
			color: ".esc_html( $uteam_team_contact_info_color ).";
		}";
	}

	if( !empty( $uteam_team_contact_info_hover_color ) ){
        $slider20 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-20 .single-member-area .team-wrap .team-content .contact-info ul li a:hover{
			color: ".esc_html( $uteam_team_contact_info_hover_color ).";
		}";
	}
	if( !empty( $uteam_slider_nav_color ) ){
        $slider20 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-20.owl-carousel .owl-nav button.owl-prev:hover, .team-slider-style .slider-style-20.owl-carousel .owl-nav button.owl-next:hover{
			color: ".esc_html( $uteam_slider_nav_color ).";
		}";
	}
	if( !empty( $uteam_slider_nav_bg_color ) ){
        $slider20 .= ".post_".esc_attr( $post_id )." .team-slider-style .slider-style-20.owl-carousel .owl-nav button.owl-prev:hover, .team-slider-style .slider-style-20.owl-carousel .owl-nav button.owl-next:hover{
			background-color: ".esc_html( $uteam_slider_nav_bg_color ).";
		}";
	}
	if( !empty( $uteam_slider_nav_bg_color ) ){
        $slider20 .= ".post_".esc_attr( $post_id )." .owl-carousel .owl-dots .owl-dot{
			border: 1px solid ".esc_html( $uteam_slider_nav_bg_color ).";
		}";
	}
	if( !empty( $uteam_slider_nav_bg_color ) ){
        $slider20 .= ".post_".esc_attr( $post_id )." .owl-carousel .owl-dots .active{
			background-color: ".esc_html( $uteam_slider_nav_bg_color ).";
		}";
	}
	

$slider20 .= '</style>';