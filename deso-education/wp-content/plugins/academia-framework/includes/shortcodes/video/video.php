<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_ShortCode_Video')) {
    class g5plusFramework_ShortCode_Video
    {
        function __construct()
        {
            add_shortcode('academia_video', array($this, 'video_shortcode'));
        }

        function video_shortcode($atts)
        {
	        /**
	         * Shortcode attributes
             * @var $image
             * @var $link
	         * @var $text
             * @var $height
             * @var $el_class
             * @var $css_animation
             * @var $duration
             * @var $delay
	         */
            $image=$link=$text=$height=$el_class='';
	        $atts = vc_map_get_attributes( 'academia_video', $atts );
	        extract( $atts );

	        $g5plus_options = &academia_get_options_config();
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('academia_video_css', plugins_url('academia-framework/includes/shortcodes/video/assets/css/video' . $min_suffix_css . '.css'), array(), false);
            $style=' ';
            if (!empty($image)) {
                $bg_images = wp_get_attachment_image_src($image, "full");
                if (isset($bg_images)) {
                    if (!empty($height)) {
                        $style = ' style="height:' . $height . 'px; background-image: url(' . $bg_images[0] . ');"';

                    }else {
                        $style = ' style="background-image: url(' . $bg_images[0] . ');"';
                    }
                }
            }
            elseif(!empty($height)){
                $style = 'style="height:'.$height.'px;"';
            }
            $class = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            ob_start();?>
            <div class="video<?php echo esc_attr($class) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
                <div class="video-bg"<?php echo wp_kses_post($style) ?>>
                    <a class="prettyPhoto p-font" data-rel="prettyPhoto" href="<?php echo esc_url($link) ?>">
                        <?php if($text!=''):?>
                        <span><i class="fa fa-play"></i></span>
                        <p class="fs-32 fw-bold"><?php echo esc_html($text) ?></p>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
    }
    new g5plusFramework_ShortCode_Video();
}