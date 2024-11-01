<?php
/*Grid Style 18*/

$grid18 = '<div class="team-style post_'.esc_attr( $post_id ).'">
	<div class="team-grid-style">
		<div class="cl-row grid-style-18">';
			if ( $que->have_posts() ) {
				while ( $que->have_posts() ) : $que->the_post();
					$designation  = get_post_meta(get_the_ID(), 'uteam_designation', true);
					$description  = get_post_meta(get_the_ID(), 'uteam_description', true);
					$member_image = get_the_post_thumbnail_url( get_the_ID() );
					$link         = get_the_permalink();
					$title        = get_the_title();
                    $member_social = get_post_meta( get_the_ID(), 'member_social', true );

                    $grid18 .= '<div class="cl-lg-'.esc_attr( $team_grid_colum ).' cl-sm-6">
				        			<div class="single-member-area">
					          			<div class="team-wrap">';
					                    	$grid18 .='<div class="image-wrap">';                  
						            			if ( has_post_thumbnail() ) {
					                                $grid18 .= '<a href="'. esc_url( $link ) .'"><img src="' . esc_url( $member_image ) . '" alt=""></a>';
												}
												if( !empty( $member_social ) ){
						                            $grid18 .='<div class="social-area">';
							                            
							                            $grid18 .= '<ul>';
							                            foreach ( $member_social as $team_social ) {
							                                $s_link = isset($team_social['social_url']) ? $team_social['social_url'] : '';
															$s_icon = isset($team_social['social_class']) ? $team_social['social_class'] : '';
							                                if (!empty($s_link)) {
													            $grid18 .= '<li class="social-item"><a href="' . $s_link . '" class="social-icon" target="_blank"><i class="' . $s_icon . '"></i></a></li>';
													        }
															

							                            }
							                            $grid18 .= '</ul>';
							                        $grid18 .='</div>';
							                    }
												
					                   		$grid18 .='</div>';

					                    	$grid18 .='<div class="team-content">
					                            <h3 class="team-name">
					                            	<a href="'.esc_url( $link ).'" data-id="1" class="cl-single-item-popup">'.esc_html( $title ).'</a>
					                            </h3>';

					                            if( !empty($designation ) ){
					                                $grid18 .='<span class="team-title">'.esc_html( $designation ).'</span>';
					                            }
					                    
						                        if( !empty( $member_social ) ){
						                            $grid18 .='<div class="social-meta-icon">';
							                            $grid18 .='<i class="fas fa-share-alt"></i>';
							                            
							                        $grid18 .='</div>';
							                    }
					                    	$grid18 .='</div>';
                    $grid18 .='			</div>
			          				</div>
			          			</div>';

				endwhile;
				wp_reset_query();
			}
	$grid18 .='</div>
	</div>
</div>';

$grid18 .= '<style>';
	
	// Title
	if( !empty( $uteam_font_size_title ) ){
        $grid18 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-18 .single-member-area .team-wrap .team-content .team-name a{
			font-size: ".esc_html( $uteam_font_size_title ).";
		}";
	}
	if( !empty( $style_titlecolor ) ){
        $grid18 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-18 .single-member-area .team-wrap .team-content .team-name a{
			color: ".esc_html( $style_titlecolor ).";
		}";
	}
	if( !empty( $uteam_overly_hover_titlecolor ) ){
        $grid18 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-18 .single-member-area .team-wrap .team-content .team-name:hover a{
			color: ".esc_html( $uteam_overly_hover_titlecolor ).";
		}";
	}

	// designation
	if( !empty( $uteam_font_size_designation ) ){
        $grid18 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-18 .single-member-area .team-wrap .team-content .team-title{
			font-size: ".esc_html( $uteam_font_size_designation ).";
		}";
	}
	if( !empty( $style_desicolor ) ){
        $grid18 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-18 .single-member-area .team-wrap .team-content .team-title{
			color: ".esc_html( $style_desicolor ).";
		}";
	}
	
	// Icon
	if( !empty( $uteam_icon_color ) ){
        $grid18 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-18 .single-member-area .team-wrap .image-wrap .social-area .social-icon i{
			color: {$uteam_icon_color};
		}";
	}
	if( !empty( $uteam_icon_hovercolor ) ){
        $grid18 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-18 .single-member-area .team-wrap .image-wrap .social-area .social-icon:hover i{
			color: ".esc_html( $uteam_icon_hovercolor ).";
		}";
	}
	if( !empty( $uteam_linkcolor ) ){
        $grid18 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-18 .single-member-area .team-wrap .team-content .social-meta-icon{
			color: {$uteam_linkcolor};
		}";
	}
	if( !empty( $uteam_link_bg_color ) ){
        $grid18 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-18 .single-member-area .team-wrap .team-content .social-meta-icon{
			background: ".esc_html( $uteam_link_bg_color ).";
		}";
		$grid18 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-18 .single-member-area .team-wrap .image-wrap .social-area ul{
			background: ".esc_html( $uteam_link_bg_color ).";
		}";
	}
	if( !empty( $uteam_sicon_font_size ) ){
        $grid18 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-18 .single-member-area .team-wrap .image-wrap .social-area .social-icon i{
			font-size: ".esc_html( $uteam_sicon_font_size ).";
		}";
	}
	//Other
	if( !empty( $uteam_team_section_bg_color ) ){
        $grid18 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-18 .single-member-area .team-wrap{
			background-color: ".esc_html( $uteam_team_section_bg_color ).";
		}";
		$grid18 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-18 .single-member-area .team-wrap .team-content{
			background-color: ".esc_html( $uteam_team_section_bg_color ).";
		}";
	}

	if( !empty( $uteam_sicon_section_bg_color ) ){
        $grid18 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-18 .single-member-area .team-wrap .image-wrap .social-area ul{
			background-color: ".esc_html( $uteam_sicon_section_bg_color ).";
		}";
		$grid18 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-18 .single-member-area .team-wrap .team-content .social-meta-icon{
			background-color: ".esc_html( $uteam_sicon_section_bg_color ).";
		}";
		
	}


$grid18 .= '</style>';