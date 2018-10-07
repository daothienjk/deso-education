<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/17/2015
 * Time: 5:29 PM
 */
class G5Plus_Widget_Posts extends  G5Plus_Widget {
    public function __construct() {
        $this->widget_cssclass    = 'widget-posts';
        $this->widget_description = esc_html__( "Posts widget", 'g5plus-academia' );
        $this->widget_id          = 'g5plus-posts';
        $this->widget_name        = esc_html__( 'G5Plus: Posts', 'g5plus-academia' );
        $this->settings           = array(
            'title' => array(
                'type' => 'text',
                'std' => '',
                'label' => esc_html__('Title','g5plus-academia')
            ),
            'source'  => array(
                'type'    => 'select',
                'std'     => '',
                'label'   => esc_html__( 'Source', 'g5plus-academia' ),
                'options' => array(
                    'random' => esc_html__('Random','g5plus-academia'),
                    'popular' => esc_html__('Popular','g5plus-academia'),
                    'recent'  => esc_html__( 'Recent', 'g5plus-academia' ),
                    'oldest' => esc_html__('Oldest','g5plus-academia')
                )
            ),
            'image'  => array(
                'type'    => 'select',
                'std'     => 'none',
                'label'   => esc_html__( 'Show Image', 'g5plus-academia' ),
                'options' => array(
                    'none' => esc_html__('None','g5plus-academia'),
                    'show' => esc_html__('Show','g5plus-academia'),
                )
            ),
            'number' => array(
                'type'  => 'number',
                'std'   => '5',
                'label' => esc_html__( 'Number of posts to show', 'g5plus-academia' ),
            )
        );
        if(function_exists('vc_map')){
            add_shortcode('g5plusframework_widget_post', array($this, 'vc_widget'));
        }
        parent::__construct();
    }

    function widget( $args, $instance ) {
        if ( $this->get_cached_widget( $args ) )
            return;

        extract( $args, EXTR_SKIP );
        $image = ( ! empty( $instance['image'] ) ) ? $instance['image'] : '';
        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
        $source        = empty( $instance['source'] ) ? '' : $instance['source'];
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;
        $query_args = array();

        switch ($source) {
            case 'random' :
                $query_args = array(
                    'posts_per_page' => $number,
                    'no_found_rows' => true,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                    'orderby' => 'rand',
                    'order' => 'DESC',
                    'post_type' => 'post',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'post_format',
                            'field' => 'slug',
                            'terms' => array('post-format-quote', 'post-format-link', 'post-format-audio','post-format-video'),
                            'operator' => 'NOT IN'
                        )
                    )
                );
                break;
            case 'popular':
                $query_args = array(
                    'posts_per_page' => $number,
                    'no_found_rows' => true,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                    'orderby' => 'comment_count',
                    'order' => 'DESC',
                    'post_type' => 'post',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'post_format',
                            'field' => 'slug',
                            'terms' => array('post-format-quote', 'post-format-link', 'post-format-audio','post-format-video'),
                            'operator' => 'NOT IN'
                        )
                    )
                );
                break;

            case 'recent':
                $query_args = array(
                    'posts_per_page' => $number,
                    'no_found_rows' => true,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                    'post_type' => 'post',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'post_format',
                            'field' => 'slug',
                            'terms' => array('post-format-quote', 'post-format-link', 'post-format-audio','post-format-video'),
                            'operator' => 'NOT IN'
                        )
                    )
                );
                break;
            case 'oldest':
                $query_args = array(
                    'posts_per_page' => $number,
                    'no_found_rows' => true,
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                    'orderby' => 'post_date',
                    'order' => 'ASC',
                    'post_type' => 'post',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'post_format',
                            'field' => 'slug',
                            'terms' => array('post-format-quote', 'post-format-link', 'post-format-audio','post-format-video'),
                            'operator' => 'NOT IN'
                        )
                    )
                );
                break;
        }

        ob_start();
        $r = new WP_Query( $query_args);
        if ($r->have_posts()) : ?>
            <?php echo wp_kses_post($args['before_widget']); ?>
            <?php if ( $title ) {
		        echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
	        } ?>
            <ul class="widget-post">
            <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                <li class="widget_posts_item <?php echo esc_attr($image)?> clearfix">
                    <?php if($image == "show"):?>
                        <?php
                        $size= "blog-widget";
                        $thumbnail = g5plus_post_thumbnail($size);
                        if (!empty($thumbnail)) : ?>
                            <div class="entry-thumbnail-wrap">
                                <?php echo wp_kses_post($thumbnail);?>
                            </div>
                        <?php endif; ?>
                    <?php endif;?>
                    <div class="widget-posts-content-wrap">
                        <?php if($image == "none"):?>
                            <a class="widget-posts-title s-font" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                            <div class="widget-posts-meta s-font">
                                <ul class="entry-meta s-font">
                                    <li><i class="fa fa-calendar"></i><?php echo get_the_date('F j, Y'); ?></li>
                                    <?php if ( comments_open() || get_comments_number() ) : ?>
                                        <li class="entry-meta-comment">
                                            <?php comments_popup_link(wp_kses_post(__('<i class="fa fa-comments"></i> 0','g5plus-academia')) ,
                                                wp_kses_post(__('<i class="fa fa-comments"></i> 1','g5plus-academia')),
                                                wp_kses_post(__('<i class="fa fa-comments"></i> %','g5plus-academia'))); ?>
                                        </li>
                                    <?php endif; ?>
                                    <li class="entry-meta-view">
                                        <i class="fa fa-eye"></i> <?php echo g5plus_get_post_views(get_the_ID());?>
                                    </li>
                                </ul>
                            </div>
                        <?php endif; if($image == "show"):?>
                            <h3 class="entry-post-title s-font">
                                <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <div class="entry-date">
                                <?php echo get_the_date(get_option('date_format')); ?>
                            </div>
                        <?php endif;?>
                    </div>
                </li>
            <?php endwhile; ?>
            </ul>

            <?php echo wp_kses_post($args['after_widget']); ?>
        <?php endif;
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();
        $content =  ob_get_clean();
        echo wp_kses_post($content);
        $this->cache_widget( $args, $content );
    }

    function vc_widget($atts){
        $attributes = vc_map_get_attributes( 'g5plusframework_widget_post', $atts );
        $args = array();
        $args['widget_id'] = 'g5plus-posts';
        $args['widget_cssclass']    = 'widget-posts';
        $args['widget_name']        = esc_html__( 'G5Plus: Posts', 'g5plus-academia' );
        the_widget('G5Plus_Widget_Posts',$attributes,$args);
    }
}

if (!function_exists('g5plus_register_widget_posts')) {
    function g5plus_register_widget_posts() {
        register_widget('G5Plus_Widget_Posts');

        if(function_exists('vc_map')){
            vc_map( array(
                'name' => esc_html__( 'G5Plus Post', 'g5plus-academia' ),
                'base' => 'g5plusframework_widget_post',
                'icon' => 'fa fa-pencil-square-o',
                'category' => esc_html__( 'Academia Widgets', 'g5plus-academia' ),
                'class' => 'wpb_vc_wp_widget',
                'weight' => - 50,
                'description' => esc_html__( 'Post for your site', 'g5plus-academia' ),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Title', 'g5plus-academia' ),
                        'param_name' => 'title'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Source', 'g5plus-academia' ),
                        'param_name' => 'source',
                        'value' => array(
                            esc_html__('Random','g5plus-academia') => 'random',
                            esc_html__('Popular','g5plus-academia') => 'popular',
                            esc_html__( 'Recent', 'g5plus-academia' ) => 'recent',
                            esc_html__('Oldest','g5plus-academia') => 'oldest'
                        )
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Number of post', 'g5plus-academia' ),
                        'param_name' => 'number',
                        'value' => '5'
                    )
                )
            ) );
        }
    }
    add_action('widgets_init', 'g5plus_register_widget_posts', 1);
}