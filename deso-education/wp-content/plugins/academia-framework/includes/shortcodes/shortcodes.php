<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 5/28/2015
 * Time: 5:44 PM
 */
if (!class_exists('g5plusFramework_Shortcodes')) {
    class g5plusFramework_Shortcodes
    {

        private static $instance;

        public static function init()
        {
            if (!isset(self::$instance)) {
                self::$instance = new g5plusFramework_Shortcodes;
                add_action('init', array(self::$instance, 'includes'), 0);
                add_action('init', array(self::$instance, 'register_vc_map'), 10);
            }
            return self::$instance;
        }

        public function includes()
        {
            if(!class_exists('Vc_Manager')){
                return;
            }
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/expandable/expandable.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/slider-container/slider-container.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/vertical-progress-bar/vertical-progress-bar.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/heading/heading.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/button/button.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/icon-box/icon-box.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/partner-carousel/partner-carousel.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/post/post.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/feature/feature.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/call-action/call-action.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/counter/counter.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/testimonial/testimonial.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/cover-box/cover-box.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/social-icon/social-icon.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/google-map/google-map.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/video-bg/video-bg.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/video/video.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/ourteacher/ourteacher.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/event/event.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/countdown/countdown.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/course/section.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/course/lesson.php');
            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/twitter/twitter.php');
            if(class_exists('WooCommerce')){
                include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/course/course-schedule.php');
                include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/course/course-feature.php');
                include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/course/course-category.php');
                include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/course/course-search.php');
            }


            if (class_exists('WooCommerce')) {
                //include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/product/product.php');
            }

            include_once(PLUGIN_G5PLUS_FRAMEWORK_DIR . 'includes/shortcodes/blog/blog.php');
        }

        public static function g5plus_get_css_animation($css_animation)
        {
            $output = '';
            if ($css_animation != '') {
                wp_enqueue_script('waypoints');
                $output = ' wpb_animate_when_almost_visible g5plus-css-animation ' . $css_animation;
            }
            return $output;
        }

        public static function g5plus_get_style_animation($duration, $delay)
        {
            $styles = array();
            if ($duration != '0' && !empty($duration)) {
                $duration = (float)trim($duration, "\n\ts");
                $styles[] = "-webkit-animation-duration: {$duration}s";
                $styles[] = "-moz-animation-duration: {$duration}s";
                $styles[] = "-ms-animation-duration: {$duration}s";
                $styles[] = "-o-animation-duration: {$duration}s";
                $styles[] = "animation-duration: {$duration}s";
            }
            if ($delay != '0' && !empty($delay)) {
                $delay = (float)trim($delay, "\n\ts");
                $styles[] = "opacity: 0";
                $styles[] = "-webkit-animation-delay: {$delay}s";
                $styles[] = "-moz-animation-delay: {$delay}s";
                $styles[] = "-ms-animation-delay: {$delay}s";
                $styles[] = "-o-animation-delay: {$delay}s";
                $styles[] = "animation-delay: {$delay}s";
            }
            if (count($styles) > 1) {
                return 'style="' . implode(';', $styles) . '"';
            }
            return implode(';', $styles);
        }

        public static function  substr($str, $txt_len, $end_txt = '...')
        {
            if (empty($str)) return '';
            if (strlen($str) <= $txt_len) return $str;

            $i = $txt_len;
            while ($str[$i] != ' ') {
                $i--;
                if ($i == -1) break;
            }
            while ($str[$i] == ' ') {
                $i--;
                if ($i == -1) break;
            }

            return substr($str, 0, $i + 1) . $end_txt;
        }

        public function register_vc_map()
        {
            $academia_font_awesome = &academia_get_font_awesome();
            $g5plus_options = &academia_get_options_config();

            if (function_exists('vc_map')) {
                $add_css_animation = array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('CSS Animation', 'g5plus-academia'),
                    'param_name' => 'css_animation',
                    'value' => array(esc_html__('No', 'g5plus-academia') => '', esc_html__('Fade In', 'g5plus-academia') => 'wpb_fadeIn', esc_html__('Fade Top to Bottom', 'g5plus-academia') => 'wpb_fadeInDown', esc_html__('Fade Bottom to Top', 'g5plus-academia') => 'wpb_fadeInUp', esc_html__('Fade Left to Right', 'g5plus-academia') => 'wpb_fadeInLeft', esc_html__('Fade Right to Left', 'g5plus-academia') => 'wpb_fadeInRight', esc_html__('Bounce In', 'g5plus-academia') => 'wpb_bounceIn', esc_html__('Bounce Top to Bottom', 'g5plus-academia') => 'wpb_bounceInDown', esc_html__('Bounce Bottom to Top', 'g5plus-academia') => 'wpb_bounceInUp', esc_html__('Bounce Left to Right', 'g5plus-academia') => 'wpb_bounceInLeft', esc_html__('Bounce Right to Left', 'g5plus-academia') => 'wpb_bounceInRight', esc_html__('Zoom In', 'g5plus-academia') => 'wpb_zoomIn', esc_html__('Flip Vertical', 'g5plus-academia') => 'wpb_flipInX', esc_html__('Flip Horizontal', 'g5plus-academia') => 'wpb_flipInY', esc_html__('Bounce', 'g5plus-academia') => 'wpb_bounce', esc_html__('Flash', 'g5plus-academia') => 'wpb_flash', esc_html__('Shake', 'g5plus-academia') => 'wpb_shake', esc_html__('Pulse', 'g5plus-academia') => 'wpb_pulse', esc_html__('Swing', 'g5plus-academia') => 'wpb_swing', esc_html__('Rubber band', 'g5plus-academia') => 'wpb_rubberBand', esc_html__('Wobble', 'g5plus-academia') => 'wpb_wobble', esc_html__('Tada', 'g5plus-academia') => 'wpb_tada'),
                    'description' => esc_html__('Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'g5plus-academia'),
                    'group' => esc_html__('Animation Settings', 'g5plus-academia')
                );

                $add_duration_animation = array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Animation Duration', 'g5plus-academia'),
                    'param_name' => 'duration',
                    'value' => '',
                    'description' => esc_html__('Duration in seconds. You can use decimal points in the value. Use this field to specify the amount of time the animation plays. <em>The default value depends on the animation, leave blank to use the default.</em>', 'g5plus-academia'),
                    'dependency' => Array('element' => 'css_animation', 'value' => array('wpb_fadeIn', 'wpb_fadeInDown', 'wpb_fadeInUp', 'wpb_fadeInLeft', 'wpb_fadeInRight', 'wpb_bounceIn', 'wpb_bounceInDown', 'wpb_bounceInUp', 'wpb_bounceInLeft', 'wpb_bounceInRight', 'wpb_zoomIn', 'wpb_flipInX', 'wpb_flipInY', 'wpb_bounce', 'wpb_flash', 'wpb_shake', 'wpb_pulse', 'wpb_swing', 'wpb_rubberBand', 'wpb_wobble', 'wpb_tada')),
                    'group' => esc_html__('Animation Settings', 'g5plus-academia')
                );

                $add_delay_animation = array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Animation Delay', 'g5plus-academia'),
                    'param_name' => 'delay',
                    'value' => '',
                    'description' => esc_html__('Delay in seconds. You can use decimal points in the value. Use this field to delay the animation for a few seconds, this is helpful if you want to chain different effects one after another above the fold.', 'g5plus-academia'),
                    'dependency' => Array('element' => 'css_animation', 'value' => array('wpb_fadeIn', 'wpb_fadeInDown', 'wpb_fadeInUp', 'wpb_fadeInLeft', 'wpb_fadeInRight', 'wpb_bounceIn', 'wpb_bounceInDown', 'wpb_bounceInUp', 'wpb_bounceInLeft', 'wpb_bounceInRight', 'wpb_zoomIn', 'wpb_flipInX', 'wpb_flipInY', 'wpb_bounce', 'wpb_flash', 'wpb_shake', 'wpb_pulse', 'wpb_swing', 'wpb_rubberBand', 'wpb_wobble', 'wpb_tada')),
                    'group' => esc_html__('Animation Settings', 'g5plus-academia')
                );

                $add_el_class = array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Extra class name', 'g5plus-academia'),
                    'param_name' => 'el_class',
                    'description' => esc_html__('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'g5plus-academia'),
                );
                $target_arr = array(
                    esc_html__('Same window', 'g5plus-academia') => '_self',
                    esc_html__('New window', 'g5plus-academia') => '_blank'
                );
                $icon_type = array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Icon library', 'g5plus-academia'),
                    'value' => array(
                        esc_html__('[None]', 'g5plus-academia') => '',
                        esc_html__('Font Awesome', 'g5plus-academia') => 'fontawesome',
                        esc_html__('Image', 'g5plus-academia') => 'image',
                    ),
                    'param_name' => 'icon_type',
                    'description' => esc_html__('Select icon library.', 'g5plus-academia'),
                );
                $icon_fontawesome = array(
                    'type' => 'iconpicker',
                    'heading' => esc_html__('Icon', 'g5plus-academia'),
                    'param_name' => 'icon_fontawesome',
                    'value' => 'fa fa-adjust', // default value to backend editor admin_label
                    'settings' => array(
                        'emptyIcon' => false,
                        // default true, display an "EMPTY" icon?
                        'iconsPerPage' => 4000,
                        'source' => $academia_font_awesome,
                        // default 100, how many icons per/page to display, we use (big number) to display all icons in single page
                    ),
                    'dependency' => array(
                        'element' => 'icon_type',
                        'value' => 'fontawesome',
                    ),
                    'description' => esc_html__('Select icon from library.', 'g5plus-academia'),
                );
                $icon_image = array(
                    'type' => 'attach_image',
                    'heading' => esc_html__('Upload Image Icon:', 'g5plus-academia'),
                    'param_name' => 'icon_image',
                    'value' => '',
                    'description' => esc_html__('Upload the custom image icon.', 'g5plus-academia'),
                    'dependency' => Array('element' => 'icon_type', 'value' => array('image')),
                );
                vc_map(array(
                    'name' => esc_html__('Slider Container', 'g5plus-academia'),
                    'base' => 'academia_slider_container',
                    'class' => '',
                    'icon' => 'fa fa-ellipsis-h',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'as_parent' => array('except' => 'academia_slider_container'),
                    'content_element' => true,
                    'show_settings_on_create' => true,
                    'params' => array(
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Loop', 'g5plus-academia'),
                            'param_name' => 'loop',
                            'description' => esc_html__('Inifnity loop.', 'g5plus-academia'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                            'std' => 'yes',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Center', 'g5plus-academia'),
                            'param_name' => 'center',
                            'description' => esc_html__('Center item. Works well with even an odd number of items.', 'g5plus-academia'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Navigation', 'g5plus-academia'),
                            'param_name' => 'nav',
                            'description' => esc_html__('Show navigation.', 'g5plus-academia'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Pagination', 'g5plus-academia'),
                            'param_name' => 'dots',
                            'description' => esc_html__('Show pagination.', 'g5plus-academia'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Autoplay', 'g5plus-academia'),
                            'param_name' => 'autoplay',
                            'description' => esc_html__('Autoplay.', 'g5plus-academia'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                            'std' => 'yes',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Pause on hover', 'g5plus-academia'),
                            'param_name' => 'autoplayhoverpause',
                            'description' => esc_html__('Pause on mouse hover.', 'g5plus-academia'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                            'std' => 'yes',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Autoplay Timeout', 'g5plus-academia'),
                            'param_name' => 'autoplaytimeout',
                            'description' => esc_html__('Autoplay interval timeout.', 'g5plus-academia'),
                            'value' => '',
                            'std' => 5000
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items', 'g5plus-academia'),
                            'param_name' => 'items',
                            'description' => esc_html__('This variable allows you to set the maximum amount of items displayed at a time with the widest browser width', 'g5plus-academia'),
                            'value' => '',
                            'std' => 4
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items Desktop', 'g5plus-academia'),
                            'param_name' => 'itemsdesktop',
                            'description' => esc_html__('Browser Width >= 1200', 'g5plus-academia'),
                            'value' => '',
                            'std' => '4'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items Desktop Small', 'g5plus-academia'),
                            'param_name' => 'itemsdesktopsmall',
                            'description' => esc_html__('Browser Width >= 980', 'g5plus-academia'),
                            'value' => '',
                            'std' => '3'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items Tablet', 'g5plus-academia'),
                            'param_name' => 'itemstablet',
                            'description' => esc_html__('Browser Width >= 768', 'g5plus-academia'),
                            'value' => '',
                            'std' => '2'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items Tablet Small', 'g5plus-academia'),
                            'param_name' => 'itemstabletsmall',
                            'description' => esc_html__('Browser Width >= 600', 'g5plus-academia'),
                            'value' => '',
                            'std' => '2'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items Mobile', 'g5plus-academia'),
                            'param_name' => 'itemsmobile',
                            'description' => esc_html__('Browser Width < 600', 'g5plus-academia'),
                            'value' => '',
                            'std' => '1'
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    ),
                    'js_view' => 'VcColumnView'
                ));
                vc_map(array(
                    'name' => esc_html__('Expandable', 'g5plus-academia'),
                    'base' => 'academia_expandable',
                    'class' => '',
                    'icon' => 'fa fa-expand',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'as_parent' => array('except' => 'academia_expandable'),
                    'content_element' => true,
                    'show_settings_on_create' => true,
                    'params' => array(
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Collapse section?', 'g5plus-academia'),
                            'param_name' => 'collapse',
                            'description' => esc_html__('Collapse or Expand section.', 'g5plus-academia'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                            'std' => 'yes',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('More Label', 'g5plus-academia'),
                            'param_name' => 'more_button_label',
                            'value' => '',
                            'std'=>'VIEW MORE',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Less Label', 'g5plus-academia'),
                            'param_name' => 'less_button_label',
                            'value' => '',
                            'std'=>'VIEW LESS',
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Position', 'g5plus-academia'),
                            'param_name' => 'button_position',
                            'value' => array(
                                esc_html__('Left', 'g5plus-academia') => 'left',
                                esc_html__('Right', 'g5plus-academia') => 'right',
                                esc_html__('Center', 'g5plus-academia') => 'center',
                            ),
                            'std'=>'center',
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__('Background color', 'g5plus-academia'),
                            'param_name' => 'button_bgcolor',
                            'value' => '',
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__('Color', 'g5plus-academia'),
                            'param_name' => 'button_color',
                            'value' => '',
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__('Hover color', 'g5plus-academia'),
                            'param_name' => 'button_hovercolor',
                            'value' => '',
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    ),
                    'js_view' => 'VcColumnView'
                ));
                vc_map(array(
                    'name' => esc_html__('Vertical Progress Bar', 'g5plus-academia'),
                    'base' => 'academia_vertical_progress_bar',
                    'icon' => 'icon-wpb-graph',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'description' => esc_html__( 'Animated vertical progress bar', 'g5plus-academia' ),
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Widget title', 'g5plus-academia' ),
                            'param_name' => 'title',
                            'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'g5plus-academia' )
                        ),
                        array(
                            'type' => 'param_group',
                            'heading' => esc_html__( 'Values', 'g5plus-academia' ),
                            'param_name' => 'values',
                            'description' => esc_html__( 'Enter values for graph - value, title and color.', 'g5plus-academia' ),
                            'value' => urlencode( json_encode( array(
                                array(
                                    'label' => esc_html__( 'Development', 'g5plus-academia' ),
                                    'value' => '90',
                                ),
                                array(
                                    'label' => esc_html__( 'Design', 'g5plus-academia' ),
                                    'value' => '80',
                                ),
                                array(
                                    'label' => esc_html__( 'Marketing', 'g5plus-academia' ),
                                    'value' => '70',
                                ),
                            ) ) ),
                            'params' => array(
                                array(
                                    'type' => 'textfield',
                                    'heading' => esc_html__( 'Label', 'g5plus-academia' ),
                                    'param_name' => 'label',
                                    'description' => esc_html__( 'Enter text used as title of bar.', 'g5plus-academia' ),
                                    'admin_label' => true,
                                ),
                                array(
                                    'type' => 'textfield',
                                    'heading' => esc_html__( 'Value', 'g5plus-academia' ),
                                    'param_name' => 'value',
                                    'description' => esc_html__( 'Enter value of bar.', 'g5plus-academia' ),
                                    'admin_label' => true,
                                ),
                                array(
                                    'type' => 'dropdown',
                                    'heading' => esc_html__( 'Color', 'g5plus-academia' ),
                                    'param_name' => 'color',
                                    'value' => array(
                                            esc_html__( 'Default', 'g5plus-academia' ) => ''
                                        ) + array(
                                            esc_html__('Primary color', 'g5plus-academia') => 'p-color',
                                            esc_html__('Secondary color', 'g5plus-academia') => 's-color',
                                            esc_html__('Tertiary color', 'g5plus-academia') => 't-color',
                                            esc_html__( 'Classic Grey', 'g5plus-academia' ) => 'bar_grey',
                                            esc_html__( 'Classic Blue', 'g5plus-academia' ) => 'bar_blue',
                                            esc_html__( 'Classic Turquoise', 'g5plus-academia' ) => 'bar_turquoise',
                                            esc_html__( 'Classic Green', 'g5plus-academia' ) => 'bar_green',
                                            esc_html__( 'Classic Orange', 'g5plus-academia' ) => 'bar_orange',
                                            esc_html__( 'Classic Red', 'g5plus-academia' ) => 'bar_red',
                                            esc_html__( 'Classic Black', 'g5plus-academia' ) => 'bar_black',
                                        ) + getVcShared( 'colors-dashed' ) + array(
                                            esc_html__( 'Custom Color', 'g5plus-academia' ) => 'custom'
                                        ),
                                    'description' => esc_html__( 'Select single bar background color.', 'g5plus-academia' ),
                                    'admin_label' => true,
                                    'param_holder_class' => 'vc_colored-dropdown'
                                ),
                                array(
                                    'type' => 'colorpicker',
                                    'heading' => esc_html__( 'Custom color', 'g5plus-academia' ),
                                    'param_name' => 'customcolor',
                                    'description' => esc_html__( 'Select custom single bar value background color.', 'g5plus-academia' ),
                                    'dependency' => array(
                                        'element' => 'color',
                                        'value' => array( 'custom' )
                                    ),
                                ),
                                array(
                                    'type' => 'colorpicker',
                                    'heading' => esc_html__( 'Custom bar color', 'g5plus-academia' ),
                                    'param_name' => 'custombarcolor',
                                    'description' => esc_html__( 'Select custom single bar background color.', 'g5plus-academia' ),
                                    'dependency' => array(
                                        'element' => 'color',
                                        'value' => array( 'custom' )
                                    ),
                                ),
                                array(
                                    'type' => 'colorpicker',
                                    'heading' => esc_html__( 'Custom label text color', 'g5plus-academia' ),
                                    'param_name' => 'customtxtcolor',
                                    'description' => esc_html__( 'Select custom single bar label text color.', 'g5plus-academia' ),
                                    'dependency' => array(
                                        'element' => 'color',
                                        'value' => array( 'custom' )
                                    ),
                                ),
                                array(
                                    'type' => 'colorpicker',
                                    'heading' => esc_html__( 'Custom value text color', 'g5plus-academia' ),
                                    'param_name' => 'customvaluetxtcolor',
                                    'description' => esc_html__( 'Select custom single bar value text color.', 'g5plus-academia' ),
                                    'dependency' => array(
                                        'element' => 'color',
                                        'value' => array( 'custom' )
                                    ),
                                ),
                            ),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Units', 'g5plus-academia' ),
                            'param_name' => 'units',
                            'std'=> '%',
                            'description' => esc_html__( 'Enter measurement units (Example: %, px, points, etc. Note: graph value and units will be appended to graph title).', 'g5plus-academia' )
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__( 'Color', 'g5plus-academia' ),
                            'param_name' => 'bgcolor',
                            'value' => array(
                                    esc_html__('Primary color', 'g5plus-academia') => 'p-color',
                                    esc_html__('Secondary color', 'g5plus-academia') => 's-color',
                                    esc_html__('Tertiary color', 'g5plus-academia') => 't-color',
                                    esc_html__( 'Classic Grey', 'g5plus-academia' ) => 'bar_grey',
                                    esc_html__( 'Classic Blue', 'g5plus-academia' ) => 'bar_blue',
                                    esc_html__( 'Classic Turquoise', 'g5plus-academia' ) => 'bar_turquoise',
                                    esc_html__( 'Classic Green', 'g5plus-academia' ) => 'bar_green',
                                    esc_html__( 'Classic Orange', 'g5plus-academia' ) => 'bar_orange',
                                    esc_html__( 'Classic Red', 'g5plus-academia' ) => 'bar_red',
                                    esc_html__( 'Classic Black', 'g5plus-academia' ) => 'bar_black',
                                ) + getVcShared( 'colors-dashed' ) + array(
                                    esc_html__( 'Custom Color', 'g5plus-academia' ) => 'custom'
                                ),
                            'std'=>'p-color',
                            'description' => esc_html__( 'Select bar background color.', 'g5plus-academia' ),
                            'admin_label' => true,
                            'param_holder_class' => 'vc_colored-dropdown',
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__( 'Bar value custom background color', 'g5plus-academia' ),
                            'param_name' => 'custombgcolor',
                            'description' => esc_html__( 'Select custom background color for bars value.', 'g5plus-academia' ),
                            'dependency' => array( 'element' => 'bgcolor', 'value' => array( 'custom' ) )
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__( 'Bar custom background color', 'g5plus-academia' ),
                            'param_name' => 'custombgbarcolor',
                            'description' => esc_html__( 'Select custom background color for bars.', 'g5plus-academia' ),
                            'dependency' => array( 'element' => 'bgcolor', 'value' => array( 'custom' ) )
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__( 'Bar custom label text color', 'g5plus-academia' ),
                            'param_name' => 'customtxtcolor',
                            'description' => esc_html__( 'Select custom label text color for bars.', 'g5plus-academia' ),
                            'dependency' => array( 'element' => 'bgcolor', 'value' => array( 'custom' ) )
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__( 'Bar custom value text color', 'g5plus-academia' ),
                            'param_name' => 'customvaluetxtcolor',
                            'description' => esc_html__( 'Select custom value text color for bars.', 'g5plus-academia' ),
                            'dependency' => array( 'element' => 'bgcolor', 'value' => array( 'custom' ) )
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__( 'Options', 'g5plus-academia' ),
                            'param_name' => 'options',
                            'value' => array(
                                esc_html__( 'Add stripes', 'g5plus-academia' ) => 'striped',
                                esc_html__( 'Add animation (Note: visible only with striped bar).', 'g5plus-academia' ) => 'animated'
                            )
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Extra class name', 'g5plus-academia' ),
                            'param_name' => 'el_class',
                            'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'g5plus-academia' )
                        ),
                        array(
                            'type' => 'css_editor',
                            'heading' => esc_html__( 'CSS box', 'g5plus-academia' ),
                            'param_name' => 'css',
                            'group' => esc_html__( 'Design Options', 'g5plus-academia' )
                        ),
                    )
                ));
                vc_map(array(
                    'name' => esc_html__('Cover Box', 'g5plus-academia'),
                    'base' => 'academia_cover_box_ctn',
                    'class' => '',
                    'icon' => 'fa fa-newspaper-o',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'as_parent' => array('only' => 'academia_cover_box_sc'),
                    'content_element' => true,
                    'show_settings_on_create' => true,
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Item Active Index', 'g5plus-academia'),
                            'param_name' => 'active_index',
                            'std' => '1',
                            'admin_label' => true,
                            'description' => esc_html__('Enter number index of item need active.', 'g5plus-academia')
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    ),
                    'js_view' => 'VcColumnView'
                ));
                vc_map(array(
                    'name' => esc_html__('Cover Box Item', 'g5plus-academia'),
                    'base' => 'academia_cover_box_sc',
                    'class' => '',
                    'icon' => 'fa fa-file-text-o',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'as_child' => array('only' => 'academia_cover_box_ctn', 'academia_slider_container'),
                    'params' => array(
                        array(
                            'type' => 'attach_image',
                            'heading' => esc_html__('Image:', 'g5plus-academia'),
                            'param_name' => 'image',
                            'value' => '',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Title', 'g5plus-academia'),
                            'param_name' => 'title',
                            'admin_label' => true,
                            'description' => esc_html__('Enter Title.', 'g5plus-academia')
                        ),
                        array(
                            'type' => 'vc_link',
                            'heading' => esc_html__('Link (url)', 'g5plus-academia'),
                            'param_name' => 'link',
                            'value' => '',
                        ),
                        array(
                            'type' => 'textarea',
                            'heading' => esc_html__('Description', 'g5plus-academia'),
                            'param_name' => 'content',
                            'value' => ''
                        )
                    )
                ));
                vc_map(array(
                    'name' => esc_html__('Counter', 'g5plus-academia'),
                    'base' => 'academia_counter',
                    'class' => '',
                    'icon' => 'fa fa-tachometer',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        $icon_type,
                        $icon_fontawesome,
                        $icon_image,
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__('Icon Background Color', 'g5plus-academia'),
                            'param_name' => 'icon_bg_color',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__('Icon Color', 'g5plus-academia'),
                            'param_name' => 'icon_color',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Value', 'g5plus-academia'),
                            'param_name' => 'value',
                            'value' => '',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__('Value Color', 'g5plus-academia'),
                            'param_name' => 'value_color',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Unit', 'g5plus-academia'),
                            'param_name' => 'unit',
                            'value' => '',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__('Unit Color', 'g5plus-academia'),
                            'param_name' => 'unit_color',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Title', 'g5plus-academia'),
                            'param_name' => 'title',
                            'value' => '',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'colorpicker',
                            'heading' => esc_html__('Title Color', 'g5plus-academia'),
                            'param_name' => 'title_color',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        $add_el_class
                    )
                ));

                $ourteacher_cat = array();
                $ourteacher_categories = get_terms(G5PLUS_OURTEACHER_CATEGORY_TAXONOMY, array('hide_empty' => 0, 'orderby' => 'ASC'));
                if (is_array($ourteacher_categories)) {
                    foreach ($ourteacher_categories as $cat) {
                        $ourteacher_cat[$cat->name] = $cat->slug;
                    }
                }
                vc_map(array(
                    'name' => esc_html__('Our Teacher', 'g5plus-academia'),
                    'base' => 'academia_ourteacher',
                    'class' => '',
                    'icon' => 'fa fa-users',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'multi-select',
                            'heading' => esc_html__('Department', 'g5plus-academia'),
                            'param_name' => 'category',
                            'options' => $ourteacher_cat
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Item Amount', 'g5plus-academia'),
                            'param_name' => 'item_amount',
                            'value' => '8'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Column', 'g5plus-academia'),
                            'param_name' => 'column',
                            'value' => '4'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Slider Style', 'g5plus-academia'),
                            'param_name' => 'is_slider',
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes')
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Show pagination control', 'g5plus-academia'),
                            'param_name' => 'dots',
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                            'dependency' => Array('element' => 'is_slider', 'value' => 'yes')
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Show navigation control', 'g5plus-academia'),
                            'param_name' => 'nav',
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                            'dependency' => Array('element' => 'is_slider', 'value' => 'yes')
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Autoplay Timeout', 'g5plus-academia'),
                            'param_name' => 'autoplaytimeout',
                            'description' => esc_html__('Autoplay interval timeout.', 'g5plus-academia'),
                            'value' => '',
                            'dependency' => Array('element' => 'is_slider', 'value' => 'yes'),
                            'std' => 5000
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));

                vc_map(array(
                    'name' => esc_html__('Our Teacher Social', 'g5plus-academia'),
                    'base' => 'academia_ourteacher_social',
                    'class' => '',
                    'icon' => 'fa fa-smile-o',
                    'description' => esc_html__('Only use in our teacher detail', 'g5plus-academia'),
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));
                vc_map(array(
                    'name' => esc_html__('Our Teachers List', 'g5plus-academia'),
                    'base' => 'academia_ourteacher_list',
                    'class' => '',
                    'icon' => 'fa fa-user-plus',
                    'description' => esc_html__('Show all teachers', 'g5plus-academia'),
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Posts per page', 'g5plus-academia'),
                            'param_name' => 'post_per_page',
                            'value' => '',
                            'std'=>'12'
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));
                vc_map(array(
                    'name' => esc_html__('Countdown', 'g5plus-academia'),
                    'base' => 'academia_countdown_shortcode',
                    'class' => '',
                    'icon' => 'fa fa-clock-o',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Layout Style', 'g5plus-academia'),
                            'param_name' => 'layout_style',
                            'admin_label' => true,
                            'value' => array(
                                esc_html__('Default', 'g5plus-academia') => 'default'),
                            'description' => esc_html__('Select Layout Style.', 'g5plus-academia')
                        ),
                        $add_el_class
                    )
                ));


                vc_map(array(
                    'name' => esc_html__('Button', 'g5plus-academia'),
                    'base' => 'academia_button',
                    'class' => '',
                    'icon' => 'fa fa-bold',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'vc_link',
                            'heading' => esc_html__('Link (url)', 'g5plus-academia'),
                            'param_name' => 'link',
                            'value' => '',
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Layout Style', 'g5plus-academia'),
                            'param_name' => 'layout_style',
                            'admin_label' => true,
                            'value' => array(
                                esc_html__('Border', 'g5plus-academia') => 'bt-bordered',
                                esc_html__('Background','g5plus-academia')=>'bt-bg',
                                esc_html__('Background 3D', 'g5plus-academia') => 'bt-3d',),
                            'description' => esc_html__('Select Layout Style.', 'g5plus-academia')
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Size', 'g5plus-academia'),
                            'param_name' => 'size',
                            'admin_label' => true,
                            'value' => array(
                                esc_html__('Extra Small', 'g5plus-academia') => 'bt-xs',
                                esc_html__('Small', 'g5plus-academia') => 'bt-sm',
                                esc_html__('Medium', 'g5plus-academia') => 'bt-md',
                                esc_html__('Large', 'g5plus-academia') => 'bt-lg',
                                esc_html__('Extra Large', 'g5plus-academia') => 'bt-xlg'),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Color', 'g5plus-academia'),
                            'param_name' => 'button_color',
                            'value' => array(
                                esc_html__('Primary', 'g5plus-academia') => 'bt-primary',
                                esc_html__('Secondary', 'g5plus-academia') => 'bt-secondary',
                                esc_html__('Tertiary', 'g5plus-academia') => 'bt-tertiary',
                                esc_html__('Gray', 'g5plus-academia') => 'bt-gray',
                                esc_html__('Black', 'g5plus-academia') => 'bt-black',
                                esc_html__('Light','g5plus-academia') => 'bt-light'
                            ),
                            'description' => esc_html__('Select color for your element', 'g5plus-academia'),
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Add icon?', 'g5plus-academia'),
                            'param_name' => 'add_icon',
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Icon library', 'g5plus-academia'),
                            'value' => array(
                                esc_html__('[None]', 'g5plus-academia') => '',
                                esc_html__('Font Awesome', 'g5plus-academia') => 'fontawesome',
                                esc_html__('Open Iconic', 'g5plus-academia') => 'openiconic',
                                esc_html__('Typicons', 'g5plus-academia') => 'typicons',
                                esc_html__('Entypo', 'g5plus-academia') => 'entypo',
                                esc_html__('Linecons', 'g5plus-academia') => 'linecons',
                                esc_html__('Image', 'g5plus-academia') => 'image',
                            ),
                            'param_name' => 'icon_type',
                            'description' => esc_html__('Select icon library.', 'g5plus-academia'),
                            'dependency' => Array('element' => 'add_icon', 'value' => 'yes'),
                        ),
                        $icon_fontawesome,
                        $icon_image,
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Icon Alignment', 'g5plus-academia'),
                            'description' => esc_html__('Select icon alignment.', 'g5plus-academia'),
                            'param_name' => 'i_align',
                            'value' => array(
                                esc_html__('Left', 'g5plus-academia') => 'i-left',
                                esc_html__('Right', 'g5plus-academia') => 'i-right',
                            ),
                            'dependency' => Array('element' => 'add_icon', 'value' => 'yes'),
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));

                vc_map(array(
                    'name' => esc_html__('Call To Action', 'g5plus-academia'),
                    'base' => 'academia_call_action',
                    'class' => '',
                    'icon' => 'fa fa-play',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Title', 'g5plus-academia'),
                            'param_name' => 'title',
                            'value' => '',
                        ),
                        array(
                            'type' => 'textarea',
                            'heading' => esc_html__('Description', 'g5plus-academia'),
                            'param_name' => 'description',
                            'value' => '',
                        ),
                        array(
                            'type' => 'vc_link',
                            'heading' => esc_html__('Link (url)', 'g5plus-academia'),
                            'param_name' => 'link',
                            'value' => '',
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Color Scheme', 'g5plus-academia'),
                            'param_name' => 'color_scheme',
                            'value' => array(
                                esc_html__('Dark', 'g5plus-academia') => 'color-dark',
                                esc_html__('Light', 'g5plus-academia') => 'color-light'),
                            'std'=>'color-light',
                            'description' => esc_html__('Select Color Scheme.', 'g5plus-academia')
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));
                $category = array();
                $categories = get_categories();
                if (is_array($categories)) {
                    foreach ($categories as $cat) {
                        $category[$cat->name] = $cat->slug;
                    }
                }

                vc_map(
                    array(
                        'name' =>  esc_html__('Blog', 'g5plus-academia'),
                        'base' => 'academia_blog',
                        'icon' => 'fa fa-file-text',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params' => array(

                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Blog Style', 'g5plus-academia'),
                                'param_name' => 'type',
                                'value' => array(
                                    esc_html__('List', 'g5plus-academia') => 'list',
                                    esc_html__('Grid', 'g5plus-academia') => 'grid'
                                ),
                                'std' => 'list',
                                'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
                            ),

                            array(
                                "type" => "dropdown",
                                "heading" => esc_html__("Columns", "g5plus-academia"),
                                "param_name" => "columns",
                                "value" => array(
                                    esc_html__('2 columns', "g5plus-academia") => 2,
                                    esc_html__('3 columns', "g5plus-academia") => 3,
                                    esc_html__('4 columns', "g5plus-academia") => 4,
                                ),
                                "description" => esc_html__("How much columns grid", "g5plus-academia"),
                                'dependency' => array(
                                    'element' => 'type',
                                    'value' => array('grid')
                                ),
                                'std' => 2,
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),


                            array(
                                'type' => 'multi-select',
                                'heading' => esc_html__('Narrow Category', 'g5plus-academia'),
                                'param_name' => 'category',
                                'options' => $category
                            ),

                            array(
                                "type" => "textfield",
                                "heading" => esc_html__("Total items", "g5plus-academia"),
                                "param_name" => "max_items",
                                "value" => -1,
                                "description" => esc_html__('Set max limit for items or enter -1 to display all.', 'g5plus-academia')
                            ),

                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Navigation Type', 'g5plus-academia'),
                                'param_name' => 'paging_style',
                                'value' => array(
                                    esc_html__('Show all', 'g5plus-academia') => 'all',
                                    esc_html__('Default', 'g5plus-academia') => 'default',
                                    esc_html__('Load More', 'g5plus-academia') => 'load-more',
                                    esc_html__('Infinity Scroll', 'g5plus-academia') => 'infinity-scroll',
                                ),
                                'std' => 'all',
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                                'dependency' => array(
                                    'element' => 'max_items',
                                    'value' => array('-1')
                                ),
                            ),


                            array(
                                "type" => "textfield",
                                "heading" => esc_html__("Posts per page", "g5plus-academia"),
                                "param_name" => "posts_per_page",
                                "value" => get_option('posts_per_page'),
                                "description" => esc_html__('Number of items to show per page', 'g5plus-academia'),
                                'dependency' => array(
                                    'element' => 'paging_style',
                                    'value' => array('default', 'load-more', 'infinity-scroll'),
                                ),
                                'edit_field_class' => 'vc_col-sm-6 vc_column',
                            ),


                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__('Has Sidebar', 'g5plus-academia'),
                                'param_name' => 'has_sidebar',
                                'std' => '',
                                'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes')
                            ),


                            // Data settings
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Order by', 'g5plus-academia'),
                                'param_name' => 'orderby',
                                'value' => array(
                                    esc_html__('Date', 'g5plus-academia') => 'date',
                                    esc_html__('Order by post ID', 'g5plus-academia') => 'ID',
                                    esc_html__('Author', 'g5plus-academia') => 'author',
                                    esc_html__('Title', 'g5plus-academia') => 'title',
                                    esc_html__('Last modified date', 'g5plus-academia') => 'modified',
                                    esc_html__('Post/page parent ID', 'g5plus-academia') => 'parent',
                                    esc_html__('Number of comments', 'g5plus-academia') => 'comment_count',
                                    esc_html__('Menu order/Page Order', 'g5plus-academia') => 'menu_order',
                                    esc_html__('Meta value', 'g5plus-academia') => 'meta_value',
                                    esc_html__('Meta value number', 'g5plus-academia') => 'meta_value_num',
                                    esc_html__('Random order', 'g5plus-academia') => 'rand',
                                ),
                                'description' => esc_html__('Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'g5plus-academia'),
                                'group' => esc_html__('Data Settings', 'g5plus-academia'),
                                'param_holder_class' => 'vc_grid-data-type-not-ids',
                            ),

                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Sorting', 'g5plus-academia'),
                                'param_name' => 'order',
                                'group' => esc_html__('Data Settings', 'g5plus-academia'),
                                'value' => array(
                                    esc_html__('Descending', 'g5plus-academia') => 'DESC',
                                    esc_html__('Ascending', 'g5plus-academia') => 'ASC',
                                ),
                                'param_holder_class' => 'vc_grid-data-type-not-ids',
                                'description' => esc_html__('Select sorting order.', 'g5plus-academia'),
                            ),

                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Meta key', 'g5plus-academia'),
                                'param_name' => 'meta_key',
                                'description' => esc_html__('Input meta key for grid ordering.', 'g5plus-academia'),
                                'group' => esc_html__('Data Settings', 'g5plus-academia'),
                                'param_holder_class' => 'vc_grid-data-type-not-ids',
                                'dependency' => array(
                                    'element' => 'orderby',
                                    'value' => array('meta_value', 'meta_value_num'),
                                ),
                            ),

                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation,
                            $add_el_class
                        )
                    )
                );
                vc_map(array(
                    'name' => esc_html__('Posts', 'g5plus-academia'),
                    'base' => 'academia_post',
                    'icon' => 'fa fa-file-text-o',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'description' => esc_html__('Posts', 'g5plus-academia'),
                    'params' => array(
                        array(
                            'type' => 'multi-select',
                            'heading' => esc_html__('Category', 'g5plus-academia'),
                            'param_name' => 'category',
                            'options' => $category
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Display', 'g5plus-academia'),
                            'param_name' => 'display',
                            'admin_label' => true,
                            'value' => array(esc_html__('Random', '') => 'random', esc_html__('Popular', 'g5plus-academia') => 'popular', esc_html__('Recent', 'g5plus-academia') => 'recent', esc_html__('Oldest', 'g5plus-academia') => 'oldest'),
                            'std' => 'recent',
                            'description' => esc_html__('Select Orderby.', 'g5plus-academia')
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Item Amount', 'g5plus-academia'),
                            'param_name' => 'item_amount',
                            'value' => '3',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Column', 'g5plus-academia'),
                            'param_name' => 'column',
                            'value' => '3',
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Slider Style', 'g5plus-academia'),
                            'param_name' => 'is_slider',
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Show pagination control', 'g5plus-academia'),
                            'param_name' => 'dots',
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                            'dependency' => Array('element' => 'is_slider', 'value' => 'yes')
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Show navigation control', 'g5plus-academia'),
                            'param_name' => 'nav',
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                            'dependency' => Array('element' => 'is_slider', 'value' => 'yes')
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Autoplay Timeout', 'g5plus-academia'),
                            'param_name' => 'autoplaytimeout',
                            'description' => esc_html__('Autoplay interval timeout.', 'g5plus-academia'),
                            'value' => '',
                            'dependency' => Array('element' => 'is_slider', 'value' => 'yes'),
                            'std' => 5000
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));
                vc_map(array(
                    'name' => esc_html__('Partner Carousel', 'g5plus-academia'),
                    'base' => 'academia_partner_carousel',
                    'icon' => 'fa fa-user-plus',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'description' => esc_html__('Animated carousel with images', 'g5plus-academia'),
                    'params' => array(
                        array(
                            'type' => 'attach_images',
                            'heading' => esc_html__('Images', 'g5plus-academia'),
                            'param_name' => 'images',
                            'value' => '',
                            'description' => esc_html__('Select images from media library.', 'g5plus-academia')
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Image size', 'g5plus-academia'),
                            'param_name' => 'img_size',
                            'description' => esc_html__('Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'g5plus-academia'),
                            'std' => 'full'
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Image Opacity', 'g5plus-academia'),
                            'param_name' => 'opacity',
                            'value' => array(
                                esc_html__('[none]', 'g5plus-academia') => '',
                                esc_html__('10%', 'g5plus-academia') => '10',
                                esc_html__('20%', 'g5plus-academia') => '20',
                                esc_html__('30%', 'g5plus-academia') => '30',
                                esc_html__('40%', 'g5plus-academia') => '40',
                                esc_html__('50%', 'g5plus-academia') => '50',
                                esc_html__('60%', 'g5plus-academia') => '60',
                                esc_html__('70%', 'g5plus-academia') => '70',
                                esc_html__('80%', 'g5plus-academia') => '80',
                                esc_html__('90%', 'g5plus-academia') => '90',
                                esc_html__('100%', 'g5plus-academia') => '100'
                            ),
                            'std' => '80'
                        ),
                        array(
                            'type' => 'exploded_textarea',
                            'heading' => esc_html__('Custom links', 'g5plus-academia'),
                            'param_name' => 'custom_links',
                            'description' => esc_html__('Enter links for each slide here. Divide links with linebreaks (Enter) . ', 'g5plus-academia'),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Custom link target', 'g5plus-academia'),
                            'param_name' => 'custom_links_target',
                            'description' => esc_html__('Select where to open  custom links.', 'g5plus-academia'),
                            'value' => $target_arr
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Loop', 'g5plus-academia'),
                            'param_name' => 'loop',
                            'description' => esc_html__('Inifnity loop.', 'g5plus-academia'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                            'std' => 'yes',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Center', 'g5plus-academia'),
                            'param_name' => 'center',
                            'description' => esc_html__('Center item. Works well with even an odd number of items.', 'g5plus-academia'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Navigation', 'g5plus-academia'),
                            'param_name' => 'nav',
                            'description' => esc_html__('Show navigation.', 'g5plus-academia'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Pagination', 'g5plus-academia'),
                            'param_name' => 'dots',
                            'description' => esc_html__('Show pagination.', 'g5plus-academia'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Autoplay', 'g5plus-academia'),
                            'param_name' => 'autoplay',
                            'description' => esc_html__('Autoplay.', 'g5plus-academia'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                            'std' => 'yes',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Pause on hover', 'g5plus-academia'),
                            'param_name' => 'autoplayhoverpause',
                            'description' => esc_html__('Pause on mouse hover.', 'g5plus-academia'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                            'std' => 'yes',
                            'edit_field_class' => 'vc_col-sm-6 vc_column'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Autoplay Timeout', 'g5plus-academia'),
                            'param_name' => 'autoplaytimeout',
                            'description' => esc_html__('Autoplay interval timeout.', 'g5plus-academia'),
                            'value' => '',
                            'std' => 5000
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items', 'g5plus-academia'),
                            'param_name' => 'items',
                            'description' => esc_html__('This variable allows you to set the maximum amount of items displayed at a time with the widest browser width', 'g5plus-academia'),
                            'value' => '',
                            'std' => 4
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items Desktop', 'g5plus-academia'),
                            'param_name' => 'itemsdesktop',
                            'description' => esc_html__('Browser Width >= 1200', 'g5plus-academia'),
                            'value' => '',
                            'std' => '4'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items Desktop Small', 'g5plus-academia'),
                            'param_name' => 'itemsdesktopsmall',
                            'description' => esc_html__('Browser Width >= 980', 'g5plus-academia'),
                            'value' => '',
                            'std' => '4'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items Tablet', 'g5plus-academia'),
                            'param_name' => 'itemstablet',
                            'description' => esc_html__('Browser Width >= 768', 'g5plus-academia'),
                            'value' => '',
                            'std' => '3'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items Tablet Small', 'g5plus-academia'),
                            'param_name' => 'itemstabletsmall',
                            'description' => esc_html__('Browser Width >= 600', 'g5plus-academia'),
                            'value' => '',
                            'std' => '2'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Items Mobile', 'g5plus-academia'),
                            'param_name' => 'itemsmobile',
                            'description' => esc_html__('Browser Width < 600', 'g5plus-academia'),
                            'value' => '',
                            'std' => '1'
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));
                vc_map(array(
                    'name' => esc_html__('Headings', 'g5plus-academia'),
                    'base' => 'academia_heading',
                    'class' => '',
                    'icon' => 'fa fa-header',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Title', 'g5plus-academia'),
                            'param_name' => 'title',
                            'value' => '',
                            'admin_label' => true
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Title Size', 'g5plus-academia'),
                            'param_name' => 'title_size',
                            'value' => array(
                                esc_html__('18px', 'g5plus-academia') => 'fs-18',
                                esc_html__('38px', 'g5plus-academia') => 'fs-38'
                            ),
                            'std'=>'fs-38',
                            'description' => esc_html__('Select font size for your element.', 'g5plus-academia'),
                            'admin_label' => true
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Sub Title', 'g5plus-academia'),
                            'param_name' => 'sub_title',
                            'value' => '',
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Show Icon', 'g5plus-academia'),
                            'param_name' => 'show_icon',
                            'description' => esc_html__('Show icon top', 'g5plus-academia'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                            'std' => 'yes',
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Text Align', 'g5plus-academia'),
                            'param_name' => 'text_align',
                            'value' => array(
                                esc_html__('Left', 'g5plus-academia') => 'text-left',
                                esc_html__('Center', 'g5plus-academia') => 'text-center',
                                esc_html__('Right', 'g5plus-academia') => 'text-right'
                            ),
                            'std' => 'text-center',
                            'description' => esc_html__('Select text align.', 'g5plus-academia')
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Color Scheme', 'g5plus-academia'),
                            'param_name' => 'color_scheme',
                            'value' => array(
                                esc_html__('Dark', 'g5plus-academia') => 'color-dark',
                                esc_html__('Light', 'g5plus-academia') => 'color-light'),
                            'description' => esc_html__('Select Color Scheme.', 'g5plus-academia')
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));
                vc_map(
                    array(
                        'name' => esc_html__('Icon Box', 'g5plus-academia'),
                        'base' => 'academia_icon_box',
                        'icon' => 'fa fa-diamond',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'description' => 'Adds icon box with font icons',
                        'params' => array(
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Layout Style', 'g5plus-academia'),
                                'param_name' => 'layout_style',
                                'admin_label' => true,
                                'value' => array(
                                    esc_html__('Icon large, rounded', 'g5plus-academia') => 'style1',
                                    esc_html__('Icon medium, rounded', 'g5plus-academia') => 'style2',
                                    esc_html__('Icon rectangle', 'g5plus-academia') => 'style3',
                                    esc_html__('Icon top', 'g5plus-academia') => 'style4',
                                    esc_html__('Icon small align left', 'g5plus-academia') => 'style5',
                                    esc_html__('Icon small align right', 'g5plus-academia') => 'style6',
                                ),
                                'description' => esc_html__('Select Layout Style.', 'g5plus-academia')
                            ),
                            $icon_type,
                            $icon_fontawesome,
                            $icon_image,
                            array(
                                'type' => 'colorpicker',
                                'heading' => esc_html__('Icon Color','g5plus-academia'),
                                'param_name' => 'icon_color',
                                'value' => '',
                                'description' => esc_html__('Select color for icon','g5plus-academia'),
                                'dependency' =>Array('element' => 'layout_style', 'value' => array('style5','style6'))
                            ),
                            array(
                                'type' => 'colorpicker',
                                'heading' => esc_html__('Icon Background Color','g5plus-academia'),
                                'param_name' => 'icon_bg_color',
                                'value' => '',
                                'description' => esc_html__('Select background color for icon','g5plus-academia'),
                                'dependency' =>Array('element' => 'layout_style', 'value' => array('style2','style3'))
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Title', 'g5plus-academia'),
                                'param_name' => 'title',
                                'value' => '',
                                'description' => esc_html__('Provide the title for this element.', 'g5plus-academia'),
                            ),
                            array(
                                'type' => 'textarea',
                                'heading' => esc_html__('Description', 'g5plus-academia'),
                                'param_name' => 'description',
                                'value' => '',
                                'description' => esc_html__('Provide the description for this element.', 'g5plus-academia'),
                            ),
                            array(
                                'type' => 'vc_link',
                                'heading' => esc_html__('Link (url)', 'g5plus-academia'),
                                'param_name' => 'link',
                                'value' => '',
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Color Scheme', 'g5plus-academia'),
                                'param_name' => 'color_scheme',
                                'value' => array(
                                    esc_html__('Dark', 'g5plus-academia') => 'color-dark',
                                    esc_html__('Light', 'g5plus-academia') => 'color-light'),
                                'description' => esc_html__('Select Color Scheme.', 'g5plus-academia'),
                            ),
                            $add_el_class,
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation
                        )
                    )
                );
                vc_map(
                    array(
                        'name' => esc_html__('Social Icon','g5plus-academia'),
                        'base' => 'academia_social_icon',
                        'icon' => 'fa fa-share-square-o',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params' => array(
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Layout Style','g5plus-academia'),
                                'param_name' => 'layout_style',
                                'admin_label' => true,
                                'value' => array(
                                    esc_html__('Border and Text','g5plus-academia')=>'style1',
                                    esc_html__('Border and Icon','g5plus-academia')=>'style2',
                                    esc_html__('Background and Icon','g5plus-academia')=>'style3',
                                ),
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Size','g5plus-academia'),
                                'param_name' => 'size',
                                'admin_label' => true,
                                'value' => array(
                                    esc_html__('Small','g5plus-academia')=>'size-sm',
                                    esc_html__('Large','g5plus-academia')=>'size-lg',
                                ),
                            ),
                            array(
                                'type' => 'param_group',
                                'heading' => esc_html__('Values','g5plus-academia'),
                                'param_name' => 'values',
                                'description'=>esc_html__('Enter values for title social-icon, icon, color. ','g5plus-academia'),
                                'value' => urlencode(json_encode(array(
                                    array(
                                        'name' => esc_html__('Facebook','g5plus-academia'),
                                        'link' => 'https://www.facebook.com/',
                                    ),
                                    array(
                                        'name' => esc_html__('Twitter','g5plus-academia'),
                                        'link' => 'https://www.twitter.com/',
                                    ),
                                    array(
                                        'name' => esc_html__('Google Plus','g5plus-academia'),
                                        'link' => 'https://www.google.com/',
                                    ),
                                ))),
                                'params' => array(
                                    array(
                                        'type' => 'textfield',
                                        'heading' => esc_html__('Name','g5plus-academia'),
                                        'param_name' => 'name',
                                        'value' => '',
                                        'admin_label' => true,
                                        'description' => esc_html__('Enter Name','g5plus-academia')
                                    ),
                                    array(
                                        'type' => 'textfield',
                                        'heading' => esc_html__('Link','g5plus-academia'),
                                        'param_name' => 'link',
                                        'value' => '',
                                        'std' => '#',
                                        'description' => esc_html__('Enter Link','g5plus-academia')
                                    ),
                                    array(
                                        'type' => 'colorpicker',
                                        'heading' => esc_html__('Color','g5plus-academia'),
                                        'param_name' => 'color',
                                        'value' => '',
                                        'description' => esc_html__('Select color for your element','g5plus-academia')
                                    ),
                                    $icon_type,
                                    $icon_fontawesome,
                                    $icon_image,
                                ),
                            ),
                            $add_el_class,
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation
                        )
                    )
                );
                vc_map(
                    array(
                        'name' => esc_html__('Google Map', 'g5plus-academia'),
                        'base' => 'academia_google_map',
                        'icon' => 'fa fa-map-marker',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params' => array(
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Location X', 'g5plus-academia'),
                                'param_name' => 'location_x',
                                'admin_label' => true,
                                'edit_field_class' => 'vc_col-sm-6',
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Location Y', 'g5plus-academia'),
                                'param_name' => 'location_y',
                                'admin_label' => true,
                                'edit_field_class' => 'vc_col-sm-6',
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Map height', 'g5plus-academia'),
                                'param_name' => 'map_height',
                                'admin_label' => true,
                                'edit_field_class' => 'vc_col-sm-6',
                                'std' => '500px',
                                'description' => esc_html__('Set map height (px or %).', 'g5plus-academia')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Map style', 'g5plus-academia'),
                                'param_name' => 'map_style',
                                'admin_label' => true,
                                'edit_field_class' => 'vc_col-sm-6',
                                'std' => 'gray_scale',
                                'value' => array(
                                    esc_html__('None', 'g5plus-academia') => 'none',
                                    esc_html__('Gray Scale', 'g5plus-academia') => 'gray_scale',
                                    esc_html__('Icy Blue', 'g5plus-academia') => 'icy_blue',
                                    esc_html__('Mono Green', 'g5plus-academia') => 'mono_green',
                                )
                            ),
                            array(
                                'type' => 'number',
                                'heading' => esc_html__('Map zoom', 'g5plus-academia'),
                                'param_name' => 'map_zoom',
                                'admin_label' => true,
                                'std' => '11',
                                'min' => '1',
                                'max' => '16',
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Layout Style', 'g5plus-academia'),
                                'param_name' => 'layout_style',
                                'admin_label' => true,
                                'value' => array(esc_html__('Show Marker Icon', 'g5plus-academia') => 'marker', esc_html__('Show Info Windows', 'g5plus-academia') => 'infowindow'),
                                'description' => esc_html__('Select Layout Style.', 'g5plus-academia'),
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Marker title', 'g5plus-academia'),
                                'param_name' => 'marker_title',
                                'dependency' => array(
                                    'element' => 'layout_style',
                                    'value' => 'marker',
                                ),
                            ),
                            array(
                                'type' => 'attach_image',
                                'heading' => esc_html__( 'Marker Icon', 'g5plus-academia' ),
                                'param_name' => 'marker_icon',
                                'value' => '',
                                'description' => esc_html__( 'Select an image from media library.', 'g5plus-academia' ),
                                'dependency' => array(
                                    'element' => 'layout_style',
                                    'value' => 'marker',
                                ),
                            ),
                            array(
                                'type' => 'textarea_raw_html',
                                'heading' => esc_html__( 'Info Windows HTML', 'g5plus-academia' ),
                                'param_name' => 'info_html',
                                'description' => esc_html__( 'Enter your HTML content.', 'g5plus-academia' ),
                                'dependency' => array(
                                    'element' => 'layout_style',
                                    'value' => 'infowindow',
                                ),
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Max Width', 'g5plus-academia'),
                                'param_name' => 'info_max_width',
                                'std'=>210,
                                'dependency' => array(
                                    'element' => 'layout_style',
                                    'value' => 'infowindow',
                                ),
                            ),
                            array(
                                'type' => 'colorpicker',
                                'heading' => esc_html__('Background color', 'g5plus-academia'),
                                'param_name' => 'info_bg',
                                'value' => '',
                                'dependency' => array(
                                    'element' => 'layout_style',
                                    'value' => 'infowindow',
                                ),
                            ),
                            array(
                                'type' => 'colorpicker',
                                'heading' => esc_html__('Color', 'g5plus-academia'),
                                'param_name' => 'info_color',
                                'value' => '',
                                'dependency' => array(
                                    'element' => 'layout_style',
                                    'value' => 'infowindow',
                                ),
                            ),
                            $add_el_class,
                            $add_css_animation,
                            $add_duration_animation,
                            $add_delay_animation
                        )
                    )
                );
                vc_map( array(
                    'name' => esc_html__( 'Testimonials', 'g5plus-academia' ),
                    'base' => 'academia_testimonial',
                    'icon' => 'fa fa-quote-left',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'param_group',
                            'heading' => esc_html__( 'Testimonials', 'g5plus-academia' ),
                            'param_name' => 'values',
                            'value' => urlencode( json_encode( array(
                                array(
                                    'label' => esc_html__( 'Author', 'g5plus-academia' ),
                                    'value' => '',
                                ),
                            ) ) ),
                            'params' => array(
                                array(
                                    'type' => 'attach_image',
                                    'heading' => esc_html__('Avatar:', 'g5plus-academia'),
                                    'param_name' => 'avatar',
                                    'value' => '',
                                    'description' => esc_html__('Choose the author picture.', 'g5plus-academia'),
                                ),
                                array(
                                    'type' => 'textfield',
                                    'heading' => esc_html__('Author Name', 'g5plus-academia'),
                                    'param_name' => 'author',
                                    'admin_label' => true,
                                    'description' => esc_html__('Enter Author Name.', 'g5plus-academia')
                                ),
                                array(
                                    'type' => 'textfield',
                                    'heading' => esc_html__('Author Info', 'g5plus-academia'),
                                    'param_name' => 'author_info',
                                    'description' => esc_html__('Enter Author information.', 'g5plus-academia')
                                ),
                                array(
                                    'type' => 'textarea',
                                    'heading' => esc_html__('Quote from author', 'g5plus-academia'),
                                    'param_name' => 'quote',
                                    'value' => ''
                                ),
                            ),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Layout Style', 'g5plus-academia'),
                            'param_name' => 'layout_style',
                            'admin_label' => true,
                            'value' => array(esc_html__('Show Avatar', 'g5plus-academia') => 'style1', esc_html__('Hide Avatar', 'g5plus-academia') => 'style2'),
                            'description' => esc_html__('Select Layout Style.', 'g5plus-academia')
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Color Scheme', 'g5plus-academia'),
                            'param_name' => 'color_scheme',
                            'value' => array(
                                esc_html__('Dark', 'g5plus-academia') => 'color-dark',
                                esc_html__('Light', 'g5plus-academia') => 'color-light'),
                            'std' => 'color-light',
                            'description' => esc_html__('Select Color Scheme.', 'g5plus-academia')
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Autoplay Timeout', 'g5plus-academia'),
                            'param_name' => 'autoplaytimeout',
                            'description' => esc_html__('Autoplay interval timeout.', 'g5plus-academia'),
                            'value' => '',
                            'std' => 5000
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ) );
                vc_map( array(
                    'name' => esc_html__( 'Event', 'g5plus-academia' ),
                    'base' => 'academia_event',
                    'icon' => 'fa fa-calendar',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Layout Style', 'g5plus-academia'),
                            'param_name' => 'layout_style',
                            'admin_label' => true,
                            'value' => array(esc_html__('Grid', 'g5plus-academia') => 'style1', esc_html__('Slider', 'g5plus-academia') => 'style2'),
                            'description' => esc_html__('Select Layout Style.', 'g5plus-academia')
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Item Amount', 'g5plus-academia'),
                            'param_name' => 'item_amount',
                            'value' => '7'
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Autoplay Timeout', 'g5plus-academia'),
                            'param_name' => 'autoplaytimeout',
                            'description' => esc_html__('Autoplay interval timeout.', 'g5plus-academia'),
                            'value' => '',
                            'dependency' => array(
                                'element' => 'layout_style',
                                'value' => 'style2',
                            ),
                            'std' => 5000
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ) );
                vc_map( array(
                    'name' => esc_html__( 'Video Background', 'g5plus-academia' ),
                    'base' => 'academia_video_bg',
                    'icon' => 'fa fa-play-circle-o',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'as_parent' => array('except' => 'academia_video_bg'),
                    'content_element' => true,
                    'show_settings_on_create' => true,
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Mp4 link', 'g5plus-academia' ),
                            'param_name' => 'mp4_link',
                            'value' => '',
                            'description' => esc_html__( 'Enter Mp4 link video', 'g5plus-academia' ),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Ogg link', 'g5plus-academia' ),
                            'param_name' => 'ogg_link',
                            'value' => '',
                            'description' => esc_html__( 'Enter Ogg link video', 'g5plus-academia' ),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Webm link', 'g5plus-academia' ),
                            'param_name' => 'webm_link',
                            'value' => '',
                            'description' => esc_html__( 'Enter Webm link video', 'g5plus-academia' ),
                        ),
                        array(
                            'type' => 'attach_image',
                            'heading' => esc_html__( 'Image poster', 'g5plus-academia' ),
                            'param_name' => 'image',
                            'value' => '',
                            'description' => esc_html__( 'Select an image from media library.', 'g5plus-academia' ),
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Muted', 'g5plus-academia'),
                            'param_name' => 'muted',
                            'description' => esc_html__('Set muted video?', 'g5plus-academia'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                            'std'=>'yes'
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => esc_html__('Loop', 'g5plus-academia'),
                            'param_name' => 'loop',
                            'description' => esc_html__('Set loop video?', 'g5plus-academia'),
                            'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes'),
                            'std'=>'yes'
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    ),
                    'js_view' => 'VcColumnView'
                ) );

                vc_map( array(
                    'name'        => esc_html__( 'Course Sections', 'g5plus-academia' ),
                    'base'        => 'academia_course_sections',
                    'icon' => 'fa fa-graduation-cap',
                    'as_parent'   => array('only' => 'academia_course_lesson'),
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params'      => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Section Title', 'g5plus-academia' ),
                            'param_name' => 'title',
                            'holder'	=> 'div'
                        ),
                        array(
                            'type'       => 'css_editor',
                            'heading'    => esc_html__( 'Css', 'g5plus-academia' ),
                            'param_name' => 'css',
                            'group'      => esc_html__( 'Design options', 'g5plus-academia' )
                        )
                    ),
                    'js_view' => 'VcColumnView'
                ) );

                vc_map( array(
                    'name'        => esc_html__( 'Course Schedule', 'g5plus-academia' ),
                    'base'        => 'academia_course_schedule',
                    'icon' => 'fa fa-clock-o',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params'      => array(
                        array(
                            'type'       => 'css_editor',
                            'heading'    => esc_html__( 'Css', 'g5plus-academia' ),
                            'param_name' => 'css'
                        )
                    )
                ) );

                if(class_exists('WooCommerce')){
                    vc_map( array(
                        'name'        => esc_html__( 'Course Feature', 'g5plus-academia' ),
                        'base'        => 'academia_course_feature',
                        'icon' => 'fa fa-graduation-cap',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params'      => array(
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Source', 'g5plus-academia'),
                                'param_name' => 'data_source',
                                'admin_label' => true,
                                'value' => array(
                                    esc_html__('Feature', 'g5plus-academia') => 'feature',
                                    esc_html__('Popular', 'g5plus-academia') => 'popular')
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Number of column', 'g5plus-academia'),
                                'param_name' => 'columns',
                                'value' => array('2' => '2', '3' => '3')
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Number of item', 'g5plus-academia'),
                                'param_name' => 'item',
                                'value' => '',
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__('Slider Style', 'g5plus-academia'),
                                'param_name' => 'is_slider',
                                'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes')
                            ),
                            array(
                                'type'       => 'css_editor',
                                'heading'    => esc_html__( 'Css', 'g5plus-academia' ),
                                'param_name' => 'css',
                                'group'      => esc_html__( 'Design options', 'g5plus-academia' )
                            )

                        )
                    ) );

                    $args = array(
                        'orderby' => 'title',
                        'order' => 'ASC',
                        'pad_counts' => true,
                        'hide_empty' => true,
                    );
                    $product_terms = get_terms('product_cat', $args);
                    $list_product_terms  =array();
                    foreach ($product_terms as $term){
                        $list_product_terms[$term->name] = $term->slug;
                    }
                    vc_map( array(
                        'name'        => esc_html__( 'Course Category', 'g5plus-academia' ),
                        'base'        => 'academia_course_category',
                        'icon' => 'fa fa-graduation-cap',
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params'      => array(
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Tab Style', 'g5plus-academia'),
                                'param_name' => 'tab_style',
                                'value' => array(
                                    esc_html__( 'Icon', 'g5plus-academia' ) => 'icon' ,
                                    esc_html__( 'Text Only', 'g5plus-academia' ) => 'text',
                                )
                            ),
                            array(
                                'type' => 'multi-select',
                                'heading' => esc_html__('Select Category', 'g5plus-academia'),
                                'param_name' => 'category',
                                'options' => $list_product_terms
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Category Active', 'g5plus-academia'),
                                'param_name' => 'category_default',
                                'value' => $list_product_terms
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Number of column', 'g5plus-academia'),
                                'param_name' => 'columns',
                                'value' => array('1' => '1','2' => '2', '3' => '3')
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => esc_html__('Number of item', 'g5plus-academia'),
                                'param_name' => 'item',
                                'value' => '',
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__('Show view all button', 'g5plus-academia'),
                                'param_name' => 'is_show_view_all',
                                'std'=>'yes',
                                'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes')
                            ),
                            array(
                                'type' => 'checkbox',
                                'heading' => esc_html__('Slider Style', 'g5plus-academia'),
                                'param_name' => 'is_slider',
                                'value' => array(esc_html__('Yes, please', 'g5plus-academia') => 'yes')
                            ),
                            array(
                                'type'       => 'css_editor',
                                'heading'    => esc_html__( 'Css', 'g5plus-academia' ),
                                'param_name' => 'css',
                                'group'      => esc_html__( 'Design options', 'g5plus-academia' )
                            )

                        )
                    ) );
                }

                vc_map( array(
                    'name'        => esc_html__( 'Course Search', 'g5plus-academia' ),
                    'base'        => 'academia_course_search',
                    'icon' => 'fa fa-search',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params'      => array(
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Style', 'g5plus-academia'),
                            'param_name' => 'style',
                            'admin_label' => true,
                            'value' => array(
                                esc_html__('Simple style 01', 'g5plus-academia') => 'course-search-simple-01-template',
                                esc_html__('Simple style 02', 'g5plus-academia') => 'course-search-simple-02-template',
                                esc_html__('Advance', 'g5plus-academia') => 'course-search-advance-template')
                        ),
                        array(
                            'type' => 'attach_image',
                            'heading' => esc_html__('Image:', 'g5plus-academia'),
                            'param_name' => 'bg_right_image',
                            'value' => '',
                            'dependency' => array(
                                'element' => 'style',
                                'value' => 'course-search-advance-template',
                            ),
                        ),
                        array(
                            'type'       => 'css_editor',
                            'heading'    => esc_html__( 'Css', 'g5plus-academia' ),
                            'param_name' => 'css',
                            'group'      => esc_html__( 'Design options', 'g5plus-academia' )
                        )

                    )
                ) );

                vc_map( array(
                    'name' => esc_html__( 'Video', 'g5plus-academia' ),
                    'base' => 'academia_video',
                    'icon' => 'fa fa-play-circle',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'attach_image',
                            'heading' => esc_html__( 'Image', 'g5plus-academia' ),
                            'param_name' => 'image',
                            'value' => '',
                            'description' => esc_html__( 'Select an image from media library.', 'g5plus-academia' ),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Link', 'g5plus-academia' ),
                            'param_name' => 'link',
                            'value' => '',
                            'description' => esc_html__( 'Enter link video', 'g5plus-academia' ),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Button Text', 'g5plus-academia' ),
                            'param_name' => 'text',
                            'value' => '',
                            'description' => esc_html__( 'Enter button text', 'g5plus-academia' ),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__( 'Height', 'g5plus-academia' ),
                            'param_name' => 'height',
                            'value' => '',
                            'description' => esc_html__( 'Enter element height', 'g5plus-academia' ),
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ) );
                vc_map(
                    array(
                        'name' => esc_html__('Lesson', 'g5plus-academia'),
                        'base' => 'academia_course_lesson',
                        'class' => '',
                        'icon' => 'fa fa-file-text-o',
                        'as_child' => array('only' => 'course_sections'),
                        'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                        'params' => array(
                            array(
                                "type" => "textfield",
                                "heading" => esc_html__("Title", 'g5plus-academia'),
                                "param_name" => "title",
                                "description" => esc_html__('Set title of lesson.', 'g5plus-academia')
                            ),
                            array(
                                "type" => "textarea_html",
                                "heading" => esc_html__("Content", 'g5plus-academia'),
                                "param_name" => "content",
                                'holder'	=> 'div',
                                'group'	=> 'Lesson Content'
                            ),
                            array(
                                "type" => "checkbox",
                                "heading" => esc_html__("Private", 'g5plus-academia'),
                                "param_name" => "private",
                            ),
                            array(
                                "type" => "textfield",
                                "heading" => esc_html__("Preview Video", 'g5plus-academia'),
                                "param_name" => "preview_video"
                            ),
                            $icon_type,
                            $icon_fontawesome,
                            array(
                                "type" => "textfield",
                                "heading" => esc_html__("Icon tool tip", 'g5plus-academia'),
                                "param_name" => "icon_tool_tip"
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => esc_html__('Badge', 'g5plus-academia'),
                                'param_name' => 'badge',
                                'value' => array(
                                    esc_html__('None', 'g5plus-academia') => '',
                                    esc_html__('Test', 'g5plus-academia') => 'test',
                                    esc_html__('Video', 'g5plus-academia') => 'video',
                                    esc_html__('Exam', 'g5plus-academia') => 'exam',
                                    esc_html__('Quiz', 'g5plus-academia') => 'quiz',
                                    esc_html__('Lecture', 'g5plus-academia') => 'lecture',
                                    esc_html__('Seminar', 'g5plus-academia') => 'seminar',
                                    esc_html__('Free', 'g5plus-academia') => 'free',
                                    esc_html__('Practice', 'g5plus-academia') => 'practice',
                                    esc_html__('Exercise', 'g5plus-academia') => 'exercise',
                                    esc_html__('Activity', 'g5plus-academia') => 'activity',
                                    esc_html__('Final', 'g5plus-academia') => 'final',
                                    esc_html__('End of course', 'g5plus-academia') => 'end-of-course'),
                                'std' => '',
                                'description' => esc_html__('Select lesson badget.', 'g5plus-academia')
                            ),
                            array(
                                "type" => "textfield",
                                "heading" => esc_html__("Estimate time", 'g5plus-academia'),
                                "param_name" => "estimate_time"
                            ),
                            $add_el_class
                        )
                    )
                );

                vc_map( array(
                    "name"     => esc_html__( "Twitter", 'g5plus-academia' ),
                    "base"     => "academia_twitter_shortcode",
                    "class"    => "",
                    "icon"     => "fa fa-twitter",
                    "category" => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    "params"   => array(
                        array(
                            "type"        => "textfield",
                            "heading"     => esc_html__( "Twitter User Name", 'g5plus-academia' ),
                            "param_name"  => "twitter_user_name",
                            "value"       => ''
                        ),
                        array(
                            "type"        => "textfield",
                            "heading"     => esc_html__( "Twitter Consumer Key", 'g5plus-academia' ),
                            "param_name"  => "twitter_consumer_key",
                            "value"       => ''
                        ),
                        array(
                            "type"        => "textfield",
                            "heading"     => esc_html__( "Twitter Consumer Secret", 'g5plus-academia' ),
                            "param_name"  => "twitter_consumer_secret",
                            "value"       => ''
                        ),
                        array(
                            "type"        => "textfield",
                            "heading"     => esc_html__( "Twitter Access Token", 'g5plus-academia' ),
                            "param_name"  => "twitter_access_token",
                            "value"       => ''
                        ),
                        array(
                            "type"        => "textfield",
                            "heading"     => esc_html__( "Twitter Access Token Secret", 'g5plus-academia' ),
                            "param_name"  => "twitter_access_token_secret",
                            "value"       => ''
                        ),
                        array(
                            "type"        => "dropdown",
                            "heading"     => esc_html__( "Paging style", 'g5plus-academia' ),
                            "param_name"  => "paging_style",
                            "value"       => array( esc_html__( "Dot", 'g5plus-academia' ) => "dot", wp_kses_post(__( "Next & Prev", 'g5plus-academia' ))  => "next_prev")
                        ),
                        array(
                            "type"        => "textfield",
                            "heading"     => esc_html__( "Time (minutes) to cache(set empty for no cache)", 'g5plus-academia' ),
                            "param_name"  => "time_to_store",
                            "value"       => ''
                        ),
                        array(
                            "type"        => "textfield",
                            "heading"     => esc_html__( "Total feed", 'g5plus-academia' ),
                            "param_name"  => "total_feed",
                            "value"       => '3'
                        ),
                        array(
                            "type"        => "textfield",
                            "heading"     => esc_html__( "Extra class name", 'g5plus-academia' ),
                            "param_name"  => "css",
                            "value"       => '',
                            "description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'g5plus-academia' )
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));
                vc_map(array(
                    'name' => esc_html__('Feature Box', 'g5plus-academia'),
                    'base' => 'academia_feature',
                    'class' => '',
                    'icon' => 'fa fa-th-list',
                    'category' => G5PLUS_FRAMEWORK_SHORTCODE_CATEGORY,
                    'params' => array(
                        array(
                            'type' => 'attach_image',
                            'heading' => esc_html__('Image:', 'g5plus-academia'),
                            'param_name' => 'image',
                            'value' => '',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Title', 'g5plus-academia'),
                            'param_name' => 'title',
                            'value' => '',
                        ),
                        array(
                            'type' => 'textarea',
                            'heading' => esc_html__('Description', 'g5plus-academia'),
                            'param_name' => 'description',
                            'value' => '',
                        ),
                        array(
                            'type' => 'vc_link',
                            'heading' => esc_html__('Link (url)', 'g5plus-academia'),
                            'param_name' => 'link',
                            'value' => '',
                        ),
                        $add_el_class,
                        $add_css_animation,
                        $add_duration_animation,
                        $add_delay_animation
                    )
                ));

            }
        }
    }

    if (!function_exists('init_g5plus_framework_shortcodes')) {
        function init_g5plus_framework_shortcodes()
        {
            return g5plusFramework_Shortcodes::init();
        }

        init_g5plus_framework_shortcodes();
    }
}