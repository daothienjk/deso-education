<?php
if ( ! defined( 'ABSPATH' ) ) die( '-1' );
if(!class_exists('g5plusFramework_Shortcode_Countdown')){
    class g5plusFramework_Shortcode_Countdown {
        function __construct() {
            add_action( 'init', array($this, 'register_post_types' ), 6 );
            add_shortcode('academia_countdown_shortcode', array($this, 'academia_countdown_shortcode' ));
            add_filter( 'rwmb_meta_boxes', array($this,'academia_register_meta_boxes' ));
        }

        function register_post_types() {
            if ( post_type_exists('countdown') ) {
                return;
            }
            register_post_type('countdown',
                array(
                    'label' => esc_html__('Countdown','g5plus-academia'),
                    'description' => esc_html__( 'Countdown Description', 'g5plus-academia' ),
                    'labels' => array(
                        'name'					=>'Countdown',
                        'singular_name' 		=> 'Countdown',
                        'menu_name'    			=> esc_html__( 'Countdown', 'g5plus-academia' ),
                        'parent_item_colon'  	=> esc_html__( 'Parent Item:', 'g5plus-academia' ),
                        'all_items'          	=> esc_html__( 'All Countdown', 'g5plus-academia' ),
                        'view_item'          	=> esc_html__( 'View Item', 'g5plus-academia' ),
                        'add_new_item'       	=> esc_html__( 'Add New Countdown', 'g5plus-academia' ),
                        'add_new'            	=> esc_html__( 'Add New', 'g5plus-academia' ),
                        'edit_item'          	=> esc_html__( 'Edit Item', 'g5plus-academia' ),
                        'update_item'        	=> esc_html__( 'Update Item', 'g5plus-academia' ),
                        'search_items'       	=> esc_html__( 'Search Item', 'g5plus-academia' ),
                        'not_found'          	=> esc_html__( 'Not found', 'g5plus-academia' ),
                        'not_found_in_trash' 	=> esc_html__( 'Not found in Trash', 'g5plus-academia' ),
                    ),
                    'supports'    => array( 'title', 'editor', 'comments', 'thumbnail'),
                    'public'      => true,
                    'menu_icon' => 'dashicons-clock',
                    'has_archive' => true
                )
            );
        }

        function academia_countdown_shortcode($atts){
            $layout_style = $el_class= '';
            extract( shortcode_atts( array(
                'layout_style'     => 'default',
                'el_class' => ''
            ), $atts ) );

            $plugin_path =  untrailingslashit( plugin_dir_path( __FILE__ ) );
            $template_path = $plugin_path . '/templates/comming-soon-'.$layout_style .'.php';
            ob_start();
            include($template_path);
            $ret = ob_get_contents();
            ob_end_clean();
            return $ret;
        }

        function academia_register_meta_boxes($meta_boxes){
            $meta_boxes[] = array(
                'title'  => esc_html__( 'Countdown Option', 'g5plus-academia' ),
                'id'     => 'academia-meta-box-countdown-opening',
                'pages'  => array( 'countdown' ),
                'fields' => array(
                    array(
                        'name' => esc_html__( 'Opening hours', 'g5plus-academia' ),
                        'id'   => 'countdown-opening',
                        'type' => 'datetime',
                    ),
                     array(
                         'name' => esc_html__( 'Type', 'g5plus-academia' ),
                         'id'   => 'countdown-type',
                         'type' => 'select',
                         'options'  => array(
                             'comming-soon' => esc_html__('Coming Soon','g5plus-academia'),
                             'under-construction' => esc_html__('Under Construction','g5plus-academia')
                         )
                     ),
                    array(
                        'name' => esc_html__( 'Url redirect (after countdown completed)', 'g5plus-academia' ),
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