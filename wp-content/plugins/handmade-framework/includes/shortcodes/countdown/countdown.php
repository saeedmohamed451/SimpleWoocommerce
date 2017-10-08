<?php
if ( ! defined( 'ABSPATH' ) ) die( '-1' );
if(!class_exists('g5plusFramework_Shortcode_Countdown')){
    class g5plusFramework_Shortcode_Countdown {
        function __construct() {
            add_action( 'init', array($this, 'register_post_types' ), 6 );
            add_shortcode('handmade_countdown_shortcode', array($this, 'handmade_countdown_shortcode' ));
            add_filter( 'rwmb_meta_boxes', array($this,'handmade_register_meta_boxes' ));
        }

        function register_post_types() {
            if ( post_type_exists('countdown') ) {
                return;
            }
            register_post_type('countdown',
                array(
                    'label' => esc_html__('Countdown','g5plus-handmade'),
                    'description' => esc_html__( 'Countdown Description', 'g5plus-handmade' ),
                    'labels' => array(
                        'name'					=>'Countdown',
                        'singular_name' 		=> 'Countdown',
                        'menu_name'    			=> esc_html__( 'Countdown', 'g5plus-handmade' ),
                        'parent_item_colon'  	=> esc_html__( 'Parent Item:', 'g5plus-handmade' ),
                        'all_items'          	=> esc_html__( 'All Countdown', 'g5plus-handmade' ),
                        'view_item'          	=> esc_html__( 'View Item', 'g5plus-handmade' ),
                        'add_new_item'       	=> esc_html__( 'Add New Countdown', 'g5plus-handmade' ),
                        'add_new'            	=> esc_html__( 'Add New', 'g5plus-handmade' ),
                        'edit_item'          	=> esc_html__( 'Edit Item', 'g5plus-handmade' ),
                        'update_item'        	=> esc_html__( 'Update Item', 'g5plus-handmade' ),
                        'search_items'       	=> esc_html__( 'Search Item', 'g5plus-handmade' ),
                        'not_found'          	=> esc_html__( 'Not found', 'g5plus-handmade' ),
                        'not_found_in_trash' 	=> esc_html__( 'Not found in Trash', 'g5plus-handmade' ),
                    ),
                    'supports'    => array( 'title', 'editor', 'comments', 'thumbnail'),
                    'public'      => true,
                    'menu_icon' => 'dashicons-clock',
                    'has_archive' => true
                )
            );
        }

        function handmade_countdown_shortcode($atts){

            global $g5plus_options;
            $min_suffix = (isset($g5plus_options['enable_minifile_js']) && $g5plus_options['enable_minifile_js'] == 1) ? '.min' : '';
            wp_enqueue_style('handmade-countdown-css', plugins_url() . '/handmade-framework/includes/shortcodes/countdown/assets/css/countdown'.$min_suffix.'.css', array(),false);

            $type = $css = $fore_color = '';
            extract( shortcode_atts( array(
                'type'     => 'comming-soon',
                'fore_color' => '',
                'css'      => ''
            ), $atts ) );

            $plugin_path =  untrailingslashit( plugin_dir_path( __FILE__ ) );
            $template_path = $plugin_path . '/templates/'.$type.'.php';
            ob_start();
            include($template_path);
            $ret = ob_get_contents();
            ob_end_clean();
            return $ret;
        }

        function handmade_register_meta_boxes($meta_boxes){
            $meta_boxes[] = array(
                'title'  => esc_html__( 'Countdown Option', 'g5plus-handmade' ),
                'id'     => 'handmade-meta-box-countdown-opening',
                'pages'  => array( 'countdown' ),
                'fields' => array(
                    array(
                        'name' => esc_html__( 'Opening hours', 'g5plus-handmade' ),
                        'id'   => 'countdown-opening',
                        'type' => 'datetime',
                    ),
                     array(
                         'name' => esc_html__( 'Type', 'g5plus-handmade' ),
                         'id'   => 'countdown-type',
                         'type' => 'select',
                         'options'  => array(
                             'comming-soon' => esc_html__('Coming Soon','g5plus-handmade'),
                             'under-construction' => esc_html__('Under Construction','g5plus-handmade')
                         )
                     ),
                    array(
                        'name' => esc_html__( 'Url redirect (after countdown completed)', 'g5plus-handmade' ),
                        'id'   => 'countdown-url',
                        'type' => 'textarea',
                    )
                )
            );
            return $meta_boxes;
        }
    }
    new g5plusFramework_Shortcode_Countdown();
}