(function($){  
    "use strict";
    $('.regular-text-color').wpColorPicker();
    $( "#uteam-setting-tabs" ).tabs();

    $(document).ready( function(){
        /**
         * Select team layout
         */
        $('#uteam_team_select').on( 'click', function (){
            $('#uteam_team_select option[value=light]').attr( 'disabled', 'disabled' );
            $('#uteam_team_select option[value=isotope]').attr( 'disabled', 'disabled' );
            $('#uteam_team_select option[value=list]').attr( 'disabled', 'disabled' );
            $('#uteam_team_select option[value=flip]').attr( 'disabled', 'disabled' );
        });
        /**
         * Team per page
         */
        $('#uteam_team_per_page').on( 'click', function(){
            $( 'input[name=uteam_team_per_page]' ).attr( 'disabled', 'disabled' );
        });
        
        /**
         * Ordering
         */
        $('#uteam_team_order').on( 'click', function(){
            $("#uteam_team_order option[value=ASC]").attr('disabled','disabled');
            $("#uteam_team_order option[value=DESC]").attr('disabled','disabled');
            $("#uteam_team_order option[value=select]").attr('selected','selected');
        });
        /**
         * Select Column
         */
        $( '#uteam_team_grid_colum' ).on( 'click', function (){
            $('#uteam_team_grid_colum option[value=select]').attr('selected','selected');
            $('#uteam_team_grid_colum option[value=6]').attr('disabled','disabled');
            $('#uteam_team_grid_colum option[value=4]').attr('selected','selected');
            $('#uteam_team_grid_colum option[value=3]').attr('disabled','disabled');
        });

        /**
         * Select Column
         */
        $( '#uteam_team_light_column' ).on( 'click', function (){
            $('#uteam_team_light_column option[value=select]').attr('selected','selected');
            $('#uteam_team_light_column option[value=6]').attr('disabled','disabled');
            $('#uteam_team_light_column option[value=4]').attr('disabled','disabled');
            $('#uteam_team_light_column option[value=3]').attr('disabled','disabled');
        });

        /**
         * Select pagination
         */
        $( '#uteam_team_pagination' ).on( 'click', function (){
            $('#uteam_team_pagination option[value=select]').attr('disabled','disabled');
            $('#uteam_team_pagination option[value=false]').attr('disabled','disabled');
            $('#uteam_team_pagination option[value=true]').attr('disabled','disabled');
        });
        /**
         * Slider Setting Tab
         */

        /**
         * Number of columns ( Desktops > 991px
         */
        $( '#uteam_cl-md' ).on( 'click', function (){
            $( '#uteam_cl-md option[value=1]' ).prop( 'disabled', true );
            $( '#uteam_cl-md option[value=2]' ).prop( 'disabled', true );
            $( '#uteam_cl-md option[value=3]' ).prop( 'disabled', true );
            $( '#uteam_cl-md option[value=4]' ).prop( 'disabled', true );
            $( '#uteam_cl-md option[value=5]' ).prop( 'disabled', true );
            $( '#uteam_cl-md option[value=6]' ).prop( 'disabled', true );
        });

        /**
         * Number of columns ( Tablets < 768px
         */
        $( '#uteam_cl-xs' ).on( 'click', function (){
            $( '#uteam_cl-xs option[value=1]' ).prop( 'disabled', true );
            $( '#uteam_cl-xs option[value=2]' ).prop( 'disabled', true );
            $( '#uteam_cl-xs option[value=3]' ).prop( 'disabled', true );
            $( '#uteam_cl-xs option[value=4]' ).prop( 'disabled', true );
            $( '#uteam_cl-xs option[value=5]' ).prop( 'disabled', true );
            $( '#uteam_cl-xs option[value=6]' ).prop( 'disabled', true );
        });

        /**
         * Navigation Dots
         */
        $( '#uteam_slider_dots' ).on( 'click', function (){
            $( '#uteam_slider_dots option[value=false]' ).attr( 'disabled', 'disabled' );
            $( '#uteam_slider_dots option[value=true]' ).attr( 'disabled', 'disabled' );
        });
        /**
         * Navigation Arrow
         */
        $( '#uteam_slider_nav' ).on( 'click', function (){
            $( '#uteam_slider_nav option[value=false]' ).attr( 'disabled', 'disabled' );
            $( '#uteam_slider_nav option[value=true]' ).attr( 'disabled', 'disabled' );
        });
        /**
         * Autoplay
         */
        $( '#uteam_slider_autoplay' ).on( 'click', function (){
            $( '#uteam_slider_autoplay option[value=false]' ).attr( 'disabled', 'disabled' );
            $( '#uteam_slider_autoplay option[value=true]' ).attr( 'disabled', 'disabled' );
        });
        /**
         * Stop on Hover
         */
        $( '#uteam_slider_stop_on_hover' ).on( 'click', function (){
            $( '#uteam_slider_stop_on_hover option[value=false]' ).attr( 'disabled', 'disabled' );
            $( '#uteam_slider_stop_on_hover option[value=true]' ).attr( 'disabled', 'disabled' );
        });
        /**
         * Autoplay Interval
         */
        $( '#uteam_slider_interval' ).on( 'click', function (){
            $( '#uteam_slider_interval option[value=1000]' ).attr( 'disabled', 'disabled' );
            $( '#uteam_slider_interval option[value=2000]' ).attr( 'disabled', 'disabled' );
            $( '#uteam_slider_interval option[value=3000]' ).attr( 'disabled', 'disabled' );
            $( '#uteam_slider_interval option[value=4000]' ).attr( 'disabled', 'disabled' );
            $( '#uteam_slider_interval option[value=5000]' ).attr( 'disabled', 'disabled' );
        });

        /**
         * Filter setting tab
         */
        /**
         * Filter Text
         */
        $( '#uteam_filter_text' ).on( 'click', function (){
            $( 'input[name=uteam_filter_text]' ).attr( 'disabled', 'disabled' );
        });
        /**
         * Filter Align
         */
        $( '#uteam_filter-align' ).on( 'click', function (){
            $( '#uteam_filter-align option[value=left]' ).attr( 'disabled', 'disabled' );
            $( '#uteam_filter-align option[value=center]' ).attr( 'disabled', 'disabled' );
            $( '#uteam_filter-align option[value=right]' ).attr( 'disabled', 'disabled' );
        });
        /**
         * Select Column
         */
        $( '#uteam_isotope_grid_colum' ).on( 'click', function (){
            $( '#uteam_isotope_grid_colum option[value=6]' ).attr( 'disabled', 'disabled' );
            $( '#uteam_isotope_grid_colum option[value=4]' ).attr( 'disabled', 'disabled' );
            $( '#uteam_isotope_grid_colum option[value=3]' ).attr( 'disabled', 'disabled' );
        });
        /**
         * Autoplay Slide Speed
         */
        $( '#uteam_slider_autoplay_speed' ).on( 'click', function (){
            $( 'input[name=uteam_slider_autoplay_speed]' ).attr( 'disabled', 'disabled' );
        });
        /**
         * Loop
         */
        $( '#uteam_slider_loop' ).on( 'click', function (){
            $( '#uteam_slider_loop option[value=false]' ).attr( 'disabled', 'disabled' );
            $( '#uteam_slider_loop option[value=true]' ).attr( 'disabled', 'disabled' );
        });

        //  List Style
        $( '#uteam_team_list_style' ).on( 'click', function (){
            $( '#uteam_team_list_style option[value=style1]' ).attr( 'disabled', 'disabled' );
        });

        //  List Style
        $( '#uteam_team_isotope_style' ).on( 'click', function (){
            $( '#uteam_team_isotope_style option[value=style1]' ).attr( 'disabled', 'disabled' );
        }); 

        //Flip Style
        $( '#uteam_team_flip_style' ).on( 'click', function (){
            $( '#uteam_team_flip_style option[value=style1]' ).attr( 'disabled', 'disabled' );
        });  
        //LightBox Style
        $( '#uteam_team_light_style' ).on( 'click', function (){
            $( '#uteam_team_light_style option[value=style1]' ).attr( 'disabled', 'disabled' );
            $( '#uteam_team_light_style option[value=style2]' ).attr( 'disabled', 'disabled' );
            $( '#uteam_team_light_style option[value=style3]' ).attr( 'disabled', 'disabled' );
            $( '#uteam_team_light_style option[value=style4]' ).attr( 'disabled', 'disabled' );
        });   
         
        
        /**
         * Select Column
         */
        $( '#uteam_team_flip_column' ).on( 'click', function (){
            $( '#uteam_team_flip_column option[value=6]' ).attr( 'disabled', 'disabled' );
            $( '#uteam_team_flip_column option[value=4]' ).attr( 'disabled', 'disabled' );
            $( '#uteam_team_flip_column option[value=3]' ).attr( 'disabled', 'disabled' );
        });

        /**
         * Member Style Tab
         */
        /**
         * Team Title Section Font Size
         */
        $( '#uteam_font_size_title' ).on( 'click', function (){
            $('input[name=uteam_font_size_title]').attr( 'disabled', 'disabled' );
        });
        /**
         * Team Designation Section Font Size
         */
        $( '#uteam_font_size_designation' ).on( 'click', function (){
            $('input[name=uteam_font_size_designation]').attr( 'disabled', 'disabled' );
        });
        /**
         * Short Description Section Font Size
         */
        $( '#uteam_short_dec_font_size' ).on( 'click', function (){
            $('input[name=uteam_short_dec_font_size]').attr( 'disabled', 'disabled' );
        });
        /**
         * Social Icon Section Font Size
         */
        $( '#uteam_sicon_font_size' ).on( 'click', function (){
            $('input[name=uteam_sicon_font_size]').attr( 'disabled', 'disabled' );
        });
        /**
         * Border Radius Font Size
         */
        $( '#uteam_sicon_border_radious' ).on( 'click', function (){
            $('input[name=uteam_sicon_border_radious]').attr( 'disabled', 'disabled' );
        });

        /**
         * Plugin setting page
         */
        //Team Slug Rewrite
        $( '.rs_pro_only' ).on( 'click', function (){
            $('#uteam_url_rewrite').prop( "disabled", true );
        });
        //Taxonomy Slug Rewrite
        $( '.rs_pro_only' ).on( 'click', function (){
            $('#uteam_taxonomy_rewrite').prop( "disabled", true );
        });
        //Change category label
        $( '.rs_pro_only' ).on( 'click', function (){
            $('#uteam_cat_title_rewrite').prop( "disabled", true );
        });
        //Disable Details Page
        $( '.switch-rs-settings' ).on( 'click', function (){
            $('#details_page_enable_3').prop( "disabled", true );
        });
        //Disable Boostrap CSS
        $( '.switch-rs-settings' ).on( 'click', function (){
            $('#plugin_bootstrap_library_disable').prop( "disabled", true );
        });
        //Disable Fontawesome CSS
        $( '.switch-rs-settings' ).on( 'click', function (){
            $('#plugin_fontawesome_library_disable').prop( "disabled", true );
        });
        //Disable owl carousel CSS
        $( '.switch-rs-settings' ).on( 'click', function (){
            $('#plugin_owl_library_disable').prop( "disabled", true );
        });
        //Disable FlexSlider CSS
        $( '.switch-rs-settings' ).on( 'click', function (){
            $('#plugin_flex_library_disable').prop( "disabled", true );
        });
        //Disable magnific popup CSS
        $( '.switch-rs-settings' ).on( 'click', function (){
            $('#plugin_magnific_library_disable').prop( "disabled", true );
        });
        //Disable Isotope JS
        $( '.switch-rs-settings' ).on( 'click', function (){
            $('#plugin_isotope_library_disable_js').prop( "disabled", true );
        });
        //Disable owl carousel JS
        $( '.switch-rs-settings' ).on( 'click', function (){
            $('#plugin_owl_library_disable_js').prop( "disabled", true );
        });
        //Disable FlexSlider JS
        $( '.switch-rs-settings' ).on( 'click', function (){
            $('#plugin_flex_library_disable_js').prop( "disabled", true );
        });
        //Disable magnific popup JS
        $( '.switch-rs-settings' ).on( 'click', function (){
            $('#plugin_magnific_library_disable_js').prop( "disabled", true );
        });

        /**
         * Memeber Basic Information
         */
        $( '#uteam_address' ).on( 'click', function (){
            $('input[name=uteam_address]').prop( 'disabled', true );
        });
        //
        $( '#uteam_description' ).on( 'click', function (){
            $('textarea[name=uteam_description]').prop( 'disabled', true );
        });

    });

})(jQuery);
