<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 1/20/2016
 * Time: 9:01 AM
 */
$prefix = 'g5plus_';
$g5plus_woocommerce_loop = &G5Plus_Global::get_woocommerce_loop();
$slugs = explode(",", $category);
$args_term = array(
    'orderby' => 'title',
    'order' => 'ASC',
    'pad_counts' => true,
    'hide_empty' => true,
);
$terms = get_terms('product_cat', $args_term);
$course_categories = array();
foreach($terms as $term){
    if(in_array($term->slug,$slugs)){
        array_push($course_categories,$term);
    }
}
$tab_class= $tab_style;
if($tab_style=='text'){
    $tab_class.= ' magic-line-container';
}
?>
<div class="course-categories-sc">
<select>
    <?php foreach ($course_categories as $cat) { ?>
        <option value="<?php echo esc_attr($cat->slug) ?>" <?php echo $category_default==$cat->slug ? 'selected' : '' ?>><?php echo wp_kses_post($cat->name); ?></option>
    <?php } ?>
</select>
<ul class="<?php echo esc_attr($tab_class) ?>">
<?php foreach ($course_categories as $cat) {
    $icon_type = g5plus_get_tax_meta($cat->term_id,$prefix.'icon_type');
    $icon = g5plus_get_tax_meta($cat->term_id,$prefix.'icon');
    $icon_bg_color = g5plus_get_tax_meta($cat->term_id,$prefix.'icon_bg_color');
    ?>
        <?php if($tab_style=='icon'){ ?>
            <li class="<?php echo $category_default==$cat->slug ? 'active' : '' ?>" style="background-color: <?php echo esc_attr($icon_bg_color) ?>">
                <a href="javascript:;" class="hastip <?php echo $category_default==$cat->slug ? 'active' : '' ?>" data-tab-id="<?php echo esc_attr($cat->slug) ?>" title="<?php echo esc_attr($cat->name); ?>">
                    <i class="<?php echo esc_attr($icon) ?>"></i>
                </a>

            </li>
        <?php }else{ ?>
            <li class="<?php echo $category_default==$cat->slug ? 'active' : '' ?>">
                <a href="javascript:;" class="<?php echo $category_default==$cat->slug ? 'active' : '' ?>" data-tab-id="<?php echo esc_attr($cat->slug) ?>" >
                    <?php echo wp_kses_post($cat->name) ?>
                </a>
            </li>
        <?php } ?>
    <?php } ?>
    <?php if($tab_style=='text'){ ?>
        <li class="top magic-line"></li>
        <li class="bottom magic-line"></li>
    <?php } ?>
</ul>
    <div class="clear"></div>
<?php
$item = $item =='' ? -1 : $item;
foreach ($course_categories as $cat) {
    $course_args = array(
        'no_found_rows' => 1,
        'posts_per_page' => $item,
        'post_status' => 'publish',
        'post_type' => 'product',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => array($cat->slug)
            )));
    $products = new WP_Query($course_args);

    $g5plus_woocommerce_loop['columns'] = $columns;
    $g5plus_woocommerce_loop['layout'] = $is_slider=='yes' ? 'slider' : '';
    $g5plus_woocommerce_loop['view']='view-grid'; //display grid
    ?>
    <div class="course-tab <?php echo $category_default==$cat->slug ? ' active' : '' ?>" data-tab-id="<?php echo esc_attr($cat->slug) ?>">
        <?php if($tab_style=='icon'){ ?>
            <div class="heading color-dark text-left ">
                <h2 class="heading-color fs-28"><?php echo wp_kses_post($cat->name); ?></h2>
                <?php if($is_show_view_all=='yes'){ ?>
                    <a class="bt bt-bg bt-xs bt-tertiary" href="<?php echo get_term_link( $cat ) ?>" target="_self"><?php esc_html_e('View All','g5plus-academia') ?></a>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="list-course">
            <?php if ( $products->have_posts() ) : ?>
                <?php woocommerce_product_loop_start(); ?>

                <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                    <?php wc_get_template_part( 'content', 'product' ); ?>

                <?php endwhile; // end of the loop. ?>

                <?php woocommerce_product_loop_end(); ?>

            <?php endif;
            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();
            ?>
        </div>
        <?php if($tab_style=='text' && $is_show_view_all=='yes'){ ?>
            <div class="view-all-wrap">
                <a class="bt bt-bg bt-xs bt-tertiary" href="<?php echo get_term_link( $cat ) ?>" target="_self"><?php esc_html_e('View All','g5plus-academia') ?></a>
            </div>
        <?php } ?>

    </div>
<?php
}
?>
</div>
