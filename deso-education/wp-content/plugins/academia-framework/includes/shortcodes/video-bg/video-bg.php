<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_Video_Bg')) {
	class g5plusFramework_Shortcode_Video_Bg
	{
		function __construct()
		{
			add_shortcode('academia_video_bg', array($this, 'video_bg_shortcode'));
		}

		function video_bg_shortcode($atts, $content)
		{
			/**
			 * Shortcode attributes
			 * @var $mp4_link
			 * @var $ogg_link
			 * @var $webm_link
			 * @var $image
			 * @var $muted
			 * @var $loop
			 * @var $el_class
			 * @var $css_animation
			 * @var $duration
			 * @var $delay
			 */
			$muted=$loop=$mp4_link =$ogg_link=$webm_link=$description = $image = $el_class = $g5plus_animation = $css_animation = $duration = $delay = '';
			$atts = vc_map_get_attributes( 'academia_video_bg', $atts );
			extract( $atts );

			$g5plus_options = &academia_get_options_config();
			$min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
			wp_enqueue_style('academia_video_bg_css', plugins_url('academia-framework/includes/shortcodes/video-bg/assets/css/video-bg' . $min_suffix_css . '.css'), array(), false);
			$g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
			$img = wp_get_attachment_image_src($image, 'full');
			ob_start();?>
			<div class="video-bg <?php echo esc_attr($g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
				<video autoplay<?php if($muted=='yes') echo ' muted="muted"'; if($loop=='yes') echo ' loop="loop"';?>
					   preload="auto"
					   poster="<?php echo esc_url($img[0]); ?>">
					<?php if($mp4_link!=''):?>
						<source src="<?php echo esc_url($mp4_link); ?>" type="video/mp4">
					<?php endif;
					if($ogg_link!=''):?>
						<source src="<?php echo esc_url($ogg_link); ?>" type="video/ogg">
					<?php endif;
					if($webm_link!=''):?>
						<source src="<?php echo esc_url($webm_link); ?>" type="video/webm">
					<?php endif;?>
				</video>
				<div class="video-content">
					<?php echo do_shortcode($content) ?>
				</div>
			</div>
			<?php
			$content = ob_get_clean();
			return $content;
		}
	}

	new g5plusFramework_Shortcode_Video_Bg();
}
if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_academia_video_bg extends WPBakeryShortCodesContainer {
	}
}