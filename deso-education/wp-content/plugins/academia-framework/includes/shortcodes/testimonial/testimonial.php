<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_ShortCode_Testimonial')) {
    class g5plusFramework_ShortCode_Testimonial
    {
        function __construct()
        {
            add_shortcode('academia_testimonial', array($this, 'testimonial_shortcode'));
        }

        function testimonial_shortcode($atts)
        {
            /**
             * Shortcode attributes
             * @var $layout_style
             * @var $color_scheme
             * @var $autoplaytimeout
             * @var $values
             * @var $el_class
             * @var $css_animation
             * @var $duration
             * @var $delay
             */
            $layout_style=$color_scheme=$autoplaytimeout=$values=$el_class=$css_animation=$duration=$delay='';
            $atts = vc_map_get_attributes( 'academia_testimonial', $atts );
            extract( $atts );
            $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            $g5plus_options = &academia_get_options_config();
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('academia_testimonial_css', plugins_url('academia-framework/includes/shortcodes/testimonial/assets/css/testimonial' . $min_suffix_css . '.css'), array(), false);
            $values = (array) vc_param_group_parse_atts( $values );
            ob_start();
            if($layout_style=='style1')
            {
                wp_enqueue_style('academia_fotorama_css', plugins_url('academia-framework/includes/shortcodes/testimonial/assets/css/fotorama.css'), array(), false);
                wp_enqueue_script('academia_fotorama_js', plugins_url('academia-framework/includes/shortcodes/testimonial/assets/js/fotorama.js'), array(), false, true);
                ?>
                <div class="testimonial container style1 <?php echo esc_attr($color_scheme.$g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?>>
                    <div class="fotorama" data-nav="thumbs" data-transition="crossfade" data-width="100%" data-height="240" data-autoplay="<?php echo esc_attr($autoplaytimeout); ?>" data-thumbwidth="70" data-thumbheight="70" data-thumbmargin="10">
                        <?php
                        foreach ( $values as $data ) {
                            $avatar = isset( $data['avatar'] ) ? $data['avatar'] : '';
                            $quote = isset( $data['quote'] ) ? $data['quote'] : '';
                            $author = isset( $data['author'] ) ? $data['author'] : '';
                            $author_info = isset( $data['author_info'] ) ? $data['author_info'] : '';
                            $image = wp_get_attachment_image_src( $avatar, 'full' );
                            ?>
                            <div class="testimonial-item" data-thumb=" <?php echo esc_url($image[0]); ?>">
                                <p><?php echo esc_html($quote)?></p>
                                <h4 class="s-color"><?php echo esc_html($author)?></h4>
                                <span><?php echo esc_html($author_info)?></span>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
            }
            else
            {
                $data_carousel = '"autoplay": true,"loop":true,"center":false,"animateOut":"fadeOut","autoplayHoverPause":true,"autoplayTimeout":'.$autoplaytimeout.',"items":1,"responsive":{},"dots": true, "nav":false';
                ?>
                <div class="testimonial container style2 <?php echo esc_attr($color_scheme.$g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration,$delay); ?>>
                    <div data-plugin-options='{<?php echo esc_attr($data_carousel) ?>}' class="owl-g5plus-shortcode owl-carousel">
                        <?php
                        foreach ( $values as $data ) {
                            $quote = isset( $data['quote'] ) ? $data['quote'] : '';
                            $author = isset( $data['author'] ) ? $data['author'] : '';
                            $author_info = isset( $data['author_info'] ) ? $data['author_info'] : '';
                            ?>
                            <div class="testimonial-item">
                                <p><?php echo esc_html($quote)?></p>
                                <h4 class="s-color"><?php echo esc_html($author)?></h4>
                                <span><?php echo esc_html($author_info)?></span>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
            }
            $content = ob_get_clean();
            return $content;
        }
    }
    new g5plusFramework_ShortCode_Testimonial();
}