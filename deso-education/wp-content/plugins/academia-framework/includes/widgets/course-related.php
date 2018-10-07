<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 1/5/2016
 * Time: 2:23 PM
 */

class G5Plus_Widget_Course_Related extends  G5Plus_Widget {
    public function __construct() {
        $this->widget_cssclass    = 'widget-course woocommerce';
        $this->widget_description = esc_html__( "Course Related widget", 'g5plus-academia' );
        $this->widget_id          = 'g5plus-course-related';
        $this->widget_name        = esc_html__( 'G5Plus: Course Related', 'g5plus-academia' );
        $this->settings           = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Title','g5plus-academia')
            ),
            'number' => array(
                'type'  => 'number',
                'std'   => '5',
                'label' => esc_html__( 'Number of course to show', 'g5plus-academia' ),
            ),
            'order'  => array(
                'type'    => 'select',
                'std'     => 'random',
                'label'   => esc_html__( 'Order', 'g5plus-academia' ),
                'options' => array(
                    'rand' => esc_html__('Random','g5plus-academia'),
                    'DESC' => esc_html__('Descending','g5plus-academia'),
                    'ASC'  => esc_html__( 'Ascending', 'g5plus-academia' )
                )
            ),
        );
        parent::__construct();
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
        if(!class_exists('WooCommerce')){
            return;
        }
        global $product, $woocommerce_loop;

        if ( empty( $product ) || ! $product->exists() ) {
            return;
        }

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
        $order        = empty( $instance['order'] ) ? '' : $instance['order'];
        $orderby = $order == 'rand' ? $order : 'post_id';
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;

        $defaults = array(
            'posts_per_page' => $number,
            'orderby'        => $orderby,
            'order'          => $order,
        );

        $args = wp_parse_args( $args, $defaults );

        // Get visble related products then sort them at random.
        $related_products = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );

        // Handle orderby.
        $related_products = wc_products_array_orderby( $related_products, $args['orderby'], $args['order'] );

        ob_start();
        if ( $related_products ) : ?>
            <?php echo wp_kses_post($args['before_widget']); ?>
            <?php if ( $title ) {
                echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
            } ?>
            <div class="widget-content">
                <?php woocommerce_product_loop_start(); ?>

                <?php foreach ( $related_products as $related_product ) : ?>

                    <?php
                    $post_object = get_post( $related_product->get_id() );

                    setup_postdata( $GLOBALS['post'] =& $post_object );

                    wc_get_template_part( 'content', 'product-related' ); ?>

                <?php endforeach; ?>

                <?php woocommerce_product_loop_end(); ?>
            </div>
            <?php echo wp_kses_post($args['after_widget']); ?>

        <?php endif;
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();
        $content =  ob_get_clean();
        echo wp_kses_post($content);
    }
}

if (!function_exists('g5plus_register_widget_course_related')) {
    function g5plus_register_widget_course_related() {
        if(class_exists('WooCommerce')){
            register_widget('G5Plus_Widget_Course_Related');
        }
    }
    add_action('widgets_init', 'g5plus_register_widget_course_related', 1);
}
