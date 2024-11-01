<?php get_header(); ?>

<?php
 $settings_options = get_option( 'uteam_settings_option' );
?>
<div class="single-member">
    <div class="container">
        <div class="cl-row single-member-details">
            <?php while ( have_posts() ) : the_post();
                $designation    = get_post_meta(get_the_ID(), 'uteam_designation', true);
                $description    = get_post_meta(get_the_ID(), 'uteam_description', true);
                $member_image   = get_the_post_thumbnail_url( get_the_ID() );
                $link           = get_the_permalink();
                $title          = get_the_title();
                $member_social  = get_post_meta( get_the_ID(), 'member_social', true );    
                $uteam_phone    = get_post_meta( get_the_ID(), 'uteam_phone', true);
                $uteam_email    = get_post_meta( get_the_ID(), 'uteam_email', true);
                $uteam_website = get_post_meta( get_the_ID(), 'uteam_website', true);
                $uteam_address  = get_post_meta( get_the_ID(), 'uteam_address', true); 

                ?>

            <div class="cl-md-5 cl-lg-4 cl-sm-12">
              
              <div id="uteam_main" role="uteam_main" >
                  <?php
                  $member_image = get_the_post_thumbnail(get_the_ID(), array(400, 400));
                  echo esc_url($member_image);
                  ?>
              </div>


            </div>
            <div class="cl-md-7 cl-lg-8 cl-sm-12">
              <div class="description">
              	<div class="left-part">
                	<div class="single-member-title">
    	               <h2><?php the_title();?></h2>
                     
                     
    	                <?php if(!empty( $designation )):?>
    	                    <span><?php echo esc_html($designation); ?></span> 
    	                <?php endif; ?>
    	            </div>



                    <?php if (!empty($member_social)): ?>
                      <div class="social-icons">
                          <?php foreach ($member_social as $team_social) {
                              $s_link = isset($team_social['social_url']) ? $team_social['social_url'] : '';
                              $s_icon = isset($team_social['social_class']) ? $team_social['social_class'] : '';
                              
                              if (!empty($s_link)) {
                                  ?>
                                  <a href="<?php echo esc_url($s_link); ?>" class="social-icon" target="_blank"><i
                                              class="<?php echo esc_attr($s_icon); ?>"></i></a>
                                  <?php
                              }
                          } ?>
                      </div>
                  <?php endif; ?>

                </div>

                <div class="right-part">
                    
                	<?php if( !empty($uteam_phone) || !empty($uteam_address) || !empty($uteam_email) || !empty($uteam_website) ){?> 
                            <div class="contact-info">
                              <ul>
                                    <?php if($uteam_email): ?>
                                         <li><i class="fa fa-envelope"></i><span><a href="mailto:<?php echo esc_attr($uteam_email);?>"><?php echo esc_html($uteam_email);?></a></span> </li>
                                     <?php endif;?>

                                     <?php if($uteam_website): ?>
                                         <li><i class="fa fa-globe"></i><span><a href="<?php echo esc_url($uteam_website); ?>" target="_blank"><?php echo esc_url($uteam_website); ?></a></span> </li>
                                     <?php endif; ?>

                                     <?php if($uteam_phone): ?>
                                         <li><i class="fa fa-phone"></i><span><?php echo esc_html($uteam_phone);?></span></li>
                                     <?php endif; ?>

                                     <?php if($uteam_address): ?>
                                         <li><i class="fa fa-map-marker"></i><span><?php echo esc_html($uteam_address);?></span></li>
                                     <?php endif; ?>                              
                                
                                </ul>
                            </div>
                    <?php } ?>
                </div>


                <?php  
                   if( get_the_content()):?>
                        <div class="single-member-bio">
                          <?php the_content(); ?>
                        </div>

                    <?php endif;?>
                       
              </div>
            </div>
        <?php endwhile; ?>
        </div>  
    </div>  
</div>

<?php
$s_template_p_t_b = isset($settings_options['s_template_p_t_b']) ? $settings_options['s_template_p_t_b'] : '80px';

if( !empty(  $s_template_p_t_b ) ){
    ?>
    <style>
    .single-member{
        padding: <?php echo esc_html( $s_template_p_t_b ); ?>  0;
        overflow-x: hidden;
    }
    </style>
    <?php
}
?>

<?php
get_footer();