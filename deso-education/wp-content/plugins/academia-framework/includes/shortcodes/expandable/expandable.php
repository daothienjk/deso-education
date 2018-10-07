<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_Expandable')) {
	class g5plusFramework_Shortcode_Expandable
	{
		function __construct()
		{
			add_shortcode('academia_expandable', array($this, 'expandable_shortcode'));
		}

		function expandable_shortcode($atts, $content)
		{
			/**
			 * Shortcode attributes
             * @var $collapse
             * @var $more_button_label
             * @var $less_button_label
             * @var $button_position
             * @var $button_bgcolor
             * @var $button_color
             * @var $button_hovercolor
			 * @var $el_class
			 * @var $css_animation
			 * @var $duration
			 * @var $delay
			 */
            $collapse=$more_button_label=$less_button_label=$button_position=$button_bgcolor=$button_color=$button_hovercolor=$el_class=$css_animation=$duration=$delay='';
            $atts = vc_map_get_attributes( 'academia_expandable', $atts );
            extract( $atts );
            $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            $g5plus_options = &academia_get_options_config();
            $min_suffix_js = (isset($g5plus_options['enable_minifile_js']) && $g5plus_options['enable_minifile_js'] == 1) ? '.min' : '';
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_script('academia_expandable_js', plugins_url('academia-framework/includes/shortcodes/expandable/assets/js/expandable' . $min_suffix_js . '.js'), array(), false, true);
            wp_enqueue_style('academia_expandable_css', plugins_url('academia-framework/includes/shortcodes/expandable/assets/css/expandable' . $min_suffix_css . '.css'), array(), false);

            $id = 'exp-'.uniqid();
            $collapse = ($collapse == 'yes') ? '' : ' in';
            $button_style=' style="';
            if($button_color!='')
            {
                $button_style.='color:'.$button_color.';';
            }
            if($button_bgcolor!='')
            {
                $button_style.='background-color:'.$button_bgcolor;
            }
            $button_style.='"';
            ob_start();?>
            <div class="expandable-container <?php echo esc_attr($g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?>>
                <div<?php echo wp_kses_post($button_style) ?> class="expandable-button <?php echo esc_attr($button_position) ?>" data-toggle="collapse" data-target="#<?php echo esc_attr($id) ?>" data-color="<?php echo esc_attr($button_color) ?>" data-hovercolor="<?php echo esc_attr($button_hovercolor) ?>" data-moretext="<?php echo esc_attr($more_button_label) ?>" data-lesstext="<?php echo esc_attr($less_button_label) ?>">
                    <i class="micon icon-downarrows10"></i>
                    <span><?php echo esc_attr($more_button_label) ?></span>
                </div>
                <div id="<?php echo esc_attr($id) ?>" class="expandable-content collapse<?php echo esc_attr($collapse) ?>">
                    <?php echo do_shortcode($content) ?>
                </div>
            </div>
            <?php
            $output = ob_get_clean();
            return $output;
		}
	}
    new g5plusFramework_Shortcode_Expandable();
}
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_academia_expandable extends WPBakeryShortCodesContainer {
    }
}
?>