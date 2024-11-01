<?php
/*Grid Style 21*/

$grid21 = '<div class="team-style post_'.esc_attr( $post_id ).'">
	<div class="team-grid-style">
		<div class="cl-row grid-style-21">';
			if ( $que->have_posts() ) {
				while ( $que->have_posts() ) : $que->the_post();
					$designation  = get_post_meta(get_the_ID(), 'uteam_designation', true);
					$description  = get_post_meta(get_the_ID(), 'uteam_description', true);
					$member_image = get_the_post_thumbnail_url( get_the_ID() );
					$link         = get_the_permalink();
					$title        = get_the_title();
                    $member_social = get_post_meta( get_the_ID(), 'member_social', true );

                    $grid21 .= '<div class="cl-lg-'.esc_attr( $team_grid_colum ).' cl-sm-6">
				        			<div class="single-member-area">
					          			<div class="team-wrap">';
					                    	$grid21 .='<div class="image-wrap">';                  
						            			if ( has_post_thumbnail() ) {
					                                $grid21 .= '<a href="'. esc_url( $link ) .'"><img src="' . esc_url( $member_image ) . '" alt=""></a>';
												}
					                   		$grid21 .='</div>';

					                    	$grid21 .='<div class="team-content">
					                            <h3 class="team-name">
					                            	<a href="'.esc_url( $link ).'" data-id="1" class="cl-single-item-popup">'.esc_html( $title ).'</a>
					                            </h3>';

					                            if( !empty($designation ) ){
					                                $grid21 .='<span class="team-title">'.esc_html( $designation ).'</span>';
					                            }
					                    
						                        if( !empty( $member_social ) ){
						                            $grid21 .='<div class="social-area">';
							                            
							                            $grid21 .= '<ul>';
							                            foreach ( $member_social as $team_social ) {
							                                $s_link = isset($team_social['social_url']) ? $team_social['social_url'] : '';
															$s_icon = isset($team_social['social_class']) ? $team_social['social_class'] : '';
							                                if (!empty($s_link)) {
													            $grid21 .= '<li class="social-item"><a href="' . $s_link . '" class="social-icon" target="_blank"><i class="' . $s_icon . '"></i></a></li>';
													        }
							                            }
							                            $grid21 .= '</ul>';
							                        $grid21 .='</div>';
							                    }
					                    	$grid21 .='</div>';
                    $grid21 .='			</div>
			          				</div>
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

                $grid21 .= sprintf( "%s", $pagination );
			}
	$grid21 .='</div>
	</div>
</div>';

$grid21 .= '<style>';
	//Title
	if( !empty( $uteam_font_size_title ) ){
        $grid21 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-21 .single-member-area .team-wrap .team-content .team-name a{
			font-size: ".esc_html( $uteam_font_size_title ).";
		}";
	}
	if( !empty( $style_titlecolor ) ){
        $grid21 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-21 .single-member-area .team-wrap .team-content .team-name a{
			color: ".esc_html( $style_titlecolor ).";
		}";
	}
	if( !empty( $uteam_overly_hover_titlecolor ) ){
        $grid21 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-21 .single-member-area .team-wrap .team-content .team-name:hover a{
			color: ".esc_html( $uteam_overly_hover_titlecolor ).";
		}";
	}
	// Designation
	if( !empty( $uteam_font_size_designation ) ){
        $grid21 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-21 .single-member-area .team-wrap .team-content .team-title{
			font-size: ".esc_html( $uteam_font_size_designation ).";
		}";
	}
	if( !empty( $style_desicolor ) ){
        $grid21 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-21 .single-member-area .team-wrap .team-content .team-title{
			color: ".esc_html( $style_desicolor ).";
		}";
	}
	
	// Social
	if( !empty( $uteam_icon_color ) ){
        $grid21 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-21 .single-member-area .team-wrap .team-content .social-area ul .social-item .social-icon{
			color: {$uteam_icon_color};
		}";
		$border_opacity = 0.13; // Set opacity value between 0 and 1

	    $grid21 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-21 .single-member-area .team-wrap .team-content .social-area ul .social-item .social-icon{
	        border-color: rgba(" . implode(', ', sscanf($uteam_icon_color, "#%02x%02x%02x")) . ", " . $border_opacity . ");
	    }";
	}
	if( !empty( $uteam_sicon_border_radious ) ){
        $grid21 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-21 .single-member-area .team-wrap .team-content .social-area ul .social-item .social-icon{
			border-radius: ".esc_html( $uteam_sicon_border_radious ).";
		}";
	}
	if( !empty( $uteam_icon_hovercolor ) ){
        $grid21 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-21 .single-member-area .team-wrap .team-content .social-area ul .social-item .social-icon:hover{
			color: ".esc_html( $uteam_icon_hovercolor ).";
		}";

		$border_opacity = 0.13; // Set opacity value between 0 and 1

	    $grid21 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-21 .single-member-area .team-wrap .team-content .social-area ul .social-item .social-icon:hover{
	        border-color: rgba(" . implode(', ', sscanf($uteam_icon_hovercolor, "#%02x%02x%02x")) . ", " . $border_opacity . ");
	    }";
	}
	
	if( !empty( $uteam_sicon_font_size ) ){
        $grid21 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-21 .single-member-area .team-wrap .image-wrap .social-area .social-icon i{
			font-size: ".esc_html( $uteam_sicon_font_size ).";
		}";
	}
	if( !empty( $uteam_icon_bghover ) ){
        $grid21 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-21 .single-member-area .team-wrap .team-content .social-area ul .social-item .social-icon:hover{
			background-color: ".esc_html( $uteam_icon_bghover ).";
		}";
	}
	if( !empty( $uteam_icon_bg ) ){
        $grid21 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-21 .single-member-area .team-wrap .team-content .social-area ul .social-item .social-icon{
			background-color: ".esc_html( $uteam_icon_bg ).";
		}";
	}

$grid21 .= '</style>';