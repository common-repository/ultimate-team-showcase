<?php
/* Grid Style 25 */

$grid25 = '<div class="team-style post_' . esc_attr($post_id) . '">
    <div class="team-grid-style">
        <div class="cl-row grid-style-25">';
if ($que->have_posts()) {
    while ($que->have_posts()) : $que->the_post();
        $designation  = get_post_meta(get_the_ID(), 'uteam_designation', true);
        $description  = get_post_meta(get_the_ID(), 'uteam_description', true);
        $member_image = get_the_post_thumbnail_url(get_the_ID());
        $link         = get_the_permalink();
        $title        = get_the_title();
        $member_social = get_post_meta(get_the_ID(), 'member_social', true);

        $grid25 .= '<div class="cl-lg-' . esc_attr($team_grid_colum) . ' cl-sm-6">
                        <div class="single-member-area">
                            <div class="team-inner-wrap">';

	        $grid25 .= '<div class="image-wrap">';
	        if (has_post_thumbnail()) {
	            $grid25 .= '<a href="' . esc_url($link) . '"><img src="' . esc_url($member_image) . '" alt="Images"></a>';
	        }
	        $grid25 .= '<span class="team-social-collaps"><i class="fas fa-share-alt"></i></span>';
	        $grid25 .= '<div class="plus-team">';
		        $grid25 .= '<span class="share-excerpt">Follow Me-</span>';
		        $grid25 .= '<div class="social-icons1">';
		        foreach ($member_social as $team_social) {
		            $s_link = isset($team_social['social_url']) ? $team_social['social_url'] : '';
		            $s_icon = isset($team_social['social_class']) ? $team_social['social_class'] : '';
		            if (!empty($s_link)) {
		                $grid25 .= '<a href="' . esc_url($s_link) . '" class="social-icon"><i class="' . esc_attr($s_icon) . '"></i></a>';
		            }
		        }
		        $grid25 .= '</div>';
	        $grid25 .= '</div>';
        $grid25 .= '</div>';

        $grid25 .= '<div class="team-content">';
        $grid25 .= '<h5 class="team-name"><a href="' . esc_url($link) . '">' . esc_html($title) . '</a></h5>';

        if (!empty($designation)) {
            $grid25 .= '<span class="team-title">' . esc_html($designation) . '</span>';
        }

        $grid25 .= '</div>';

        $grid25 .= '</div>
                        </div>
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

    $grid25 .= sprintf("%s", $pagination);
}
$grid25 .= '</div>
    </div>
</div>';

$grid25 .= '<style>';
	if( !empty( $uteam_font_size_title ) ){
        $grid25 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-25 .single-member-area .team-inner-wrap .team-content .team-name a{
			font-size: ".esc_html( $uteam_font_size_title ).";
		}";
	}
	if( !empty( $style_titlecolor ) ){
        $grid25 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-25 .single-member-area .team-inner-wrap .team-content .team-name a{
			color: ".esc_html( $style_titlecolor ).";
		}";
	}
	if( !empty( $uteam_overly_hover_titlecolor ) ){
        $grid25 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-25 .single-member-area .team-inner-wrap .team-content .team-name a:hover{
			color: ".esc_html( $uteam_overly_hover_titlecolor ).";
		}";
	}
	if( !empty( $uteam_font_size_designation ) ){
        $grid25 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-25 .single-member-area .team-inner-wrap .team-content .team-title{
			font-size: ".esc_html( $uteam_font_size_designation ).";
		}";
	}
	if( !empty( $style_desicolor ) ){
        $grid25 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-25 .single-member-area .team-inner-wrap .team-content .team-title{
			color: ".esc_html( $style_desicolor ).";
		}";
	}
	if( !empty( $style_desicolor ) ){
        $grid25 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-25 .single-member-area .team-inner-wrap .image-wrap .plus-team .share-excerpt{
			color: ".esc_html( $style_desicolor ).";
		}";
	}
	// Social Icon Section
	if( !empty( $uteam_icon_color ) ){
        $grid25 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-25 .single-member-area .team-inner-wrap .image-wrap .plus-team .social-icons1 a i{
			color: ".esc_html( $uteam_icon_color ).";
		}";
	}
	
	if( !empty( $uteam_icon_hovercolor ) ){
        $grid25 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-25 .single-member-area .team-inner-wrap .image-wrap .plus-team .social-icons1 a i:hover{
			color: ".esc_html( $uteam_icon_hovercolor ).";
		}";
	}
	if( !empty( $uteam_icon_bg ) ){
        $grid25 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-25 .single-member-area .team-inner-wrap .image-wrap .plus-team .social-icons1 a i{
			background-color: ".esc_html( $uteam_icon_bg ).";
		}";
	}
	
	if( !empty( $uteam_icon_bghover ) ){
        $grid25 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-25 .single-member-area .team-inner-wrap .image-wrap .plus-team .social-icons1 a i:hover{
			background-color: ".esc_html( $uteam_icon_bghover ).";
		}";
	}

	if( !empty( $uteam_linkcolor ) ){
        $grid25 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-25 .single-member-area .team-inner-wrap .image-wrap .team-social-collaps{
			color: ".esc_html( $uteam_linkcolor ).";
		}";
	}
	
	if( !empty( $uteam_link_bg_color ) ){
        $grid25 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-25 .single-member-area .team-inner-wrap .image-wrap .team-social-collaps{
			background: ".esc_html( $uteam_link_bg_color ).";
		}";
	}

	
	
	if( !empty( $uteam_sicon_font_size ) ){
        $grid25 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-25 .single-member-area .team-inner-wrap .image-wrap .plus-team .social-icons1 a i{
			font-size: ".esc_html( $uteam_sicon_font_size ).";
		}";
	}
	if( !empty( $uteam_sicon_border_radious ) ){
        $grid25 .= ".post_".esc_attr( $post_id )." .team-grid-style .grid-style-25 .single-member-area .team-inner-wrap .image-wrap .plus-team .social-icons1 a i{
			border-radius: ".esc_html( $uteam_sicon_border_radious ).";
		}";
	}

$grid25 .= '</style>';
?>
