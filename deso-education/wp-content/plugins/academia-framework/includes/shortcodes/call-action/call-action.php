<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_Call_Action')) {
	class g5plusFramework_Shortcode_Call_Action
	{
		function __construct()
		{
			add_shortcode('academia_call_action', array($this, 'call_action_shortcode'));
		}

		function call_action_shortcode($atts)
		{
			/**
			 * Shortcode attributes
			 * @var $title
             * @var $description
			 * @var $link
             * @var $color_scheme
			 * @var $el_class
			 * @var $css_animation
			 * @var $duration
			 * @var $delay
			 */
            $color_scheme=$title=$description=$link=$el_class=$css_animation=$duration=$delay='';
			$atts = vc_map_get_attributes( 'academia_call_action', $atts );
			extract( $atts );
            $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            $g5plus_options = &academia_get_options_config();
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('academia_call_action_css', plugins_url('academia-framework/includes/shortcodes/call-action/assets/css/call-action' . $min_suffix_css . '.css'), array(), false);
            //parse link
            $link = ( $link == '||' ) ? '' : $link;
            $link = vc_build_link( $link );
			$a_title='';
			$a_target='_self';
			$a_href='#';
            if ( strlen( $link['title'] ) > 0 ) {
                $a_href = $link['url'];
                $a_title = $link['title'];
                $a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
            }
            ob_start();?>
            <div class="call-action <?php echo esc_attr($color_scheme.$g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
                <div class="container">
                    <h3 class="fs-24 fw-bold"><?php echo esc_html($title)?></h3>
                    <?php if(!empty($description)):?>
                        <p class="fs-14"><?php echo wp_kses_post($description)?></p>
                    <?php endif;?>
                    <a class="bt bt-bg bt-tertiary" href="<?php echo esc_url($a_href); ?>"
                       target="<?php echo esc_attr($a_target); ?>"><?php echo esc_html($a_title); ?>
                    </a>
                </div>
            </div>
            <?php
            $content = ob_get_clean();
            return $content;
		}
	}
    new g5plusFramework_Shortcode_Call_Action();
}