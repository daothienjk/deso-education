<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 1/5/2016
 * Time: 2:23 PM
 */

class G5Plus_Widget_Course extends  G5Plus_Widget {
    public function __construct() {
        $this->widget_cssclass    = 'widget-course woocommerce';
        $this->widget_description = esc_html__( "Course widget", 'g5plus-academia' );
        $this->widget_id          = 'g5plus-course';
        $this->widget_name        = esc_html__( 'G5Plus: Course', 'g5plus-academia' );
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
            'source'  => array(
                'type'    => 'select',
                'std'     => 'feature',
                'label'   => esc_html__( 'Source', 'g5plus-academia' ),
                'options' => array(
                    'feature' => esc_html__('Feature','g5plus-academia'),
                    'popular'  => esc_html__( 'Popular', 'g5plus-academia' )
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
        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
        $source        = empty( $instance['source'] ) ? '' : $instance['source'];
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;
        $args_products = array();
        $meta_query    = WC()->query->get_meta_query();
        switch($source){
            case 'feature':{
                $meta_query[] = array(
                    'key'   => '_featured',
                    'value' => 'yes'
                );
                $args_products = array(
                    'posts_per_page'	=> $number,
                    'orderby' 			=> 'ID',
                    'order' 			=> 'DESC',
                    'no_found_rows' 	=> 1,
                    'post_status' 		=> 'publish',
                    'post_type' 		=> 'product',
                    'meta_query' 		=> $meta_query
                );

                if (function_exists('wc_get_product_visibility_term_ids')) {
                    $product_visibility_term_ids = wc_get_product_visibility_term_ids();
                    $args_products['tax_query'] = array(
                        array(
                            'taxonomy' => 'product_visibility',
                            'field'    => 'term_taxonomy_id',
                            'terms'    => $product_visibility_term_ids['featured'],
                        ));
                }

                break;
            }
            case 'popular':{
                $args_products = array(
                    'posts_per_page'	=> $number,
                    'orderby' 			=> 'ID',
                    'order' 			=> 'DESC',
                    'no_found_rows' 	=> 1,
                    'post_status' 		=> 'publish',
                    'post_type' 		=> 'product',
                    'meta_query' 		=> $meta_query
                );
                add_filter( 'posts_clauses', array($this, 'academia_order_by_rating_post_clauses' ) );
                break;
            }
        }

        $products = new WP_Query( $args_products );

        ob_start();
        if ( $products->have_posts() ) : ?>
            <?php echo wp_kses_post($args['before_widget']); ?>
            <?php if ( $title ) {
                echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
            } ?>
            <div class="widget-content">
                <?php woocommerce_product_loop_start(); ?>

                <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                    <?php wc_get_template_part( 'content', 'product-related' ); ?>

                <?php endwhile; // end of the loop. ?>

                <?php woocommerce_product_loop_end(); ?>
            </div>
            <?php echo wp_kses_post($args['after_widget']); ?>

        <?php endif;
        if($source=='popular'){
            remove_filter( 'posts_clauses', array($this, 'academia_order_by_rating_post_clauses' ) );
        }
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();
        $content =  ob_get_clean();
        echo wp_kses_post($content);
    }

    function academia_order_by_rating_post_clauses( $args ) {
        global $wpdb;

        $args['where'] .= " AND $wpdb->commentmeta.meta_key = 'rating' ";

        $args['join'] .= "
                LEFT JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
                LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
            ";

        $args['orderby'] = "$wpdb->commentmeta.meta_value DESC";

        $args['groupby'] = "$wpdb->posts.ID";

        return $args;
    }
}

if (!function_exists('g5plus_register_widget_course')) {
    function g5plus_register_widget_course() {
        if(class_exists('WooCommerce')){
            register_widget('G5Plus_Widget_Course');
        }
    }
    add_action('widgets_init', 'g5plus_register_widget_course', 1);
}
