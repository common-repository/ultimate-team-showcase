<?php

    add_action( 'admin_menu', 'uteam_create_admin_page' );
    add_action( 'admin_init', 'uteam_settings_page_general' );
    add_action( 'admin_init', 'uteam_settings_url_rewrite' );
    add_action( 'admin_init', 'uteam_settings_page_ed_css' );
    add_action( 'admin_init', 'uteam_settings_page_ed_js' );

	function uteam_create_admin_page(){
		$page_title = __( 'Settings', 'ultimate-team-showcase' );
		$menu_title = __( 'Settings', 'ultimate-team-showcase' );
		$capability = 'manage_options';
		$slug       = 'uteamsettings';
		$callback   = 'uteam_page_content';
		add_submenu_page( 'edit.php?post_type=wp_uteam',$page_title, $menu_title, $capability, $slug, $callback );
	}

    function uteam_page_content() {
		$settings_options = get_option( 'uteam_settings_option' ); ?>

		<div class="wrap">

			<?php settings_errors(); ?>

            <?php include 'header.php'; ?>

            <form method="post" action="options.php" class="utem-form">
                <div class="uteam-setting-container">
                    <div id="uteam-setting-tabs" class="uteam-setting-tabs">
                        <ul>
                            <li><a href="#tabs-1"><?php esc_html_e( 'General', 'ultimate-team-showcase' );?></a></li>
                            <li><a href="#tabs-rewrite"><?php esc_html_e( 'URL Rewrite', 'ultimate-team-showcase' );?></a></li>
                            <li><a href="#tabs-2"><?php esc_html_e( 'Enable/Disable CSS', 'ultimate-team-showcase' );?></a></li>
                            <li><a href="#tabs-3"><?php esc_html_e( 'Enable/Disable JS', 'ultimate-team-showcase' );?></a></li>
                            <li><a href="#tabs-4"><?php esc_html_e( 'Overview', 'ultimate-team-showcase' );?></a></li>
                        </ul>
                        <div id="tabs-1" class="ui-tabs-panel">
                            <?php
                            settings_fields( 'uteam_settings_option_group' );
                            do_settings_sections( 'uteam-settings-admin' );
                            submit_button();
                            ?>
                        </div>
                        <div id="tabs-rewrite" class="ui-tabs-panel">
                            
                            <?php
                            settings_fields( 'uteam_settings_option_url_rewrite' );
                            do_settings_sections( 'uteam-settings-admin-url_rewrite' );
                            submit_button();
                            ?>
                        </div>
                        <div id="tabs-2" class="ui-tabs-panel ui-tabs-hide">
                            <?php
                            settings_fields( 'uteam_settings_option_group_ed_css' );
                            do_settings_sections( 'uteam-settings-admin-ed_css' );
                            submit_button();
                            ?>
                        </div>
                        <div id="tabs-3" class="ui-tabs-panel ui-tabs-hide">
                            <?php
                            settings_fields( 'uteam_settings_option_group_ed_js' );
                            do_settings_sections( 'uteam-settings-admin-ed_js' );
                            submit_button();
                            ?>

                        </div>
                        <div id="tabs-4" class="ui-tabs-panel ui-tabs-hide">
                            <?php $settings_options = get_option( 'uteam_settings_option' ); ?>
                            <table class="uteam-setting-tabs-overview">
                                <tr>
                                    <th><?php esc_html_e( 'Features', 'ultimate-team-showcase' ); ?></th>
                                    <th><?php esc_html_e( 'Status', 'ultimate-team-showcase' ); ?></th>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e( 'Primary Color', 'ultimate-team-showcase' ); ?></td>
                                    <td>
                                        <div style="background-color: <?php uteam_settings_option_field( 'primary_color_0' ); ?>; width: 50px; height: 20px"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e( 'Secondary Color', 'ultimate-team-showcase' ); ?></td>
                                    <td>
                                        <div style="background-color: <?php uteam_settings_option_field( 'secondary_color_1' ); ?>; width: 50px; height: 20px"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e( 'Select Single Template', 'ultimate-team-showcase' ); ?></td>
                                    <td>
                                        <?php uteam_settings_option_field( 'select_single_template_2' ); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e( 'Single Template Padding Top/Bottom', 'ultimate-team-showcase' ); ?></td>
                                    <td>
                                        <?php uteam_settings_option_field( 's_template_p_t_b' ); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e( 'Disable Details Page', 'ultimate-team-showcase' ); ?></td>
                                    <td>
                                        <?php uteam_settings_option_field( 'details_page_enable_3' ); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e( 'Disable Boostrap CSS', 'ultimate-team-showcase' ); ?></td>
                                    <td>
                                        <?php uteam_settings_option_field( 'plugin_bootstrap_library_disable' ); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e( 'Disable Fontawesome CSS', 'ultimate-team-showcase' ); ?></td>
                                    <td>
                                        <?php uteam_settings_option_field( 'plugin_fontawesome_library_disable' ); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e( 'Disable owl carousel CSS', 'ultimate-team-showcase' ); ?></td>
                                    <td>
                                        <?php uteam_settings_option_field( 'plugin_owl_library_disable' ); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e( 'Disable FlexSlider CSS', 'ultimate-team-showcase' ); ?></td>
                                    <td>
                                        <?php uteam_settings_option_field( 'plugin_flex_library_disable' ); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e( 'Disable magnific popup CSS', 'ultimate-team-showcase' ); ?></td>
                                    <td>
                                        <?php uteam_settings_option_field( 'plugin_magnific_library_disable' ); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e( 'Disable Isotope JS', 'ultimate-team-showcase' ); ?></td>
                                    <td>
                                        <?php uteam_settings_option_field( 'plugin_isotope_library_disable_js' ); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e( 'Disable owl carousel JS', 'ultimate-team-showcase' ); ?></td>
                                    <td>
                                        <?php uteam_settings_option_field( 'plugin_owl_library_disable_js' ); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e( 'Disable FlexSlider JS', 'ultimate-team-showcase' ); ?></td>
                                    <td>
                                        <?php uteam_settings_option_field( 'plugin_flex_library_disable_js' ); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php esc_html_e( 'Disable magnific popup JS', 'ultimate-team-showcase' ); ?></td>
                                    <td>
                                        <?php uteam_settings_option_field( 'plugin_magnific_library_disable_js' ); ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <?php include 'sidebar.php'; ?>
                </div>

			</form>

            <?php include 'footer.php'; ?>
		</div>

	<?php }

    function uteam_settings_option_field( $settings_field_id ){
        $settings_options = get_option( 'uteam_settings_option' );
        if( isset( $settings_options[ $settings_field_id ] ) ){
            $settings_option_field = $settings_options[ $settings_field_id ];
        }
        if( !empty( $settings_option_field ) ){
            echo esc_html( $settings_option_field );
        }
        else{
            esc_html_e( 'Not Selected', 'ultimate-team-showcase' );
        }
    }

	function uteam_settings_page_general() {
		register_setting(
			'uteam_settings_option_group', // option_group
			'uteam_settings_option', // option_name
			//array( $this, 'settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'uteam_setting_section',
			'',
			'settings_section_info',
			'uteam-settings-admin'
		);

		add_settings_field(
			'primary_color_0',
			esc_html__( 'Primary Color', 'ultimate-team-showcase' ),
			'primary_color_0_callback',
			'uteam-settings-admin',
			'uteam_setting_section'
		);

		add_settings_field(
			'secondary_color_1',
			esc_html__( 'Secondary Color', 'ultimate-team-showcase' ),
			'secondary_color_1_callback',
			'uteam-settings-admin',
			'uteam_setting_section'
		);

		add_settings_field(
			'select_single_template_2',
			esc_html__( 'Select Single Template', 'ultimate-team-showcase' ),
			'select_single_template_2_callback',
			'uteam-settings-admin',
			'uteam_setting_section'
		);

		add_settings_field(
			'single_template_p_t_b',
			esc_html__( 'Single Template Padding Top/Bottom', 'ultimate-team-showcase' ),
			'single_template_p_t_b_callback',
			'uteam-settings-admin',
			'uteam_setting_section'
		);

		add_settings_field(
			'details_page_enable_3',
			esc_html__( 'Disable Details Page', 'ultimate-team-showcase' ),
			'details_page_enable_3_callback',
			'uteam-settings-admin',
			'uteam_setting_section'
		);

	}

	function settings_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['primary_color_0'] ) ) {
			$sanitary_values['primary_color_0'] = sanitize_text_field( $input['primary_color_0'] );
		}

		if ( isset( $input['secondary_color_1'] ) ) {
			$sanitary_values['secondary_color_1'] = sanitize_text_field( $input['secondary_color_1'] );
		}

		if ( isset( $input['select_single_template_2'] ) ) {
			$sanitary_values['select_single_template_2'] = $input['select_single_template_2'];
		}

		if ( isset( $input['details_page_enable_3'] ) ) {
			$sanitary_values['details_page_enable_3'] = $input['details_page_enable_3'];
		}
        
        if ( isset( $input['uteam_url_rewrite'] ) ) {
			$sanitary_values['uteam_url_rewrite'] = $input['uteam_url_rewrite'];
		}

		return $sanitary_values;
	}

	function settings_section_info() {}

	function primary_color_0_callback() {
        $settings_options = get_option( 'uteam_settings_option' );
		printf(
			'<input class="regular-text-color" type="text" name="uteam_settings_option[primary_color_0]" id="primary_color_0" value="%s">',
			isset( $settings_options['primary_color_0'] ) ? esc_attr( $settings_options['primary_color_0']) : ''
		);
	}

	function secondary_color_1_callback() {
        $settings_options = get_option( 'uteam_settings_option' );
		printf(
			'<input class="regular-text-color" type="text" name="uteam_settings_option[secondary_color_1]" id="secondary_color_1" value="%s">',
			isset( $settings_options['secondary_color_1'] ) ? esc_attr( $settings_options['secondary_color_1']) : ''
		);
	}

	function select_single_template_2_callback() {
        $settings_options = get_option( 'uteam_settings_option' );
		?> <select name="uteam_settings_option[select_single_template_2]" id="select_single_template_2">
            <?php $selected = (isset( $settings_options['select_single_template_2'] ) && $settings_options['select_single_template_2'] === 'theme') ? 'selected' : '' ; ?>
            <option value="theme" <?php echo esc_attr( $selected ); ?>><?php esc_html_e( 'From Theme', 'ultimate-team-showcase' );?></option>
			<?php $selected = (isset( $settings_options['select_single_template_2'] ) && $settings_options['select_single_template_2'] === 'plugin') ? 'selected' : '' ; ?>
			<option value="plugin" <?php echo esc_attr( $selected ); ?>><?php esc_html_e( 'From Plugin', 'ultimate-team-showcase' ); ?></option>
			
		</select> <?php
	}

    function single_template_p_t_b_callback(){
        $settings_options = get_option( 'uteam_settings_option' );
		printf(
			'<label class="">
                <input type="text" name="uteam_settings_option[s_template_p_t_b]" id="s_template_p_t_b" value="%s">
                    </label>',
            isset($settings_options['s_template_p_t_b']) ? esc_attr($settings_options['s_template_p_t_b']) : '80px'
		);
    }

	function details_page_enable_3_callback() {
        $settings_options = get_option( 'uteam_settings_option' );
		printf(
			'<label class="switch-rs-settings"><input type="checkbox" name="uteam_settings_option[details_page_enable_3]" id="details_page_enable_3" value="details_page_disable" %s> <div class="slider-rs round"></div>
                    </label>',
			( isset( $settings_options['details_page_enable_3'] ) && $settings_options['details_page_enable_3'] === 'details_page_disable' ) ? 'checked' : ''
		);

	}

	function uteam_url_rewrite_callback() {
        $settings_options = get_option( 'uteam_settings_option' );
		printf(
			'<label class="rs_pro_only">
                <input type="text" name="uteam_settings_option[uteam_url_rewrite]" id="uteam_url_rewrite" value="%s">
                    </label>',
            isset($settings_options['uteam_url_rewrite']) ? esc_attr($settings_options['uteam_url_rewrite']) : 'wp_uteam'
		);
	}

	function uteam_taxonomy_rewrite_callback() {
        $settings_options = get_option( 'uteam_settings_option' );
		printf(
			'<label class="rs_pro_only">
                <input type="text" name="uteam_settings_option[uteam_taxonomy_rewrite]" id="uteam_taxonomy_rewrite" value="%s">
                    </label>',
            isset($settings_options['uteam_taxonomy_rewrite']) ? esc_attr($settings_options['uteam_taxonomy_rewrite']) : 'wp-uteam-category'
		);
	}
    
    function uteam_cat_title_rewrite_callback() {
        $settings_options = get_option( 'uteam_settings_option' );
		printf(
			'<label class="rs_pro_only">
                <input type="text" name="uteam_settings_option[uteam_cat_title_rewrite]" id="uteam_cat_title_rewrite" value="%s">
                    </label>',
            isset($settings_options['uteam_cat_title_rewrite']) ? esc_attr($settings_options['uteam_cat_title_rewrite']) : 'Team Categories'
		);
	}

    /**
     * 
     */
    function uteam_settings_url_rewrite(){
        register_setting(
            'uteam_settings_option_url_rewrite',
            'uteam_settings_option',
        );

        add_settings_section(
            'uteam_setting_section',
            '',
            'settings_section_info',
            'uteam-settings-admin-url_rewrite'
        );

        add_settings_field(
			'uteam_url_rewrite',
			esc_html__( 'Team Slug Rewrite', 'ultimate-team-showcase' ),
			'uteam_url_rewrite_callback',
			'uteam-settings-admin-url_rewrite',
			'uteam_setting_section'
		);

        add_settings_field(
			'uteam_taxonomy_rewrite',
			esc_html__( 'Taxonomy Slug Rewrite', 'ultimate-team-showcase' ),
			'uteam_taxonomy_rewrite_callback',
			'uteam-settings-admin-url_rewrite',
			'uteam_setting_section'
		);
        
        add_settings_field(
			'uteam_cat_title_rewrite',
			esc_html__( 'Change category label', 'ultimate-team-showcase' ),
			'uteam_cat_title_rewrite_callback',
			'uteam-settings-admin-url_rewrite',
			'uteam_setting_section'
		);
    }

    /*
     * Enable/Disable CSS
     * */
    function uteam_settings_page_ed_css() {
        register_setting(
            'uteam_settings_option_group_ed_css',
            'uteam_settings_option',
        //array( $this, 'settings_sanitize' )
        );

        add_settings_section(
            'uteam_setting_section',
            '',
            'settings_section_info',
            'uteam-settings-admin-ed_css'
        );
        add_settings_field(
            'plugin_bootstrap_library_disable',
            esc_html__( 'Disable Boostrap CSS', 'ultimate-team-showcase' ),
            'plugin_bootstrap_library_disable_callback',
            'uteam-settings-admin-ed_css',
            'uteam_setting_section'
        );
        add_settings_field(
            'plugin_fontawesome_library_disable',
            esc_html__( 'Disable Fontawesome CSS', 'ultimate-team-showcase' ),
            'plugin_fontawesome_library_disable_callback',
            'uteam-settings-admin-ed_css',
            'uteam_setting_section'
        );

        add_settings_field(
            'plugin_owl_library_disable',
            esc_html__( 'Disable owl carousel CSS', 'ultimate-team-showcase' ),
            'plugin_owl_library_disable_callback',
            'uteam-settings-admin-ed_css',
            'uteam_setting_section'
        );
        add_settings_field(
            'plugin_flex_library_disable',
            esc_html__( 'Disable FlexSlider CSS', 'ultimate-team-showcase' ),
            'plugin_flex_library_disable_callback',
            'uteam-settings-admin-ed_css',
            'uteam_setting_section'
        );

        add_settings_field(
            'plugin_magnific_library_disable',
            esc_html__( 'Disable magnific popup CSS', 'ultimate-team-showcase' ),
            'plugin_magnific_library_disable_callback',
            'uteam-settings-admin-ed_css',
            'uteam_setting_section'
        );
    }

    function plugin_bootstrap_library_disable_callback() {
        $settings_options = get_option( 'uteam_settings_option' );
        printf('
			<label class="switch-rs-settings"><input type="checkbox" name="uteam_settings_option[plugin_bootstrap_library_disable]" id="plugin_bootstrap_library_disable" value="bootstrap_css" %s> <div class="slider-rs round"></div>
            </label>',
            ( isset( $settings_options['plugin_bootstrap_library_disable'] ) && $settings_options['plugin_bootstrap_library_disable'] === 'bootstrap_css' ) ? 'checked' : ''
        );
    }

    function plugin_fontawesome_library_disable_callback() {
        $settings_options = get_option( 'uteam_settings_option' );
        printf('
			<label class="switch-rs-settings"><input type="checkbox" name="uteam_settings_option[plugin_fontawesome_library_disable]" id="plugin_fontawesome_library_disable" value="fontawesome" %s> <div class="slider-rs round"></div>
            </label>',
            ( isset( $settings_options['plugin_fontawesome_library_disable'] ) && $settings_options['plugin_fontawesome_library_disable'] === 'fontawesome' ) ? 'checked' : ''
        );
       
    }

    function plugin_owl_library_disable_callback() {
        $settings_options = get_option( 'uteam_settings_option' );
        printf('
			<label class="switch-rs-settings"><input type="checkbox" name="uteam_settings_option[plugin_owl_library_disable]" id="plugin_owl_library_disable" value="owl" %s> <div class="slider-rs round"></div>
            </label>',
            ( isset( $settings_options['plugin_owl_library_disable'] ) && $settings_options['plugin_owl_library_disable'] === 'owl' ) ? 'checked' : ''
        );
    }

    function plugin_flex_library_disable_callback() {
        $settings_options = get_option( 'uteam_settings_option' );
        printf('
			<label class="switch-rs-settings"><input type="checkbox" name="uteam_settings_option[plugin_flex_library_disable]" id="plugin_flex_library_disable" value="flex" %s> <div class="slider-rs round"></div>
            </label>',
            ( isset( $settings_options['plugin_flex_library_disable'] ) && $settings_options['plugin_flex_library_disable'] === 'flex' ) ? 'checked' : ''
        );
    }

    function plugin_magnific_library_disable_callback() {
        $settings_options = get_option( 'uteam_settings_option' );
        printf('
			<label class="switch-rs-settings"><input type="checkbox" name="uteam_settings_option[plugin_magnific_library_disable]" id="plugin_magnific_library_disable" value="magnific" %s> <div class="slider-rs round"></div>
            </label>',
            ( isset( $settings_options['plugin_magnific_library_disable'] ) && $settings_options['plugin_magnific_library_disable'] === 'magnific' ) ? 'checked' : ''
        );
    }

    /*
     * Enable/Disable JS
     * */
    function uteam_settings_page_ed_js(){
        register_setting(
            'uteam_settings_option_group_ed_js',
            'uteam_settings_option',
        
        );

        add_settings_section(
            'uteam_setting_section',
            '',
            'settings_section_info',
            'uteam-settings-admin-ed_js'
        );


        add_settings_field(
            'plugin_isotope_library_disable_js',
            esc_html__( 'Disable Isotope JS', 'ultimate-team-showcase' ),
            'plugin_isotope_library_disable_callback_js',
            'uteam-settings-admin-ed_js',
            'uteam_setting_section'
        );

        add_settings_field(
            'plugin_owl_library_disable_js',
            esc_html__( 'Disable owl carousel JS', 'ultimate-team-showcase' ),
            'plugin_owl_library_disable_callback_js',
            'uteam-settings-admin-ed_js',
            'uteam_setting_section'
        );
        add_settings_field(
            'plugin_flex_library_disable_js',
            esc_html__( 'Disable FlexSlider JS', 'ultimate-team-showcase' ),
            'plugin_flex_library_disable_callback_js',
            'uteam-settings-admin-ed_js',
            'uteam_setting_section'
        );

        add_settings_field(
            'plugin_magnific_library_disable_js',
            esc_html__( 'Disable magnific popup JS', 'ultimate-team-showcase' ),
            'plugin_magnific_library_disable_callback_js',
            'uteam-settings-admin-ed_js',
            'uteam_setting_section'
        );
    }

    function plugin_isotope_library_disable_callback_js() {
        $settings_options = get_option( 'uteam_settings_option' );
        printf('
			<label class="switch-rs-settings"><input type="checkbox" name="uteam_settings_option[plugin_isotope_library_disable_js]" id="plugin_isotope_library_disable_js" value="isotope_js" %s> <div class="slider-rs round"></div>
            </label>',
            ( isset( $settings_options['plugin_isotope_library_disable_js'] ) && $settings_options['plugin_isotope_library_disable_js'] === 'isotope_js' ) ? 'checked' : ''
        );
    }

    function plugin_owl_library_disable_callback_js() {
        $settings_options = get_option( 'uteam_settings_option' );
        printf('
			<label class="switch-rs-settings"><input type="checkbox" name="uteam_settings_option[plugin_owl_library_disable_js]" id="plugin_owl_library_disable_js" value="owl" %s> <div class="slider-rs round"></div>
            </label>',
            ( isset( $settings_options['plugin_owl_library_disable_js'] ) && $settings_options['plugin_owl_library_disable_js'] === 'owl' ) ? 'checked' : ''
        );
    }

    function plugin_flex_library_disable_callback_js() {
        $settings_options = get_option( 'uteam_settings_option' );
        printf('
			<label class="switch-rs-settings"><input type="checkbox" name="uteam_settings_option[plugin_flex_library_disable_js]" id="plugin_flex_library_disable_js" value="flex" %s> <div class="slider-rs round"></div>
            </label>',
            ( isset( $settings_options['plugin_flex_library_disable_js'] ) && $settings_options['plugin_flex_library_disable_js'] === 'flex' ) ? 'checked' : ''
        );
    }

    function plugin_magnific_library_disable_callback_js() {
        $settings_options = get_option( 'uteam_settings_option' );
        printf('
			<label class="switch-rs-settings"><input type="checkbox" name="uteam_settings_option[plugin_magnific_library_disable_js]" id="plugin_magnific_library_disable_js" value="magnific" %s> <div class="slider-rs round"></div>
            </label>',
            ( isset( $settings_options['plugin_magnific_library_disable_js'] ) && $settings_options['plugin_magnific_library_disable_js'] === 'magnific' ) ? 'checked' : ''
        );
    }

