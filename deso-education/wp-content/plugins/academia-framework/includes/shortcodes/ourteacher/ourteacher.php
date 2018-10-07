<?php
// don't load directly
if (!defined('ABSPATH')) die('-1');

if (!defined('G5PLUS_OURTEACHER_CATEGORY_TAXONOMY'))
    define('G5PLUS_OURTEACHER_CATEGORY_TAXONOMY', 'ourteacher-category');

if (!defined('G5PLUS_OURTEACHER_POST_TYPE'))
    define('G5PLUS_OURTEACHER_POST_TYPE', 'ourteacher');

if (!defined('G5PLUS_OURTEACHER_DIR_PATH'))
    define('G5PLUS_OURTEACHER_DIR_PATH', plugin_dir_path(__FILE__));

// Include post types
global $ourteacher_metabox;
$ourteacher_metabox = new WPAlchemy_MetaBox(array
(
    'id' => 'academia_ourteacher_social_settings',
    'title' => esc_html__('Social Settings', 'g5plus-academia'),
    'template' => plugin_dir_path(__FILE__) . 'custom-field.php',
    'types' => array('ourteacher'),
    'autosave' => TRUE,
    'priority' => 'high',
    'context' => 'normal',
    'hide_editor' => FALSE
));
if (!class_exists('g5plusFramework_Shortcode_Ourteacher')) {
    class g5plusFramework_Shortcode_Ourteacher
    {
        function __construct()
        {
            add_action('init', array($this, 'register_taxonomies'), 5);
            add_action('init', array($this, 'register_post_types'), 6);
            add_shortcode('academia_ourteacher', array($this, 'ourteacher_shortcode'));
            add_shortcode('academia_ourteacher_social', array($this, 'ourteacher_shortcode_social'));
            add_shortcode('academia_ourteacher_list', array($this, 'ourteacher_list_shortcode'));
            add_filter('single_template', array($this, 'get_ourteacher_single_template'));
            add_filter('rwmb_meta_boxes', array($this, 'register_meta_boxes'));
            if (is_admin()) {
                add_filter('manage_edit-' . G5PLUS_OURTEACHER_POST_TYPE . '_columns', array($this, 'add_columns'));
                add_action('manage_' . G5PLUS_OURTEACHER_POST_TYPE . '_posts_custom_column', array($this, 'set_columns_value'), 10, 2);
                add_action('restrict_manage_posts', array($this, 'manage_posts'));
                add_filter('parse_query', array($this, 'convert_taxonomy_term_in_query'));
                add_action('admin_menu', array($this, 'addMenuChangeSlug'));
            }
        }
        function register_meta_boxes($meta_boxes)
        {
            $meta_boxes[] = array(
                'title' => esc_html__('Contact Info', 'g5plus-academia'),
                'id' => 'academia_ourteacher_contact_info',
                'pages' => array(G5PLUS_OURTEACHER_POST_TYPE),
                'fields' => array(
                    array(
                        'name' => esc_html__('Phone', 'g5plus-academia'),
                        'id' => 'phone',
                        'type' => 'text',
                    ),
                    array(
                        'name' => esc_html__('Mail', 'g5plus-academia'),
                        'id' => 'mail',
                        'type' => 'text',
                    ),
                )
            );
            return $meta_boxes;
        }
        function register_post_types()
        {
            $post_type = G5PLUS_OURTEACHER_POST_TYPE;

            if (post_type_exists($post_type)) {
                return;
            }
            $post_type_slug = get_option('g5plus-academia-' . $post_type . '-config');
            if (!isset($post_type_slug) || !is_array($post_type_slug)) {
                $slug = 'ourteacher';
                $name = $singular_name = 'Our Teacher';
            } else {
                $slug = $post_type_slug['slug'];
                $name = $post_type_slug['name'];
                $singular_name = $post_type_slug['singular_name'];
            }

            register_post_type($post_type,
                array(
                    'label' => esc_html__('Our Teacher', 'g5plus-academia'),
                    'description' => esc_html__('Teacher Information', 'g5plus-academia'),
                    'labels' => array(
                        'name' => $name,
                        'singular_name' => $singular_name,
                        'menu_name' => $name,
                        'parent_item_colon' => esc_html__('Parent Item:', 'g5plus-academia'),
                        'all_items' => sprintf(esc_html__('All %s', 'g5plus-academia'), $name),
                        'view_item' => esc_html__('View Item', 'g5plus-academia'),
                        'add_new_item' => sprintf(esc_html__('Add New  %s', 'g5plus-academia'), $name),
                        'add_new' => esc_html__('Add New', 'g5plus-academia'),
                        'edit_item' => esc_html__('Edit Item', 'g5plus-academia'),
                        'update_item' => esc_html__('Update Item', 'g5plus-academia'),
                        'search_items' => esc_html__('Search Item', 'g5plus-academia'),
                        'not_found' => esc_html__('Not found', 'g5plus-academia'),
                        'not_found_in_trash' => esc_html__('Not found in Trash', 'g5plus-academia'),
                    ),
                    'supports' => array('title', 'editor', 'thumbnail'),
                    'public' => true,
                    'show_ui' => true,
                    '_builtin' => false,
                    'has_archive' => true,
                    'menu_icon' => 'dashicons-screenoptions',
                    'rewrite' => array('slug' => $slug, 'with_front' => true),
                )
            );
            flush_rewrite_rules();
        }

        function register_taxonomies()
        {
            if (taxonomy_exists(G5PLUS_OURTEACHER_CATEGORY_TAXONOMY)) {
                return;
            }

            $post_type = G5PLUS_OURTEACHER_POST_TYPE;
            $taxonomy_slug = G5PLUS_OURTEACHER_CATEGORY_TAXONOMY;
            $taxonomy_name = 'Department';

            $post_type_slug = get_option('g5plus-academia-' . $post_type . '-config');
            if (isset($post_type_slug) && is_array($post_type_slug) &&
                array_key_exists('taxonomy_slug', $post_type_slug) && $post_type_slug['taxonomy_slug'] != ''
            ) {
                $taxonomy_slug = $post_type_slug['taxonomy_slug'];
                $taxonomy_name = $post_type_slug['taxonomy_name'];
            }
            register_taxonomy(G5PLUS_OURTEACHER_CATEGORY_TAXONOMY, G5PLUS_OURTEACHER_POST_TYPE,
                array('hierarchical' => true,
                    'label' => $taxonomy_name,
                    'query_var' => true,
                    'rewrite' => array('slug' => $taxonomy_slug))
            );
            flush_rewrite_rules();
        }

        function addMenuChangeSlug()
        {
            call_user_func('add' . '_submenu_page', 'edit.php?post_type=ourteacher', 'Setting', 'Settings', 'edit_posts', wp_basename(__FILE__), array($this, 'initPageSettings'));
        }

        function initPageSettings()
        {
            $template_path = ABSPATH . 'wp-content/plugins/academia-framework/includes/shortcodes/posttype-settings/settings.php';
            if (file_exists($template_path))
                include_once $template_path;
        }

        function add_columns()
        {
            $columns = array(
                'cb' => '<input type="checkbox" />',
                'title' => esc_html__('Name', 'g5plus-academia'),
                 G5PLUS_OURTEACHER_CATEGORY_TAXONOMY => esc_html__('Department', 'g5plus-academia'),
                'thumbnail' => esc_html__('Avatar', 'g5plus-academia'),
                'date' => esc_html__( 'Date', 'g5plus-academia' )
            );
            return $columns;
        }

        function set_columns_value($column, $post_id)
        {
            switch ($column) {
                case 'thumbnail':
                {
                    echo get_the_post_thumbnail($post_id, 'thumbnail');
                    break;
                }
                case G5PLUS_OURTEACHER_CATEGORY_TAXONOMY:
                {
                    $terms = wp_get_post_terms(get_the_ID(), array(G5PLUS_OURTEACHER_CATEGORY_TAXONOMY));
                    $cat = '<ul>';
                    foreach ($terms as $term) {
                        $cat .= '<li><a href="' . get_term_link($term, G5PLUS_OURTEACHER_CATEGORY_TAXONOMY) . '">' . $term->name . '<a/></li>';
                    }
                    $cat .= '</ul>';
                    echo wp_kses_post($cat);
                    break;
                }
            }
        }
        function manage_posts()
        {
            global $typenow;
            if ($typenow == G5PLUS_OURTEACHER_POST_TYPE) {
                $selected = isset($_GET[G5PLUS_OURTEACHER_CATEGORY_TAXONOMY]) ? $_GET[G5PLUS_OURTEACHER_CATEGORY_TAXONOMY] : '';
                $args = array(
                    'show_count' => true,
                    'show_option_all' => esc_html__('Show All Department', 'g5plus-academia'),
                    'taxonomy' => G5PLUS_OURTEACHER_CATEGORY_TAXONOMY,
                    'name' => G5PLUS_OURTEACHER_CATEGORY_TAXONOMY,
                    'selected' => $selected,

                );
                wp_dropdown_categories($args);
            }
        }
        function convert_taxonomy_term_in_query($query)
        {
            global $pagenow;
            $qv = & $query->query_vars;
            if ($pagenow == 'edit.php' &&
                isset($qv[G5PLUS_OURTEACHER_CATEGORY_TAXONOMY]) &&
                is_numeric($qv[G5PLUS_OURTEACHER_CATEGORY_TAXONOMY])
            ) {
                $term = get_term_by('id', $qv[G5PLUS_OURTEACHER_CATEGORY_TAXONOMY], G5PLUS_OURTEACHER_CATEGORY_TAXONOMY);
                $qv[G5PLUS_OURTEACHER_CATEGORY_TAXONOMY] = $term->slug;
            }
        }
        function get_ourteacher_single_template($single)
        {
            global $post;
            /* Checks for single template by post type */
            if ($post->post_type == G5PLUS_OURTEACHER_POST_TYPE) {
                $plugin_path = untrailingslashit(G5PLUS_OURTEACHER_DIR_PATH);
                $template_path = $plugin_path . '/single-ourteacher.php';
                if (file_exists($template_path))
                    return $template_path;
            }
            return $single;
        }
        function ourteacher_shortcode($atts)
        {
            /**
             * Shortcode attributes
             * @var $item_amount
             * @var $is_slider
             * @var $nav
             * @var $dots
             * @var $autoplaytimeout
             * @var $column
             * @var $category
             * @var $el_class
             * @var $css_animation
             * @var $duration
             * @var $delay
             */
            $item_amount = $is_slider = $nav = $dots = $autoplaytimeout=$column = $category = $el_class = $css_animation = $duration = $delay = '';
            $atts = vc_map_get_attributes('academia_ourteacher', $atts);
            extract($atts);
            $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            global $ourteacher_metabox;
            global $meta;
            $args = array(
                'posts_per_page' => $item_amount,
                'post_type' => G5PLUS_OURTEACHER_POST_TYPE,
                'orderby' => 'date',
                'order' => 'ASC',
                'post_status' => 'publish',
                'post__not_in'=> array(get_the_ID()),
            );

            if ($category != '') {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => G5PLUS_OURTEACHER_CATEGORY_TAXONOMY,
                        'field' => 'slug',
                        'terms' => explode(',', $category),
                        'operator' => 'IN'
                    )
                );
            }
            $data = new WP_Query($args);
            $g5plus_options = &academia_get_options_config();
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('academia_ourteacher_css', plugins_url('academia-framework/includes/shortcodes/ourteacher/assets/css/ourteacher' . $min_suffix_css . '.css'), array(), false);
            ob_start();

            if ($data->have_posts()) :?>
                <div class="ourteacher<?php echo esc_attr($g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
                        <?php if ($is_slider) :
                            $dots = ($dots == 'yes') ? 'true' : 'false';
                            $nav = ($nav == 'yes') ? 'true' : 'false';
                            $data_carousel = '"autoplay": true,"loop":true,"center":false,"margin":30,"autoplayHoverPause":true,"autoplayTimeout":'.$autoplaytimeout.', "items":' . $column . ',"dots":' . $dots . ', "nav":' . $nav;
                            $data_carousel .= ',"responsive": {"0":{"items": 1},"600":{"items": 1},"768":{"items": 2},"980":{"items": 3},"1200":{"items": ' . $column . '}}';
                            ?>
                            <div data-plugin-options='{<?php echo esc_attr($data_carousel) ?>}'
                                 class="owl-g5plus-shortcode owl-carousel">
                                <?php while ($data->have_posts()): $data->the_post();
                                    $attach_id = get_post_thumbnail_id();
                                    $img =wpb_resize($attach_id,null,270,265,true);
                                    ?>
                                    <div class="ourteacher-item">
                                        <div class="ourteacher-avatar">
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                <img src="<?php echo wp_kses_post($img['url']) ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">
                                            </a>
                                            <ul>
                                                <?php
                                                $meta = get_post_meta(get_the_id(), $ourteacher_metabox->get_the_id(), true);
                                                if(is_array($meta))
                                                {
                                                    foreach ($meta['ourteacher'] as $col) {
                                                        $socialName = isset($col['socialName']) ? $col['socialName'] : '';
                                                        $socialLink = isset($col['socialLink']) ? $col['socialLink'] : '';
                                                        $socialIcon = isset($col['socialIcon']) ? $col['socialIcon'] : '';
                                                        ?>
                                                        <li><a href="<?php echo esc_url($socialLink) ?>"
                                                               title="<?php echo esc_url($socialName) ?>"><i
                                                                    class="<?php echo esc_attr($socialIcon) ?>"></i></a>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                        <div class="ourteacher-info">
                                            <a class="text-uppercase show pd-top-20 p-font fs-18 heading-color" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                <?php the_title() ?>
                                            </a>
                                            <span class="text-uppercase show fs-12">
                                                <?php
                                                $terms = wp_get_post_terms(get_the_ID(), array(G5PLUS_OURTEACHER_CATEGORY_TAXONOMY));
                                                $cat_list='';
                                                if (is_array($terms)) {
                                                    foreach ($terms as $term) {
                                                        $cat_list .= $term->name.' - ';
                                                    }
                                                    if($cat_list!='')
                                                    {
                                                        $cat_list=rtrim($cat_list,' - ');
                                                        echo wp_kses_post($cat_list);
                                                    }
                                                }
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php else:
                            $class_col = 'col-md-' . (12 / esc_attr($column)) . ' col-sm-6';
                            ?>
                            <div class="row column-equal-height">
                                <?php while ($data->have_posts()): $data->the_post();
                                    $attach_id = get_post_thumbnail_id();
                                    $img =wpb_resize($attach_id,null,270,265,true);
                                    ?>
                                    <div class="<?php echo esc_attr($class_col); ?> ourteacher-item pd-bottom-20">
                                        <div class="ourteacher-avatar">
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                <img src="<?php echo wp_kses_post($img['url']) ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">
                                            </a>
                                            <ul>
                                                <?php
                                                $meta = get_post_meta(get_the_id(), $ourteacher_metabox->get_the_id(), true);
                                                if(is_array($meta))
                                                {
                                                    foreach ($meta['ourteacher'] as $col) {
                                                        $socialName = isset($col['socialName']) ? $col['socialName'] : '';
                                                        $socialLink = isset($col['socialLink']) ? $col['socialLink'] : '';
                                                        $socialIcon = isset($col['socialIcon']) ? $col['socialIcon'] : '';
                                                        ?>
                                                        <li><a href="<?php echo esc_url($socialLink) ?>"
                                                               title="<?php echo esc_url($socialName) ?>"><i
                                                                    class="<?php echo esc_attr($socialIcon) ?>"></i></a>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                        <div class="ourteacher-info">
                                            <a class="text-uppercase show pd-top-20 p-font fs-18 heading-color" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                <?php the_title() ?>
                                            </a>
                                            <span class="text-uppercase show fs-12">
                                                <?php
                                                $terms = wp_get_post_terms(get_the_ID(), array(G5PLUS_OURTEACHER_CATEGORY_TAXONOMY));
                                                $cat_list='';
                                                if (is_array($terms)) {
                                                    foreach ($terms as $term) {
                                                        $cat_list .= $term->name.' - ';
                                                    }
                                                    if($cat_list!='')
                                                    {
                                                        $cat_list=rtrim($cat_list,' - ');
                                                        echo wp_kses_post($cat_list);
                                                    }
                                                }
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                </div>
            <?php endif;
            wp_reset_postdata();
            $content = ob_get_clean();
            return $content;
        }
        function ourteacher_shortcode_social($atts)
        {
            global $ourteacher_metabox;
            $el_class = $css_animation = $duration = $delay = '';
            $atts = vc_map_get_attributes('academia_ourteacher', $atts);
            extract($atts);
            $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            ob_start();
            $meta = get_post_meta(get_the_id(), $ourteacher_metabox->get_the_id(), true);
            if(is_array($meta))
            {
                ?>
                <ul class="ourteacher-social<?php echo esc_attr($g5plus_animation) ?>">
                <?php
                foreach ($meta['ourteacher'] as $col) {
                    $socialName = isset($col['socialName']) ? $col['socialName'] : '';
                    $socialLink = isset($col['socialLink']) ? $col['socialLink'] : '';
                    $socialIcon = isset($col['socialIcon']) ? $col['socialIcon'] : '';
                    ?>
                    <li><a href="<?php echo esc_url($socialLink) ?>"
                           title="<?php echo esc_url($socialName) ?>"><i
                                class="<?php echo esc_attr($socialIcon) ?>"></i></a>
                    </li>
                    <?php
                }
                ?>
                </ul>
                <?php
            }
            $content = ob_get_clean();
            return $content;
        }
        function ourteacher_list_shortcode($atts)
        {
            global $ourteacher_metabox;
            global $wp_query;
            $el_class = $css_animation = $duration = $delay =$post_per_page='';
            $atts = vc_map_get_attributes('academia_ourteacher_list', $atts);
            extract($atts);
            $g5plus_animation = ' ' . esc_attr($el_class) . g5plusFramework_Shortcodes::g5plus_get_css_animation($css_animation);
            $min_suffix_css = (isset($g5plus_options['enable_minifile_css']) && $g5plus_options['enable_minifile_css'] == 1) ? '.min' : '';
            wp_enqueue_style('academia_ourteacher_css', plugins_url('academia-framework/includes/shortcodes/ourteacher/assets/css/ourteacher' . $min_suffix_css . '.css'), array(), false);
            $args_terms = array(
                'orderby' => 'title',
                'order' => 'ASC',
                'pad_counts' => true,
                'hide_empty' => true,
            );
            $current_page = max(1, get_query_var('paged'));
            $terms = get_terms(G5PLUS_OURTEACHER_CATEGORY_TAXONOMY, $args_terms);
            $current_term_slug = isset($_GET['cat']) ? $_GET['cat'] : '';
            $teacher_args = array(
                'offset' => ($current_page - 1) * $post_per_page,
                'number' => $post_per_page,
                'posts_per_page' => $post_per_page,
                'post_status' => 'publish',
                'post_type' => G5PLUS_OURTEACHER_POST_TYPE,
            );
            if($current_term_slug!='')
            {
                $teacher_args['tax_query'] = array(
                    array(
                        'taxonomy' => G5PLUS_OURTEACHER_CATEGORY_TAXONOMY,
                        'field' => 'slug',
                        'terms' => $current_term_slug,
                        'operator' => 'IN'
                    )
                );
            }
            $data = new WP_Query($teacher_args);
            $total = $data->found_posts;
            $wp_query->max_num_pages = $total / $post_per_page + ($total % $post_per_page > 0 ? 1 : 0);
            $showing_from = ($current_page - 1) * $post_per_page + 1;
            $showing_to = $current_page * $post_per_page;
            $showing_to = $showing_to > $total ? $total : $showing_to;
            ob_start();
            ?>
            <div class="catalog-filter-inner t-bg mg-bottom-60 clearfix">
                <div class="filter-category-wrap">
                <span class="w-cat">
                    <label>
                        <select>
                            <option value="<?php echo get_permalink(); ?>"><?php esc_html_e('All Teachers', 'g5plus-academia'); ?></option>
                            <?php foreach ($terms as $term):
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
                    <p class="woocommerce-result-count"><?php echo sprintf(esc_html__('Showing %s-%s of %s results','g5plus-academia'),$showing_from,$showing_to,$total) ; ?></p>
                <?php } ?>
            </div>
            <div class="ourteacher-list ourteacher<?php echo esc_attr($g5plus_animation) ?>" <?php echo g5plusFramework_Shortcodes::g5plus_get_style_animation($duration, $delay); ?>>
                <div class="row column-equal-height">
                    <?php while ($data->have_posts()): $data->the_post();
                        $attach_id = get_post_thumbnail_id();
                        $img =wpb_resize($attach_id,null,270,265,true);
                        ?>
                        <div class="col-md-3 col-sm-6 ourteacher-item pd-bottom-20">
                            <div class="ourteacher-avatar">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                    <img src="<?php echo wp_kses_post($img['url']) ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">
                                </a>
                                <ul>
                                    <?php
                                    $meta = get_post_meta(get_the_id(), $ourteacher_metabox->get_the_id(), true);
                                    if(is_array($meta))
                                    {
                                        foreach ($meta['ourteacher'] as $col) {
                                            $socialName = isset($col['socialName']) ? $col['socialName'] : '';
                                            $socialLink = isset($col['socialLink']) ? $col['socialLink'] : '';
                                            $socialIcon = isset($col['socialIcon']) ? $col['socialIcon'] : '';
                                            ?>
                                            <li><a href="<?php echo esc_url($socialLink) ?>"
                                                   title="<?php echo esc_url($socialName) ?>"><i
                                                        class="<?php echo esc_attr($socialIcon) ?>"></i></a>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="ourteacher-info">
                                <a class="text-uppercase show pd-top-20 p-font fs-18 heading-color" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                    <?php the_title() ?>
                                </a>
                                                <span class="text-uppercase show fs-12">
                                                    <?php
                                                    $terms = wp_get_post_terms(get_the_ID(), array(G5PLUS_OURTEACHER_CATEGORY_TAXONOMY));
                                                    $cat_list='';
                                                    if (is_array($terms)) {
                                                        foreach ($terms as $term) {
                                                            $cat_list .= $term->name.' - ';
                                                        }
                                                        if($cat_list!='')
                                                        {
                                                            $cat_list=rtrim($cat_list,' - ');
                                                            echo wp_kses_post($cat_list);
                                                        }
                                                    }
                                                    ?>
                                                </span>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <?php
                if ( $wp_query->max_num_pages > 1 ) :
                    ?>
                    <div class="blog-paging-default mg-bottom-100">
                        <?php echo g5plus_paging_nav();?>
                    </div>
                <?php endif;?>
            </div>
            <?php
            wp_reset_postdata();
            $content = ob_get_clean();
            return $content;
        }
    }
    new g5plusFramework_Shortcode_Ourteacher();
}