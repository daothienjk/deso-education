<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_ShortCode_Counter')) {
    class g5plusFramework_ShortCode_Counter
    {
        function __construct()
        {
            add_shortcode('academia_counter', array($this, 'counter_shortcode'));
        }

        function counter_shortcode($atts)
        {
	        /**
	         * Shortcode attributes
             * @var $icon_bg_color
             * @var $icon_type
             * @var $icon_image
	         * @var $value
	         * @var $value_color
             * @var $unit
             * @var $unit_color
	         * @var $title
	         * @var $title_color
	         * @var $el_class
	         */
            $unit=$unit_color=$iconClass=$icon_type=$icon_image=$icon_color=$icon_bg_color=$value=$value_color=$title=$title_color=$el_class='';
	        $atts = vc_map_get_attributes( 'academia_counter', $atts );
	        extract( $atts );
            if($icon_type!='' && $icon_type!='image')
            {
                vc_icon_element_fonts_enqueue( $icon_type );
                $iconClass = isset( ${"icon_" . $icon_type} ) ? esc_attr( ${"icon_" . $icon_type} ) : '';
            };
            $g5plus_options = &academia_get_options_config();
            $min_suffix_js = (isset($g5plus_options['enable_minifile_js']) && $g5plus_options['enable_minifile_js'] == 1) ? '.min' : '';
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_script('academia_counter_js', plugins_url('academia-framework/includes/shortcodes/counter/assets/js/jquery.countTo' . $min_suffix_js . '.js'), array(), false, true);
            wp_enqueue_style('academia_counter_css', plugins_url('academia-framework/includes/shortcodes/counter/assets/css/counter' . $min_suffix_css . '.css'), array(), false);
            ob_start();?>
            <div class="counter <?php echo esc_attr($el_class) ?>">
            <?php if($value!=''): ?>
                <div class="counter-icon"<?php $this::bg_color_style($icon_bg_color) ?>>
                <?php if ( $icon_type != '' ) :
                    if ( $icon_type == 'image' ) :
                        $img = wp_get_attachment_image_src( $icon_image, 'full' );?>
                        <img alt="" src="<?php echo esc_url($img[0])?>"/>
                    <?php else :?>
                        <i<?php $this::color_style($icon_color) ?> class="<?php echo esc_attr($iconClass) ?>"></i>
                    <?php endif;
                endif;?>
                </div>
                <span class="display-percentage p-font fs-46 fw-bold"<?php $this::color_style($value_color) ?> data-percentage="<?php echo esc_attr($value) ?>"><?php echo esc_html($value) ?></span>
                <?php if($unit!=''):?>
                <small class="p-font fs-32 fw-bold"<?php $this::color_style($unit_color) ?>><?php echo esc_html($unit) ?></small>
                <?php endif;
                if($title!=''): ?>
                    <p class="fs-14 line-normal"<?php $this::color_style($title_color) ?>><?php echo wp_kses_post($title) ?></p>
                <?php endif;
            endif; ?>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
        }
        function color_style($color)
        {
            if($color!='')
            {
                echo ' style="color: '.$color.'"';
            }
        }
        function bg_color_style($color)
        {
            if($color!='')
            {
                echo ' style="background-color: '.$color.';color: '.$color.'"';
            }
        }
    }
    new g5plusFramework_ShortCode_Counter();
}