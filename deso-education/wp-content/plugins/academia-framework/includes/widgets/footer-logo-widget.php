<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 3/26/15
 * Time: 5:24 PM
 */
class G5Plus_Widget_Footer_Logo extends  G5Plus_Widget {
    public function __construct() {
        $this->widget_cssclass    = 'widget-footer-logo';
        $this->widget_description = esc_html__( "Logo and sub description", 'g5plus-academia' );
        $this->widget_id          = 'g5plus-footer-logo';
        $this->widget_name        = esc_html__( 'G5Plus: Footer Logo', 'g5plus-academia' );
        $this->settings           = array(
	        'image' => array(
		        'type' => 'image',
		        'std' => '',
		        'label' => esc_html__('Image','g5plus-academia')
	        ),
	        'alt' => array(
		        'type' => 'text',
		        'std' => '',
		        'label' => esc_html__('Image Alt','g5plus-academia')
	        ),
            'sub_description'  => array(
                'type'  => 'text-area',
                'std'   => '',
                'label' => esc_html__( 'Sub Description', 'g5plus-academia' )
            ),
	        'read_more' =>  array(
		        'type' => 'text',
		        'std' => '',
		        'label' => esc_html__('Read More Link','g5plus-academia')
	        )
        );
        parent::__construct();
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
        $sub_description  = empty( $instance['sub_description'] ) ? '' : apply_filters( 'widget_sub_description', $instance['sub_description'] );
	    $image   = empty( $instance['image'] ) ? '' : apply_filters( 'widget_image', $instance['image'] );
	    $alt   = empty( $instance['alt'] ) ? '' : apply_filters( 'widget_alt', $instance['alt'] );
	    $read_more = empty( $instance['read_more'] ) ? '' : $instance['read_more'];

        $widget_id = $args['widget_id'];
        echo wp_kses_post($before_widget);
        ?>
        <div class="footer-logo">
            <?php if(isset($image) && $image!='') { ?>
                <a href="<?php echo get_home_url() ?>"><img class="footer-logo-img" src="<?php echo esc_url($image) ?>" alt="<?php echo esc_attr($alt); ?>" /></a>
            <?php } ?>
	        <?php if (!empty($sub_description)) : ?>
	            <div class="sub-description">
	                <?php echo wp_kses_post($sub_description) ?>
	            </div>
		    <?php endif; ?>
	        <?php if (!empty($read_more)) : ?>
		        <div class="footer-logo-read-more">
			        <span><i class="fa fa-angle-right"></i></span> <a href="<?php echo esc_url($read_more); ?>"><?php esc_html_e('Read more','g5plus-academia') ?></a>
		        </div>
	        <?php endif; ?>
        </div>
        <?php
        echo wp_kses_post($after_widget);
    }
}
if (!function_exists('g5plus_register_widget_footer_logo')) {
    function g5plus_register_widget_footer_logo() {
        register_widget('G5Plus_Widget_Footer_Logo');
    }
    add_action('widgets_init', 'g5plus_register_widget_footer_logo', 1);
}