<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 1/19/2016
 * Time: 3:45 PM
 */
$args_products = array();
$meta_query    = WC()->query->get_meta_query();
switch($data_source){
    case 'feature':{

        $args_products = array(
            'posts_per_page'	=> $item,
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
            'posts_per_page'	=> $item,
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
$g5plus_woocommerce_loop = &G5Plus_Global::get_woocommerce_loop();
$g5plus_woocommerce_loop['columns'] = $columns;
$g5plus_woocommerce_loop['layout'] = 'slider';
$g5plus_woocommerce_loop['dots'] = true;
if ( $products->have_posts() ) : ?>
    <?php woocommerce_product_loop_start(); ?>

    <?php while ( $products->have_posts() ) : $products->the_post(); ?>

        <?php wc_get_template_part( 'content', 'product' ); ?>

    <?php endwhile; // end of the loop. ?>

    <?php woocommerce_product_loop_end(); ?>

<?php endif;
// Reset the global $the_post as this query will have stomped on it
wp_reset_postdata();
if($data_source=='popular'){
    remove_filter( 'posts_clauses', array($this, 'academia_order_by_rating_post_clauses' ) );
}
?>