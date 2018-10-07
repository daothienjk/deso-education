<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 3/26/15
 * Time: 5:24 PM
 */
class G5plus_Social_Profile extends  G5Plus_Widget {
    public function __construct() {
        $this->widget_cssclass    = 'widget-social-profile';
        $this->widget_description =  esc_html__( "Social profile widget", 'g5plus-academia' );
        $this->widget_id          = 'g5plus-social-profile';
        $this->widget_name        = esc_html__( 'G5Plus: Social Profile', 'g5plus-academia' );
        $this->settings           = array(
            'title' => array(
		        'type' => 'text',
		        'std' => '',
		        'label' => esc_html__('Title','g5plus-academia')
            ),
	        'layout'  => array(
                'type'    => 'select',
                'std'     => 's-default',
                'label'   => esc_html__( 'Layout', 'g5plus-academia' ),
                'options' => array(
                    's-default'  => esc_html__( 'Default', 'g5plus-academia' ),
                    's-rounded'  => esc_html__( 'Rounded', 'g5plus-academia' ),
	                's-icon-text'  => esc_html__( 'Icon And Text', 'g5plus-academia' ),
                )
            ),
	        'scheme'  => array(
		        'type'    => 'select',
		        'std'     => 's-primary',
		        'label'   => esc_html__( 'Scheme', 'g5plus-academia' ),
		        'options' => array(
			        's-scheme-default' => esc_html__( 'Default', 'g5plus-academia' ),
			        's-primary' => esc_html__( 'Primary', 'g5plus-academia' ),
			        's-secondary' => esc_html__( 'Secondary', 'g5plus-academia' ),
			        's-light' => esc_html__( 'Light (#FFF)', 'g5plus-academia' ),
			        's-dark'  => esc_html__( 'Dark (#000)', 'g5plus-academia' ),
			        's-gray'  => esc_html__( 'Gray (#777)', 'g5plus-academia' ),
			        's-light-gray-1'  => esc_html__( 'Light Gray 1 (#CCC)', 'g5plus-academia' ),
			        's-light-gray-2'  => esc_html__( 'Light Gray 2 (#BBB)', 'g5plus-academia' ),
			        's-light-gray-3'  => esc_html__( 'Light Gray 3 (#BABABA)', 'g5plus-academia' ),
			        's-dark-gray-1'  => esc_html__( 'Dark Gray 1 (#444)', 'g5plus-academia' ),
			        's-dark-gray-2'  => esc_html__( 'Dark Gray 2 (#666)', 'g5plus-academia' ),
			        's-dark-gray-3'  => esc_html__( 'Dark Gray 3 (#888)', 'g5plus-academia' ),
		        )
	        ),
	        'size'  => array(
		        'type'    => 'select',
		        'std'     => 's-medium',
		        'label'   => esc_html__( 'Size', 'g5plus-academia' ),
		        'options' => array(
			        's-md'  => esc_html__( 'Medium', 'g5plus-academia' ),
			        's-lg'  => esc_html__( 'Large', 'g5plus-academia' ),
		        )
	        ),

            'icons' => array(
                'type'  => 'multi-select',
                'label'   => esc_html__( 'Select social profiles', 'g5plus-academia' ),
                'std'   => '',
	            'options' => array(
		            'twitter'  => esc_html__( 'Twitter', 'g5plus-academia' ),
		            'facebook'  => esc_html__( 'Facebook', 'g5plus-academia' ),
		            'dribbble'  => esc_html__( 'Dribbble', 'g5plus-academia' ),
		            'vimeo'  => esc_html__( 'Vimeo', 'g5plus-academia' ),
		            'tumblr'  => esc_html__( 'Tumblr', 'g5plus-academia' ),
		            'skype'  => esc_html__( 'Skype', 'g5plus-academia' ),
		            'linkedin'  => esc_html__( 'LinkedIn', 'g5plus-academia' ),
		            'googleplus'  => esc_html__( 'Google+', 'g5plus-academia' ),
		            'flickr'  => esc_html__( 'Flickr', 'g5plus-academia' ),
		            'youtube'  => esc_html__( 'YouTube', 'g5plus-academia' ),
		            'pinterest' => esc_html__( 'Pinterest', 'g5plus-academia' ),
		            'foursquare'  => esc_html__( 'Foursquare', 'g5plus-academia' ),
		            'instagram' => esc_html__( 'Instagram', 'g5plus-academia' ),
		            'github'  => esc_html__( 'GitHub', 'g5plus-academia' ),
		            'xing' => esc_html__( 'Xing', 'g5plus-academia' ),
		            'behance'  => esc_html__( 'Behance', 'g5plus-academia' ),
		            'deviantart'  => esc_html__( 'Deviantart', 'g5plus-academia' ),
		            'soundcloud'  => esc_html__( 'SoundCloud', 'g5plus-academia' ),
		            'yelp'  => esc_html__( 'Yelp', 'g5plus-academia' ),
		            'rss'  => esc_html__( 'RSS Feed', 'g5plus-academia' ),
		            'email'  => esc_html__( 'Email address', 'g5plus-academia' ),
	            )
            )
        );
        if(function_exists('vc_map')){
            add_shortcode('g5plusframework_widget_social_profile', array($this, 'vc_widget'));
        }
        parent::__construct();
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
	    $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
        $layout         = ( ! empty( $instance['layout'] ) ) ? $instance['layout'] : 's-default';
	    $scheme        = ( ! empty( $instance['scheme'] ) ) ? $instance['scheme'] : 's-primary';
	    $size        = ( ! empty( $instance['size'] ) ) ? $instance['size'] : 's-md';
	    $icons        = ( ! empty( $instance['icons'] ) ) ? $instance['icons'] : '';

	    $class_wrap = 'social-profile '. $layout . ' ' . $scheme . ' ' .$size;

	    $social_icons = g5plus_get_social_icon($icons,$class_wrap );

	    echo wp_kses_post($args['before_widget']);
		if ($title) {
			echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
		}
	    echo wp_kses_post( $social_icons );
	    echo wp_kses_post($args['after_widget']);
    }

    function vc_widget($atts){
        $attributes = vc_map_get_attributes( 'g5plusframework_widget_social_profile', $atts );
        $args = array();
        $args['widget_id'] = 'g5plus-social-profile';
        $attributes['icons'] = str_replace(',','||',$attributes['icons'] );
        the_widget('G5plus_Social_Profile',$attributes,$args);
    }
}
if (!function_exists('g5plus_register_social_profile')) {
    function g5plus_register_social_profile() {
        register_widget('G5plus_Social_Profile');

        if(function_exists('vc_map')){
            vc_map( array(
                'name' => esc_html__( 'G5Plus Social Profile','g5plus-academia' ),
                'base' => 'g5plusframework_widget_social_profile',
                'icon' => 'fa fa-share-square-o',
                'category' => esc_html__( 'Academia Widgets', 'g5plus-academia' ),
                'class' => 'wpb_vc_wp_widget',
                'weight' => - 50,
                'description' => esc_html__( 'Social icon for your site', 'g5plus-academia' ),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Title', 'g5plus-academia' ),
                        'param_name' => 'title'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Layout', 'g5plus-academia' ),
                        'param_name' => 'layout',
                        'value' => array(
                            esc_html__( 'Default', 'g5plus-academia' ) => 's-default'  ,
                            esc_html__( 'Rounded', 'g5plus-academia' ) => 's-rounded'  ,
                            esc_html__( 'Icon And Text', 'g5plus-academia' ) => 's-icon-text'  ,
                        )
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Scheme', 'g5plus-academia' ),
                        'param_name' => 'scheme',
                        'std' => 's-primary',
                        'value' => array(
                            esc_html__( 'Default', 'g5plus-academia' ) => 's-scheme-default' ,
                            esc_html__( 'Primary', 'g5plus-academia' ) => 's-primary' ,
                            esc_html__( 'Secondary', 'g5plus-academia' ) => 's-secondary' ,
                            esc_html__( 'Light (#FFF)', 'g5plus-academia' ) => 's-light' ,
                            esc_html__( 'Dark (#000)', 'g5plus-academia' ) => 's-dark'  ,
                            esc_html__( 'Gray (#777)', 'g5plus-academia' ) => 's-gray'  ,
                            esc_html__( 'Light Gray 1 (#CCC)', 'g5plus-academia' ) => 's-light-gray-1'  ,
                            esc_html__( 'Light Gray 2 (#BBB)', 'g5plus-academia' ) => 's-light-gray-2'  ,
                            esc_html__( 'Light Gray 3 (#BABABA)', 'g5plus-academia' ) => 's-light-gray-3'  ,
                            esc_html__( 'Dark Gray 1 (#444)', 'g5plus-academia' ) => 's-dark-gray-1'  ,
                            esc_html__( 'Dark Gray 2 (#666)', 'g5plus-academia' ) => 's-dark-gray-2' ,
                            esc_html__( 'Dark Gray 3 (#888)', 'g5plus-academia' ) => 's-dark-gray-3'  ,
                        )
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Size', 'g5plus-academia' ),
                        'param_name' => 'size',
                        'std' => 's-md',
                        'value' => array(
                            esc_html__( 'Medium', 'g5plus-academia' ) => 's-md'  ,
                            esc_html__( 'Large', 'g5plus-academia' ) => 's-lg'
                        )
                    ),
                    array(
                        'type' => 'multi-select',
                        'heading' => esc_html__( 'Icons', 'g5plus-academia' ),
                        'admin_label' => true,
                        'param_name' => 'icons',
                        'options' => array(
                            esc_html__( 'Twitter', 'g5plus-academia' ) => 'twitter'  ,
                            esc_html__( 'Facebook', 'g5plus-academia' ) => 'facebook'  ,
                            esc_html__( 'Dribbble', 'g5plus-academia' ) => 'dribbble'  ,
                            esc_html__( 'Vimeo', 'g5plus-academia' ) => 'vimeo'  ,
                            esc_html__( 'Tumblr', 'g5plus-academia' ) => 'tumblr'  ,
                            esc_html__( 'Skype', 'g5plus-academia' ) => 'skype'  ,
                            esc_html__( 'LinkedIn', 'g5plus-academia' ) => 'linkedin' ,
                            esc_html__( 'Google+', 'g5plus-academia' ) => 'googleplus' ,
                            esc_html__( 'Flickr', 'g5plus-academia' ) => 'flickr'  ,
                            esc_html__( 'YouTube', 'g5plus-academia' ) => 'youtube'  ,
                            esc_html__( 'Pinterest', 'g5plus-academia' ) => 'pinterest' ,
                            esc_html__( 'Foursquare', 'g5plus-academia' ) => 'foursquare'  ,
                            esc_html__( 'Instagram', 'g5plus-academia' ) => 'instagram' ,
                            esc_html__( 'GitHub', 'g5plus-academia' ) => 'github'  ,
                            esc_html__( 'Xing', 'g5plus-academia' ) => 'xing' ,
                            esc_html__( 'Behance', 'g5plus-academia' ) => 'behance'  ,
                            esc_html__( 'Deviantart', 'g5plus-academia' ) => 'deviantart'  ,
                            esc_html__( 'SoundCloud', 'g5plus-academia' ) => 'soundcloud'  ,
                            esc_html__( 'Yelp', 'g5plus-academia' ) => 'yelp' ,
                            esc_html__( 'RSS Feed', 'g5plus-academia' ) => 'rss'  ,
                            esc_html__( 'Email address', 'g5plus-academia' ) => 'email'  ,
                        )
                    ),
                )
            ) );
        }
    }
    add_action('widgets_init', 'g5plus_register_social_profile', 1);
}