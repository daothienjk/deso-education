<?php
// don't load directly
if ( ! defined( 'ABSPATH' ) ) die( '-1' );
if(!class_exists('g5plusFramework_Shortcode_Heading')){
    class g5plusFramework_Shortcode_Heading{
        function __construct(){
            add_shortcode('academia_heading', array($this, 'heading_shortcode'));
        }
        function heading_shortcode($atts){
	        /**
	         * Shortcode attributes
	         * @var $title
             * @var $title_size
             * @var $sub_title
             * @var $show_icon
             * @var $text_align
             * @var $color_scheme
	         * @var $el_class
	         * @var $css_animation
	         * @var $duration
	         * @var $delay
	         */
            $show_icon=$title_size = $color_scheme = $text_align = $title = $sub_title = $el_class = $css_animation = $duration = $delay = '';
	        $atts = vc_map_get_attributes( 'academia_heading', $atts );
	        extract( $atts );
	        $g5plus_animation = esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            $heading_class = array('heading', $color_scheme, $text_align , $g5plus_animation);
            ob_start();?>
            <div class="<?php echo join(' ', $heading_class) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
                <?php if($show_icon== 'yes'):?>
                    <span class="s-color"><i class="fa fa-star"></i></span>
                <?php endif;?>
                <?php if(!empty($title)):?>
                <h2 class="heading-color <?php echo esc_attr($title_size)?>">
                    <?php echo wp_kses_post($title)?>
                </h2>
                <?php endif;
                if(!empty($sub_title)):?>
                <p class="fs-14">
                    <?php echo wp_kses_post($sub_title)?>
                </p>
                <?php endif;?>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
    }
    new g5plusFramework_Shortcode_Heading();
}