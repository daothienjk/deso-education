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
$data_id = uniqid();
$img = wp_get_attachment_url($bg_right_image);

?>
<div class="course-search advance" data-bg="<?php echo esc_url($img) ?>">
    <div class="title-wrap p-font s-bg">
        <div class="title">
        <span>
            <i class="fa fa-search"></i>
            <?php esc_html_e('Search for all courses', 'g5plus-academia') ?>
        </span>
        </div>
    </div>
    <div class="keyword-wrap p-bg" id="<?php echo esc_attr($data_id) ?>">
        <div class="keyword row">
            <form method="get" id="searchform" action="<?php echo home_url('/'); ?>">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>
                        <select id="product_cat" name="product_cat">
                            <option value=""><?php esc_html_e('All Categories', 'g5plus-academia') ?></option>
                            <?php foreach ($terms as $term) { ?>
                                <option
                                    value="<?php echo esc_attr($term->slug) ?>"><?php echo wp_kses_post($term->name); ?></option>
                            <?php } ?>
                        </select>
                    </label>
                    <label>
                        <select id="location" name="location">
                            <option value=""><?php esc_html_e('All location', 'g5plus-academia') ?></option>
                            <?php
                            $locations = get_course_location();
                            foreach($locations as $location){
                            ?>
                                <option value="<?php echo esc_attr($location) ?>"><?php echo wp_kses_post($location) ?></option>
                            <?php } ?>
                        </select>
                    </label>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>
                        <select id="level" name="level">
                            <option value=""><?php esc_html_e('All level', 'g5plus-academia') ?></option>
                            <?php
                            $levels = get_course_level();
                                foreach($levels as $level){
                            ?>
                                    <?php if (!empty($level)): ?>
                                <option value="<?php echo esc_attr($level) ?>"><?php echo wp_kses_post($level) ?></option>
                                        <?php endif; ?>
                            <?php } ?>
                        </select>
                    </label>
                    <input id="s" name="s" type="text" data-section-id="<?php esc_attr($data_id) ?>"
                           placeholder="<?php esc_html_e('Enter courses name', 'g5plus-academia') ?>"/>
                    <input type="hidden" id="post_type" name="post_type" value="product">
                    <input type="hidden" id="view" name="view" value="view-list">
                </div>
                <div class="action-wrap col-md-12">
                    <button type="submit"
                            class="bt bt-bg bt-xs bt-secondary"><?php esc_html_e('SEARCH NOW', 'g5plus-academia'); ?></button>
                </div>

            </form>

        </div>

    </div>
</div>
