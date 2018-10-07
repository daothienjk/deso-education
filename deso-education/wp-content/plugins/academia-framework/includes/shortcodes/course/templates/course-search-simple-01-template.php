<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 1/21/2016
 * Time: 5:33 PM
 */

$args_term = array(
    'orderby' => 'title',
    'order' => 'ASC',
    'pad_counts' => true,
    'hide_empty' => true,
);
$terms = get_terms('product_cat', $args_term);
$data_id =  uniqid();
?>
<div class="course-search simple style01 p-bg">
    <div class="title-wrap p-font p-bg-dark">
        <div class="title">
        <span>
            <?php esc_html_e('Search for','g5plus-academia') ?>
        </span>
        <span>
            <?php esc_html_e('Course','g5plus-academia') ?>
        </span>
        </div>
    </div>
    <div class="keyword-wrap" id="<?php echo esc_attr($data_id) ?>">
        <div class="keyword">
            <form method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
                <select id="product_cat" name="product_cat">
                    <option value=""><?php esc_html_e('All Categories','g5plus-academia') ?></option>
                    <?php foreach($terms as $term){ ?>
                        <option value="<?php echo esc_attr($term->slug) ?>"><?php echo wp_kses_post($term->name); ?></option>
                    <?php } ?>
                </select>
                <input id="s" name="s" type="text" data-section-id="<?php esc_attr($data_id) ?>" placeholder="<?php esc_html_e('Enter courses name','g5plus-academia') ?>" />
                <input type="hidden" id="post_type" name="post_type" value="product">
                <input type="hidden" id="view" name="view" value="view-list">
                <button type="submit" class="s-bg"><i class="fa fa-search"></i></button>
            </form>

        </div>

    </div>
</div>
