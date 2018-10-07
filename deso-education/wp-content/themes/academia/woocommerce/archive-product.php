<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;
global $woocommerce_loop;
$g5plus_woocommerce_loop = &G5Plus_Global::get_woocommerce_loop();

$layout_style = isset($_GET['layout']) ? $_GET['layout'] : '';
if (!in_array($layout_style, array('full','container','container-fluid'))) {
    $layout_style =  G5Plus_Global::get_option('archive_product_layout');
}

$sidebar = G5Plus_Global::get_option('archive_product_sidebar','none');

$left_sidebar = G5Plus_Global::get_option('archive_product_left_sidebar');
$right_sidebar = G5Plus_Global::get_option('archive_product_right_sidebar');
$sidebar_width = G5Plus_Global::get_option('archive_product_sidebar_width','large');


// Calculate sidebar column & content column
$sidebar_col = 'col-md-3';
if ($sidebar_width == 'large') {
	$sidebar_col = 'col-md-4';
}

$content_col_number = 12;
if (is_active_sidebar($left_sidebar) && ($sidebar == 'left')) {
	if ($sidebar_width == 'large') {
		$content_col_number -= 4;
	} else {
		$content_col_number -= 3;
	}
}
if (is_active_sidebar($right_sidebar) &&  ($sidebar == 'right')) {
	if ($sidebar_width == 'large') {
		$content_col_number -= 4;
	} else {
		$content_col_number -= 3;
	}
}

$content_col = 'col-md-' . $content_col_number;
if (($content_col_number == 12) && ($layout_style == 'full')) {
	$content_col = '';
}



$archive_display_columns = 3;
$archive_display_columns = isset($_GET['columns']) ? $_GET['columns'] : '';
if (!in_array($archive_display_columns, array('2','3','4'))) {
    $archive_display_columns = G5Plus_Global::get_option('product_display_columns','3');
}

$g5plus_woocommerce_loop['columns'] = $archive_display_columns;

$product_rating = isset($_GET['rating']) ? $_GET['rating'] : '';
if (!in_array($product_rating,array('0','1'))) {
	$product_rating = G5Plus_Global::get_option('product_show_rating',1);
}

$g5plus_woocommerce_loop['rating'] = $product_rating;


$archive_class = array('archive-product-wrap','clearfix');
$archive_class[] = 'layout-' . $layout_style;

$catalog_filter_class = array('catalog-filter clearfix s-font');

$product_show_result_count = G5Plus_Global::get_option('product_show_result_count');
$product_show_catalog_ordering = G5Plus_Global::get_option('product_show_catalog_ordering',1);


if (($product_show_result_count == 0) && ($product_show_catalog_ordering == 0) ) {
    $catalog_filter_class[] = 'catalog-filter-disable';
} else {
    if ($product_show_result_count == 0) {
        $catalog_filter_class[] = 'result-count-disable';
    }

    if ($product_show_catalog_ordering == 0) {
        $catalog_filter_class[] = 'catalog-ordering-disable';
    }
}

get_header( 'shop' ); ?>
<?php
/**
 * @hooked - g5plus_archive_product_heading - 5
 **/
do_action('g5plus_before_archive_product');
?>
<main  class="site-content-archive-product">
    <?php
    /**
     * @hooked - g5plus_shop_page_content - 5
     **/
    do_action('g5plus_before_archive_product_listing');
    ?>

    <?php if ($layout_style != 'full'): ?>
        <div class="<?php echo esc_attr($layout_style) ?> clearfix">
    <?php endif;?>

            <?php if (($content_col_number != 12) || ($layout_style != 'full')): ?>
                <div class="row clearfix">
            <?php endif;?>

	                <?php if (is_active_sidebar( $left_sidebar ) && ($sidebar == 'left') ): ?>
                        <div class="primary-sidebar sidebar left-sidebar <?php echo esc_attr($sidebar_col) ?> hidden-sm hidden-xs sidebar-<?php echo esc_attr($sidebar_width); ?>">
			                <?php dynamic_sidebar( $left_sidebar );?>
                        </div>
	                <?php endif;?>

                    <div class="<?php echo esc_attr($content_col) ?>">
                        <div class="<?php echo join(' ',$archive_class); ?>">
                            <?php
                            if ( woocommerce_product_loop() ) {
                                ?>

                                <div class="<?php echo join(' ',$catalog_filter_class) ?>">
		                            <?php
		                            /**
		                             * woocommerce_before_shop_loop hook
		                             *
		                             * @hooked g5plus_woocommerce_filter_button - 10
		                             */
		                            do_action( 'g5plus_woocommerce_before_shop_loop' );
		                            ?>
		                            <?php if(is_search()){ ?>
                                        <div class="archive-search-result">
                                            <h6 class="fs-24">
					                            <?php echo sprintf(esc_html__('Search Results for : "%s"','g5plus-academia'),$_GET['s']); ?>
                                            </h6>
                                        </div>
		                            <?php }else{ ?>
                                        <div class="catalog-filter-inner t-bg clearfix">
				                            <?php
				                            /**
				                             * woocommerce_before_shop_loop hook
				                             *
				                             * @hooked woocommerce_result_count - 20
				                             * @hooked woocommerce_catalog_ordering - 30
				                             */
				                            //remove_action('woocommerce_before_shop_loop','woocommerce_catalog_ordering',30);
				                            do_action( 'g5plus_woocommerce_before_shop_filter' );
				                            do_action( 'woocommerce_before_shop_loop' );
				                            ?>
                                        </div>
		                            <?php } ?>
                                </div>

                                <?php
	                            woocommerce_product_loop_start();

	                            if ( wc_get_loop_prop( 'total' ) ) {
		                            while ( have_posts() ) {
			                            the_post();

			                            /**
			                             * Hook: woocommerce_shop_loop.
			                             *
			                             * @hooked WC_Structured_Data::generate_product_data() - 10
			                             */
			                            do_action( 'woocommerce_shop_loop' );

			                            wc_get_template_part( 'content', 'product' );
		                            }
	                            }

	                            woocommerce_product_loop_end();

	                            /**
	                             * Hook: woocommerce_after_shop_loop.
	                             *
	                             * @hooked woocommerce_pagination - 10
	                             */
	                            do_action( 'woocommerce_after_shop_loop' );
                            } else {
	                            /**
	                             * Hook: woocommerce_no_products_found.
	                             *
	                             * @hooked wc_no_products_found - 10
	                             */
	                            do_action( 'woocommerce_no_products_found' );
                            }

                            ?>
                        </div>
                    </div>


	                <?php if (is_active_sidebar( $right_sidebar ) && ($sidebar == 'right')): ?>
                        <div class="primary-sidebar sidebar right-sidebar <?php echo esc_attr($sidebar_col) ?> hidden-sm hidden-xs sidebar-<?php echo esc_attr($sidebar_width); ?>">
			                <?php dynamic_sidebar( $right_sidebar );?>
                        </div>
	                <?php endif;?>

            <?php if (($content_col_number != 12) || ($layout_style != 'full')): ?>
                </div>
            <?php endif;?>

    <?php if ($layout_style != 'full'): ?>
        </div>
    <?php endif;?>
    <?php
        /**
         * @hooked - g5plus_shop_page_content - 5
         **/
        do_action('g5plus_after_archive_product_listing');
    ?>
</main>
<?php get_footer( 'shop' ); ?>

