<?php
add_action('elementor/widgets/widgets_registered', function () {
    class Ultimate_Team_Elementor_Post_Widget extends \Elementor\Widget_Base {
        public function get_name() {
            return 'uteam-elementor-post-widget';
        }
        public function get_title() {
            return __('WP Ultimate team', 'ultimate-team-showcase');
        }
        public function get_icon() {
            return 'eicon-person'; 
        }
        

        public function get_categories() {
            return array( 'basic' );
        }

        public function wp_uteam_post_list() {
            $post_list  = array();
            $uteam_posts = new \WP_Query(
                array(
                    'post_type'      => 'wp_uteam_settings',
                    'post_status'    => 'publish',
                    'posts_per_page' => 9999,
                )
            );
            $posts      = $uteam_posts->posts;
            foreach ( $posts as $post ) {
                $post_list[ $post->ID ] = $post->post_title;
            }
            krsort( $post_list );
            return $post_list;
        }


        /**
         * Controls register.
         *
         * @return void
         */
        protected function register_controls() {
            $this->start_controls_section(
                'content_section',
                array(
                    'label' => __( 'Content', 'ultimate-team-showcase' ),
                    'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                )
            );

            $this->add_control(
                'wp_ultimate_team_pro_shortcode',
                array(
                    'label'       => __( 'WP Ultimate Team Shortcode(s)', 'ultimate-team-showcase' ),
                    'type'        => \Elementor\Controls_Manager::SELECT2,
                    'label_block' => true,
                    'default'     => '',
                    'options'     => $this->wp_uteam_post_list(),
                )
            );

            $this->end_controls_section();

        }

        protected function render() {
            $settings       = $this->get_settings_for_display();
            $uteam_shortcode = $settings['wp_ultimate_team_pro_shortcode'];

            if ('' === $uteam_shortcode) {
                echo '<div style="text-align: center; margin-top: 0; padding: 10px" class="elementor-add-section-drag-title">Select a shortcode</div>';
                return;
            }

            $generator_id = (int) esc_attr($uteam_shortcode);

            if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {

                // Render the shortcode for a live preview.
                echo do_shortcode('[wp_ultimate_team_shortcode id="' . $generator_id . '"]');        
            }
            else {
            // Render the shortcode on the frontend.
            echo do_shortcode('[wp_ultimate_team_shortcode id="' . $generator_id . '"]');
            }
        }

    }
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Ultimate_Team_Elementor_Post_Widget());
});