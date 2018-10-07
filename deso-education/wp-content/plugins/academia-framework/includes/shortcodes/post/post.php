<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 3/4/15
 * Time: 2:41 PM
 */
if (!defined('ABSPATH')) die('-1');
if (!class_exists('g5plusFramework_Shortcode_Post') && (function_exists('g5plus_post_thumbnail'))):
    class g5plusFramework_Shortcode_Post
    {
        function __construct()
        {
            add_shortcode('academia_post', array($this, 'post_shortcode'));
        }

        function post_shortcode($atts)
        {
            /**
             * Shortcode attributes
             * @var $category
             * @var $display
             * @var $item_amount
             * @var $column
             * @var $is_slider
             * @var $nav
             * @var $dots
             * @var $autoplaytimeout
             * @var $el_class
             * @var $css_animation
             * @var $duration
             * @var $delay
             */
            $category = $display = $item_amount = $column = $is_slider = $dots = $nav = $autoplaytimeout= $el_class = $css_animation = $duration = $delay = '';
            $atts = vc_map_get_attributes('academia_post', $atts);
            extract($atts);
            $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            $query['posts_per_page'] = $item_amount;
            $query['no_found_rows'] = true;
            $query['post_status'] = 'publish';
            $query['ignore_sticky_posts'] = true;
            $query['post_type'] = 'post';
            if (!empty($category)) {
                $query['tax_query'] = array(
                    array(
                        'taxonomy' => 'post_format',
                        'field' => 'slug',
                        'terms' => array('post-format-quote', 'post-format-link'),
                        'operator' => 'NOT IN'
                    ),
                    array(
                        'taxonomy' => 'category',
                        'terms' => explode(',', $category),
                        'field' => 'slug',
                        'operator' => 'IN'
                    )
                );
            } else {
                $query['tax_query'] = array(
                    array(
                        'taxonomy' => 'post_format',
                        'field' => 'slug',
                        'terms' => array('post-format-quote', 'post-format-link'),
                        'operator' => 'NOT IN'
                    )
                );
            }
            if ($display == 'random') {
                $query['orderby'] = 'rand';
            } elseif ($display == 'popular') {
                $query['orderby'] = 'comment_count';
            } elseif ($display == 'recent') {
                $query['orderby'] = 'post_date';
                $query['order'] = 'DESC';
            } else {
                $query['orderby'] = 'post_date';
                $query['order'] = 'ASC';
            }
            $r = new WP_Query($query);
            $g5plus_options = &academia_get_options_config();
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('academia_post_css', plugins_url('academia-framework/includes/shortcodes/post/assets/css/post' . $min_suffix_css . '.css'), array(), false);
            ob_start();
            if ($r->have_posts()) :
                ?>
                <div class="a-post <?php echo esc_attr($g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
                    <?php if ($is_slider) :
                        $dots = ($dots == 'yes') ? 'true' : 'false';
                        $nav = ($nav == 'yes') ? 'true' : 'false';
                        $data_carousel = '"autoplay": true,"loop":true,"center":false,"margin":30,"autoplayHoverPause":true,"autoplayTimeout":'.$autoplaytimeout.', "items":' . $column . ',"dots":' . $dots . ', "nav":' . $nav;
                        $data_carousel .= ',"responsive": {"0":{"items": 1},"600":{"items": 1},"768":{"items": 2},"980":{"items": 3},"1200":{"items": ' . $column . '}}';
                        ?>
                            <div data-plugin-options='{<?php echo esc_attr($data_carousel) ?>}' class="owl-g5plus-shortcode owl-carousel">
                            <?php while ($r->have_posts()) : $r->the_post(); ?>
                                <div class="post-item">
                                    <?php
                                    $attach_id = get_post_thumbnail_id();
                                    $img =wpb_resize($attach_id,null,570,570,true);
                                    if (!empty($img)) : ?>
                                        <div class="post-image">
                                            <a href="<?php the_permalink(); ?>" rel="bookmark"
                                               title="<?php the_title(); ?>"><img src="<?php echo wp_kses_post($img['url']) ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">
                                            </a>
                                            <div>
                                                <?php
                                                switch(get_post_format()) {
                                                    case 'image' :
                                                        echo '<p class="p-bg"><i class="fa fa-file-image-o"></i></p>';
                                                        break;
                                                    case 'gallery':
                                                        echo '<p class="p-bg"><i class="fa fa-picture-o"></i></p>';
                                                        break;
                                                    case 'video':
                                                        echo '<p class="p-bg"><i class="fa fa-play-circle-o"></i></p>';
                                                        break;
                                                    case 'audio':
                                                        echo '<p class="p-bg"><i class="fa fa-microphone"></i></p>';
                                                        break;
                                                    case 'aside':
                                                        echo '<p class="p-bg"><i class="fa fa-file-o"></i></p>';
                                                        break;
                                                    default:
                                                        echo '<p class="p-bg"><i class="fa fa-file-text-o"></i></p>';
                                                        break;
                                                }
                                                ?>
                                                <span class="s-bg"><?php echo get_the_date(get_option('date_format')); ?></span>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="post-content">
                                        <h3><a class="heading-color" href="<?php the_permalink(); ?>"
                                               rel="bookmark"
                                               title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                                        <?php
                                        $excerpt = get_the_excerpt();
                                        $excerpt = g5plusFramework_Shortcodes::substr($excerpt, 143, ' ...');
                                        ?>
                                        <p><?php echo($excerpt); ?></p>
                                        <div class="post-entry-meta">
                                            <span class="event-author"><?php the_author(); ?></span>
                                            <span class="event-comment"><?php echo get_comments_number(); ?></span>
                                            <?php if (function_exists('g5plus_get_post_views') ):?>
                                                <span class="event-view"><?php echo g5plus_get_post_views(); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <?php else:?>
                            <div class="row column-equal-height">
                                <?php while ($r->have_posts()) : $r->the_post(); ?>
                                <div class="col-md-<?php echo(12 / esc_attr($column)) ?> col-sm-6 mg-bottom-50">
                                    <div class="post-item">
                                        <?php
                                        $attach_id = get_post_thumbnail_id();
                                        $img =wpb_resize($attach_id,null,570,570,true);
                                        if (!empty($img)) : ?>
                                            <div class="post-image">
                                                <a href="<?php the_permalink(); ?>" rel="bookmark"
                                                   title="<?php the_title(); ?>"><img src="<?php echo wp_kses_post($img['url']) ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">
                                                </a>
                                                <div>
                                                    <?php
                                                    switch(get_post_format()) {
                                                        case 'image' :
                                                            echo '<p class="p-bg"><i class="fa fa-file-image-o"></i></p>';
                                                            break;
                                                        case 'gallery':
                                                            echo '<p class="p-bg"><i class="fa fa-picture-o"></i></p>';
                                                            break;
                                                        case 'video':
                                                            echo '<p class="p-bg"><i class="fa fa-play-circle-o"></i></p>';
                                                            break;
                                                        case 'audio':
                                                            echo '<p class="p-bg"><i class="fa fa-microphone"></i></p>';
                                                            break;
                                                        case 'aside':
                                                            echo '<p class="p-bg"><i class="fa fa-file-o"></i></p>';
                                                            break;
                                                        default:
                                                            echo '<p class="p-bg"><i class="fa fa-file-text-o"></i></p>';
                                                            break;
                                                    }
                                                    ?>
                                                    <span class="s-bg"><?php echo get_the_date(get_option('date_format')); ?></span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="post-content">
                                            <h3><a class="heading-color" href="<?php the_permalink(); ?>"
                                                   rel="bookmark"
                                                   title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                                            <?php
                                            $excerpt = get_the_excerpt();
                                            $excerpt = g5plusFramework_Shortcodes::substr($excerpt, 143, ' ...');
                                            ?>
                                            <p><?php echo($excerpt); ?></p>
                                            <div class="post-entry-meta">
                                                <span class="event-author"><?php the_author(); ?></span>
                                                <span class="event-comment"><?php echo get_comments_number(); ?></span>
                                                <?php if (function_exists('g5plus_get_post_views') ):?>
                                                    <span class="event-view"><?php echo g5plus_get_post_views(); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endwhile;?>
                            </div>
                        <?php endif;?>
                </div>
                <?php
            endif;
            wp_reset_postdata();
            g5plus_archive_loop_reset();
            $content = ob_get_clean();
            return $content;
        }
    }

    new g5plusFramework_Shortcode_Post();
endif;
