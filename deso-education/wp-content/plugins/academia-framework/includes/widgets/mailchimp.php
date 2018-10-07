<?php

/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 11/28/15
 * Time: 9:26 AM
 */
class G5Plus_Widget_MailChimp extends g5plus_acf_widget
{
    public function __construct()
    {
        $this->widget_cssclass = 'widget-mailchimp';
        $this->widget_description = esc_html__("Display Mailchimp", "g5plus-academia");
        $this->widget_id = 'g5plus-mailchimp';
        $this->widget_name = esc_html__('G5Plus: Mailchimp', 'g5plus-academia');
        $this->settings = array(
            'id' => 'mailchimp_acf',
            'type' => 'rows',
            'title' => esc_html__('Mailchimp', 'g5plus-academia'),
            'subtitle' => esc_html__('Display mailchimp on sidebar or in page.', 'g5plus-academia'),
            'extra' => array(
                array(
                    'name' => 'title',
                    'title' => esc_html__('Title', 'g5plus-academia'),
                    'type' => 'text',

                ),
                array(
                    'name' => 'sub_title',
                    'title' => esc_html__('Sub title', 'g5plus-academia'),
                    'type' => 'text-area',

                ),
                array(
                    'name' => 'mailchimp_form',
                    'title' => esc_html__('Shortcode Mailchimp', 'g5plus-academia'),
                    'type' => 'text',

                ),
                array(
                    'name' => 'bg_image',
                    'title' => esc_html__('Background Image', 'g5plus-academia'),
                    'type' => 'image'
                ),
                array(
                    'name'   => 'bg_overlay',
                    'title'   => esc_html__( 'Has background overlay',  'g5plus-academia'),
                    'type'    => 'select',
                    'std'     => '1',
                    'allow_clear' => '1',
                    'options' => array(
                        '1'  => esc_html__( 'Yes', 'g5plus-academia' ),
                        '0' => esc_html__( 'No',  'g5plus-academia' )
                    )
                ),
            )
        );
        parent::__construct();
    }

    function widget($args, $instance)
    {
        extract($args, EXTR_SKIP);
        $widget_id = $args['widget_id'];
        $extra = array_key_exists('extra', $instance) ? $instance['extra'] : array();
        $title = array_key_exists('title', $extra) ? $extra['title'] : '';
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);
        $description = array_key_exists('sub_title', $extra) ? $extra['sub_title'] : '';
        $description = apply_filters('widget_title', $description, $instance, $this->id_base);
        $mailchimp = array_key_exists('mailchimp_form', $extra) ? $extra['mailchimp_form'] : '';
        $bg_image = array_key_exists('bg_image', $extra) ? $extra['bg_image'] : '';
        $bg_overlay = array_key_exists('bg_overlay', $extra) ? $extra['bg_overlay'] : '0';
        $bg_image_url = '';
        if(is_array($bg_image)){
            $bg_image_url = $bg_image['url'];
        }
        $short_code_heading = sprintf('[academia_heading title="%s" size="size-md" sub_title="%s" text_align="text-left" color_scheme="color-light"]', $title, $description);
        echo wp_kses_post($before_widget);
        ?>
        <div class="fullwidth bg-img" style="background-image: url(<?php echo esc_url($bg_image_url); ?>);">
            <?php if($bg_overlay=='1'){ ?>
                <div class="bg-mailchimp-overlay"></div>
            <?php } ?>
           <div class="container">
               <div class="row">
                   <div class="col-md-6">
                       <?php echo do_shortcode($short_code_heading); ?>
                   </div>
                   <div class="col-md-6">
                       <div class="mailchimp color-light entry-content ">
                           <?php echo do_shortcode($mailchimp); ?>
                       </div>
                   </div>
               </div>
           </div>
        </div>
        <?php
        echo wp_kses_post($after_widget);
    }
}

if (!function_exists('g5plus_register_widget_mailchimp')) {
    function g5plus_register_widget_mailchimp()
    {
        register_widget('G5Plus_Widget_MailChimp');
    }

    add_action('widgets_init', 'g5plus_register_widget_mailchimp', 1);
}