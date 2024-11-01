<?php
/*Grid Style 20*/

$grid20 = '<div class="team-style post_'.esc_attr( $post_id ).'">
	<div class="team-grid-style">
		<div class="cl-row grid-style-20">';
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
                      

                    $grid20 .= '<div class="cl-lg-'.esc_attr( $team_grid_colum ).' cl-sm-6">
				        			<div class="single-member-area">
					          			<div class="team-wrap">';
					                    	$grid20 .='<div class="image-wrap">';                  
						            			if ( has_post_thumbnail() ) {
					                                $grid20 .= '<a href="'. esc_url( $link ) .'"><img src="' . esc_url( $member_image ) . '" alt=""></a>';
												}
					                   		$grid20 .='</div>';

					                    	$grid20 .='<div class="team-content">';

					                            if( !empty($designation ) ){
					                                $grid20 .='<span class="team-title">'.esc_html( $designation ).'</span>';
					                            }

					                            $grid20 .='<h3 class="team-name">
					                            	<a href="'.esc_url( $link ).'" data-id="1" class="cl-single-item-popup">'.esc_html( $title ).'</a>
					                            </h3>';

						                        if(!empty($uteam_phone) || !empty($uteam_email) ){
						                            $grid20 .='<div class="contact-info">';
							                            
							                            $grid20 .= '<ul>';

														if (!empty($uteam_email)) {
														    $grid20 .= '<li><span><a href="mailto:' . esc_attr($uteam_email) . '">' . esc_html($uteam_email) . '</a></span></li>';
														}

														if (!empty($uteam_phone)) {
														    $grid20 .= '<li><span><a href="tel:' . esc_attr($uteam_phone) . '">' . esc_html($uteam_phone) . '</a></span></li>';
														}

														$grid20 .= '</ul>';

							                        $grid20 .='</div>';
							                    }
					                    	$grid20 .='</div>';
                    $grid20 .='			</div>
			          				</div>
			          			</div>';

				endwhile;
				wp_reset_query();
			}
	$grid20 .='</div>
	</div>
</div>';

$grid20 .= '<style>';

	//Title
	if( !empty( $uteam_font_size_title ) ){
        $grid20 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-20 .single-member-area .team-wrap .team-content .team-name a{
			font-size: ".esc_html( $uteam_font_size_title ).";
		}";
	}
	if( !empty( $style_titlecolor ) ){
        $grid20 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-20 .single-member-area .team-wrap .team-content .team-name a{
			color: ".esc_html( $style_titlecolor ).";
		}";
	}
	if( !empty( $uteam_overly_hover_titlecolor ) ){
        $grid20 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-20 .single-member-area .team-wrap .team-content .team-name:hover a{
			color: ".esc_html( $uteam_overly_hover_titlecolor ).";
		}";
	}

	//Designation
	if( !empty( $uteam_font_size_designation ) ){
        $grid20 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-20 .single-member-area .team-wrap .team-content .team-title{
			font-size: ".esc_html( $uteam_font_size_designation ).";
		}";
	}
	if( !empty( $style_desicolor ) ){
        $grid20 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-20 .single-member-area .team-wrap .team-content .team-title{
			color: ".esc_html( $style_desicolor ).";
		}";

		$grid20 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-20 .single-member-area .team-wrap .team-content .contact-info ul{
			    border-top-color: ".esc_html( $style_desicolor ).";
		}";
	}
	
	//Social 
	if( !empty( $uteam_icon_color ) ){
        $grid20 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-20.single-member-area .team-wrap .image-wrap .social-area .social-icon i{
			color: {$uteam_icon_color};
		}";
	}
	
	if( !empty( $uteam_icon_hovercolor ) ){
        $grid20 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-20 .single-member-area .team-wrap .image-wrap .social-area .social-icon:hover i{
			color: ".esc_html( $uteam_icon_hovercolor ).";
		}";
	}
	
	if( !empty( $uteam_sicon_font_size ) ){
        $grid20 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-20 .single-member-area .team-wrap .image-wrap .social-area .social-icon i{
			font-size: ".esc_html( $uteam_sicon_font_size ).";
		}";
	}

	//Others
	if( !empty( $uteam_team_section_bg_color ) ){
        $grid20 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-20 .single-member-area .team-wrap .team-content{
			background-color: ".esc_html( $uteam_team_section_bg_color ).";
		}";
	}

	if( !empty( $uteam_team_contact_info_color ) ){
        $grid20 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-20 .single-member-area .team-wrap .team-content .contact-info ul li a{
			color: ".esc_html( $uteam_team_contact_info_color ).";
		}";
	}

	if( !empty( $uteam_team_contact_info_hover_color ) ){
        $grid20 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-20 .single-member-area .team-wrap .team-content .contact-info ul li a:hover{
			color: ".esc_html( $uteam_team_contact_info_hover_color ).";
		}";
	}
	
$grid20 .= '</style>';