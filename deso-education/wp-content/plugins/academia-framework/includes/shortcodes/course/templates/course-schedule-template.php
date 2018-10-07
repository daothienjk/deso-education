<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 1/18/2016
 * Time: 2:37 PM
 */
$args = array(
    'orderby' => 'title',
    'order' => 'ASC',
    'pad_counts' => true,
    'hide_empty' => true,
);
$terms = get_terms('product_cat', $args);
$current_term_slug = isset($_GET['cat']) ? $_GET['cat'] : '';
$total = $current_term_slug != '' ? 1 : wp_count_terms('product_cat', array('hide_empty' => false));
$current_page = max(1, get_query_var('paged'));
$post_per_page = 4;
$showing_from = ($current_page - 1) * $post_per_page + 1;
$showing_to = $current_page * $post_per_page;
$showing_to = $showing_to > $total ? $total : $showing_to;
?>
<div class="catalog-filter-inner t-bg clearfix">
    <div class="filter-category-wrap">
    <span class="w-cat">
        <label>
            <select>
                <option
                    value="<?php echo get_permalink(); ?>"><?php esc_html_e('All courses', 'g5plus-academia'); ?></option>
                <?php foreach ($terms as $term):
                    $selected = '0';
                    if (!empty($current_term_slug) and $term->slug == $current_term_slug) {
                        $selected = '1';
                    } else {
                        $selected = '0';
                    }
                    $filter_link = get_permalink() . '?cat=' . $term->slug;
                    ?>
                    <option value="<?php echo esc_url($filter_link); ?>"
                            <?php if ($selected == '1'){ ?>selected<?php } ?>><?php echo wp_kses_post($term->name . ' ( ' . $term->count . ' ) '); ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </span>
    </div>
    <?php if($total>1){ ?>
        <p class="woocommerce-result-count"><?php echo sprintf(esc_html__('Showing %s &#45; %s of %s results','g5plus-academia'),$showing_from,$showing_to,$total) ; ?></p>
    <?php } ?>
</div>
<div class="course-cat-list">
    <?php
    global $wp_query;

    $wp_query->max_num_pages = $total / $post_per_page + ($total % $post_per_page > 0 ? 1 : 0);
    $start = $duration = $location = '&nbsp;';

    $args = array(
        'offset' => ($current_page - 1) * $post_per_page,
        'number' => $post_per_page,
        'orderby' => 'title',
        'order' => 'ASC',
        'slug' => $current_term_slug,
        'pad_counts' => true,
        'hide_empty' => true,
    );
    $terms = get_terms('product_cat', $args);
    foreach ($terms as $term):
        ?>
        <div class="course-cat mg-top-60">
            <div class="heading color-dark text-left ">
                <h2 class="heading-color fs-18"><?php echo wp_kses_post($term->name); ?></h2>
            </div>
            <div class="course mg-top-30">
                <table>
                    <thead>
                        <tr class="fs-13 p-bg">
                            <th class="name"><?php esc_html_e('Course Name', 'g5plus-academia') ?></th>
                            <th class="location"><?php esc_html_e('Location', 'g5plus-academia') ?></th>
                            <th class="date"><?php esc_html_e('Date', 'g5plus-academia') ?></th>
                            <th class="duration"><?php esc_html_e('Duration', 'g5plus-academia') ?></th>
                        </tr>
                    </thead>
                    <?php

                    $course_args = array(
                        'no_found_rows' => 1,
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                        'post_type' => 'product',
                        'orderby' => 'post_title',
                        'order' => 'ASC',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'id',
                                'terms' => array($term->term_id)
                            )));
                    $courses = new WP_Query($course_args);
                    while ($courses->have_posts()) : $courses->the_post();
                        global $product;
                        $post_id = get_the_ID();
                        $start = get_post_meta($post_id, 'duration', true);
                        $location = get_post_meta($post_id, 'location_name', true);
                        if (!isset($start) || $start == '') {
                            $start = '&nbsp;';
                        }
                        if (!isset($location) || $location == '') {
                            $location = '&nbsp;';
                        }

                        ?>
                        <tr class="course-item">
                            <td class="name"> <a href="<?php echo get_permalink(); ?>"> <?php echo get_the_title(); ?></a></td>
                            <td class="location">  <?php echo wp_kses_post($location); ?></td>
                            <td class="date"><?php echo esc_html(date(get_option('date_format'), strtotime(get_post_meta($post_id, 'start', true)))) ?></td>
                            <td class="duration"><?php echo wp_kses_post($start); ?></td>
                        </tr>
                    <?php endwhile;
                    wp_reset_postdata();
                    ?>
                </table>
            </div>
        </div>

    <?php endforeach; ?>
    <?php
    $path = untrailingslashit(plugin_dir_path(__FILE__));
    $template_path = $path . '/pagination.php';
    if (file_exists($template_path)) {
        include($template_path);
    }
    ?>
</div>
