<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 9/26/15
 * Time: 3:04 PM
 */

class G5Plus_Widget_Free_Text extends  g5plus_acf_widget {
    public function __construct() {
        $this->widget_cssclass    = 'widget-free-text';
        $this->widget_description = esc_html__( "Display image, free text and link", 'g5plus-academia' );
        $this->widget_id          = 'g5plus-free-text';
        $this->widget_name        = esc_html__( 'G5Plus: Free Text', 'g5plus-academia' );

        $args_pages = array(
            'sort_order' => 'asc',
            'sort_column' => 'post_title',
            'post_type' => 'page',
            'post_status' => 'publish'
        );
        $pages = get_pages($args_pages);
        $list_page = array();
        if(is_array($pages)){
            foreach($pages as $page){
                $list_page[$page->ID] = $page->post_title;
            }
        }
        $args_post = array(
            'posts_per_page'   => -1,
            'orderby'          => 'date',
            'order'            => 'DESC',
            'post_type'        => 'post',
            'post_status'      => 'publish'
        );
        $posts = get_posts($args_post);
        $list_post = array();
        if(is_array($posts)){
            foreach($posts as $post){
                $list_post[$post->ID] = $post->post_title;
            }
        }
        $this->settings           = array(
            'id'          => 'free_text_images_acf',
            'type'        => 'rows',
            'title'       => esc_html__('Slideshow Images', 'g5plus-academia'),
            'subtitle'    => esc_html__('Unlimited slide show image with drag and drop sortings.', 'g5plus-academia'),
            'extra'     => array(
                array(
                    'name'   => 'title_widget',
                    'title'   => esc_html__( 'Title Widget',  'g5plus-academia'),
                    'type'    => 'text',

                ),
                array(
                    'name' => 'image_url',
                    'title' => esc_html__( 'Image',  'g5plus-academia'),
                    'type'  => 'image'
                ),
                array(
                    'name'   => 'image_size_option',
                    'title'   => esc_html__( 'Image size',  'g5plus-academia'),
                    'type'    => 'select',
                    'std'     => '',
                    'allow_clear' => '1',
                    'options' => array(
                        ''  => esc_html__( 'Default', 'g5plus-academia' ),
                        'custom' => esc_html__( 'Custom',  'g5plus-academia' )
                    )
                ),
                array(
                    'name'   => 'image_size_width',
                    'title'   => esc_html__( 'Image size width',  'g5plus-academia'),
                    'type'    => 'text',
                    'require' => array(
                        'element' => 'image_size_option',
                        'compare' => '=',
                        'value' => array('custom')
                    )
                ),
                array(
                    'name'   => 'image_size_height',
                    'title'   => esc_html__( 'Image size height',  'g5plus-academia'),
                    'type'    => 'text',
                    'require' => array(
                        'element' => 'image_size_option',
                        'compare' => '=',
                        'value' => array('custom')
                    )
                ),
                array(
                    'name'  => 'title_free_text',
                    'title' => 'Title free text',
                    'type'  => 'text'
                ),
                array(
                    'name'  => 'free_text',
                    'title' => 'Free text',
                    'type'  => 'text-area'
                ),
                array(
                    'name'   => 'free_text_align',
                    'title'   => esc_html__( 'Free text align',  'g5plus-academia'),
                    'type'    => 'select',
                    'std'     => '',
                    'allow_clear' => '1',
                    'options' => array(
                        'left'  => esc_html__( 'Left', 'g5plus-academia' ),
                        'right' => esc_html__( 'Right',  'g5plus-academia' ),
                        'center' => esc_html__( 'Center',  'g5plus-academia' )
                    )
                ),
                array(
                    'name'   => 'link_type',
                    'title'   => esc_html__( 'Link type',  'g5plus-academia'),
                    'type'    => 'select',
                    'std'     => '',
                    'allow_clear' => '1',
                    'options' => array(
                        'custom'  => esc_html__( 'Custom', 'g5plus-academia' ),
                        'post' => esc_html__( 'Post',  'g5plus-academia' ),
                        'page' => esc_html__( 'page',  'g5plus-academia' )
                    )
                ),
                array(
                    'name'  => 'link_outside',
                    'title' => 'Link read more',
                    'type'  => 'text',
                    'require' => array(
                        'element' => 'link_type',
                        'compare' => '=',
                        'value' => array('custom')
                    )
                ),
                array(
                    'name'   => 'link_post',
                    'title'   => esc_html__( 'Link read more',  'g5plus-academia'),
                    'type'    => 'select',
                    'std'     => '',
                    'allow_clear' => '1',
                    'options' => $list_post,
                    'require' => array(
                        'element' => 'link_type',
                        'compare' => '=',
                        'value' => array('post')
                    )
                ),
                array(
                    'name'   => 'link_page',
                    'title'   => esc_html__( 'Link read more',  'g5plus-academia'),
                    'type'    => 'select',
                    'std'     => '',
                    'allow_clear' => '1',
                    'options' => $list_page,
                    'require' => array(
                        'element' => 'link_type',
                        'compare' => '=',
                        'value' => array('page')
                    )
                ),
                array(
                    'name'   => 'open_type',
                    'title'   => esc_html__( 'Open type',  'g5plus-academia'),
                    'type'    => 'select',
                    'std'     => '',
                    'allow_clear' => '1',
                    'options' => array(
                        '_blank'  => esc_html__( 'New window', 'g5plus-academia' ),
                        '_self' => esc_html__( 'In this window',  'g5plus-academia' ),
                    )
                ),
            )
        );

        if(function_exists('vc_map')){
            add_shortcode('g5plusframework_widget_free_text', array($this, 'vc_widget'));
        }

        parent::__construct();
    }

    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );
        $widget_id = $args['widget_id'];
        $extra = array_key_exists('extra',$instance) ? $instance['extra'] : array() ;
        $image = array_key_exists('image_url',$extra) ? $extra['image_url'] : '';
        $image_url = $image!='' && isset($image['url']) ? $image['url'] : '';
        $title_widget = array_key_exists('title_widget',$extra) ? $extra['title_widget'] : '';
        $title_widget = apply_filters( 'widget_title', $title_widget, $instance, $this->id_base );
        $title_free_text = array_key_exists('title_free_text',$extra) ? $extra['title_free_text'] : '';
        $title_free_text = apply_filters( 'widget_text', $title_free_text, $instance, $this->id_base );
        $free_text_align = array_key_exists('free_text_align',$extra) ? $extra['free_text_align'] : '';
        $free_text = array_key_exists('free_text',$extra) ? $extra['free_text'] : '';
        $free_text = apply_filters( 'widget_text', $free_text, $instance, $this->id_base );
        $image_size_option = array_key_exists('image_size_option',$extra) ? $extra['image_size_option'] : '';
        $image_size_width = array_key_exists('image_size_width',$extra) ? $extra['image_size_width'] : '';
        $image_size_height = array_key_exists('image_size_height',$extra) ? $extra['image_size_height'] : '';

        $link_type = array_key_exists('link_type',$extra) ? $extra['link_type'] : 'custom';
        $open_type = array_key_exists('open_type',$extra) ? $extra['open_type'] : '_blank';
        $link = '';
        if($link_type=='custom'){
            $link = array_key_exists('link_outside',$extra) ? $extra['link_outside'] : '';
        }
        if($link_type=='post'){
            $post_id = array_key_exists('link_post',$extra) ? $extra['link_post'] : '';
            if($post_id!=''){
                $link = get_permalink($post_id);
            }
        }
        if($link_type=='page'){
            $page_id = array_key_exists('link_page',$extra) ? $extra['link_page'] : '';
            if($page_id!=''){
                $link = get_permalink($page_id);
            }
        }

        echo wp_kses_post($before_widget);

        ?>
        <div class="slideshow-images">
            <?php if($title_widget!=''){ ?>
                <h4 class="widget-title">
                    <?php echo esc_html($title_widget) ?>
                </h4>
            <?php } ?>
            <?php if($image_url!=''){ ?>
                <div class="image">
                    <?php
                        if($image_size_option=='custom' && $image_size_width!='' && $image_size_height!=''){
                            $resize = matthewruddy_image_resize($image_url,$image_size_width,$image_size_height);
                            if($resize!=null && is_array($resize) )
                                $image_url = $resize['url'];
                        }
                        ?>
                        <img src="<?php echo esc_url($image_url)?>" alt="<?php echo esc_html__( 'Image Free Text Widget',  'g5plus-academia' ) ?>" />
                </div>
            <?php } ?>
            <?php if($title_free_text!=''){ ?>
                <h4 class="title">
                    <?php echo esc_html($title_free_text) ?>
                </h4>
            <?php } ?>
            <?php if($free_text!=''){ ?>
                <div class="description">
                    <p class="<?php echo esc_attr($free_text_align) ?>"><?php echo esc_html($free_text); ?></p>
                </div>
            <?php } ?>
            <?php if($link!=''){ ?>
                <div class="link">
                    <a class="s-color p-font" href="<?php echo esc_url($link) ?>" target="<?php echo esc_attr($open_type) ?>"><?php echo esc_html__( 'Read more',  'g5plus-academia' ) ?></a>
                </div>
            <?php } ?>
        </div>
        <?php
        echo wp_kses_post($after_widget);
    }

    function vc_widget($atts){
        $attributes = vc_map_get_attributes( 'g5plusframework_widget_free_text', $atts );
        $instance = array();
        $args = array();
        $args['widget_id'] = 'academia-free-text';
        $instance['extra'] = array();
        $instance['extra']['title_widget'] = $attributes['title_widget'];
        $instance['extra']['image_url'] = array();
        if( array_key_exists('image_url',$attributes) && $attributes['image_url']!=''){
            $instance['extra']['image_url']['url'] = wp_get_attachment_url($attributes['image_url']);
        }
        $instance['extra']['image_size_option'] = $attributes['image_size_option'];
        $instance['extra']['image_size_width'] = $attributes['image_size_width'];
        $instance['extra']['image_size_height'] = $attributes['image_size_height'];
        $instance['extra']['title_free_text'] = $attributes['title_free_text'];
        $instance['extra']['free_text'] = $attributes['free_text'];
        $instance['extra']['free_text_align'] = $attributes['free_text_align'];
        $instance['extra']['link_type'] = $attributes['link_type'];
        $instance['extra']['link_outside'] = $attributes['link_outside'];
        $instance['extra']['link_post'] = $attributes['link_post'];
        $instance['extra']['link_page'] = $attributes['link_page'];
        $instance['extra']['open_type'] = $attributes['open_type'];
        the_widget('G5Plus_Widget_Free_Text',$instance,$args);
    }
}
if (!function_exists('g5plus_register_widget_free_text')) {
    function g5plus_register_widget_free_text() {
        register_widget('G5Plus_Widget_Free_Text');

        if(function_exists('vc_map')){
            $args_pages = array(
                'sort_order' => 'asc',
                'sort_column' => 'post_title',
                'post_type' => 'page',
                'post_status' => 'publish'
            );
            $pages = get_pages($args_pages);
            $list_page = array();
            if(is_array($pages)){
                foreach($pages as $page){
                    $list_page[$page->post_title] = $page->ID;
                }
            }
            $args_post = array(
                'posts_per_page'   => -1,
                'orderby'          => 'date',
                'order'            => 'DESC',
                'post_type'        => 'post',
                'post_status'      => 'publish'
            );
            $posts = get_posts($args_post);
            $list_post = array();
            if(is_array($posts)){
                foreach($posts as $post){
                    $list_post[$post->post_title] = $post->ID;
                }
            }

            vc_map( array(
                'name' => 'G5Plus ' . esc_html__( 'Free Text','g5plus-academia'),
                'base' => 'g5plusframework_widget_free_text',
                'icon' => 'fa fa-text-width',
                'category' => esc_html__( 'Academia Widgets', 'g5plus-academia' ),
                'class' => 'wpb_vc_wp_widget',
                'weight' => - 50,
                'description' => esc_html__( 'A custome free text for your site', 'g5plus-academia' ),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Widget title', 'g5plus-academia' ),
                        'param_name' => 'title_widget'
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__( 'User name', 'g5plus-academia' ),
                        'param_name' => 'image_url'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Image size option', 'g5plus-academia' ),
                        'param_name' => 'image_size_option',
                        'value' => array(
                            esc_html__( 'Default', 'g5plus-academia' )  => 'left',
                            esc_html__( 'Custom',  'g5plus-academia' ) => 'custom'
                        )
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Image size width', 'g5plus-academia' ),
                        'param_name' => 'image_size_width',
                        'dependency' => array('element'=>'image_size_option','value'=>'custom')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Image size height', 'g5plus-academia' ),
                        'param_name' => 'image_size_height',
                        'dependency' => array('element'=>'image_size_option','value'=>'custom')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Title free text', 'g5plus-academia' ),
                        'param_name' => 'title_free_text'
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => esc_html__( 'Free text', 'g5plus-academia' ),
                        'param_name' => 'free_text'
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Free text align', 'g5plus-academia' ),
                        'param_name' => 'free_text_align',
                        'value' => array(
                            esc_html__( 'Left', 'g5plus-academia' )  => 'left',
                            esc_html__( 'Right',  'g5plus-academia' ) => 'right',
                            esc_html__( 'Center',  'g5plus-academia' ) => 'center'
                        )
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Link Type', 'g5plus-academia' ),
                        'param_name' => 'link_type',
                        'value' => array(
                            esc_html__( 'custom', 'g5plus-academia' )  => 'custom',
                            esc_html__( 'post',  'g5plus-academia' ) => 'post',
                            esc_html__( 'page',  'g5plus-academia' ) => 'page'
                        )
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__( 'Link read more', 'g5plus-academia' ),
                        'param_name' => 'link_outside',
                        'dependency' => array('element'=>'link_type','value'=>'custom')
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Link read more', 'g5plus-academia' ),
                        'param_name' => 'link_post',
                        'value' => $list_post,
                        'dependency' => array('element'=>'link_type','value'=>'post')
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Link read more', 'g5plus-academia' ),
                        'param_name' => 'link_page',
                        'value' => $list_page,
                        'dependency' => array('element'=>'link_type','value'=>'page')
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__( 'Open type', 'g5plus-academia' ),
                        'param_name' => 'open_type',
                        'value' => array(
                            esc_html__( 'New window', 'g5plus-academia' )  => '_blank',
                            esc_html__( 'In this window',  'g5plus-academia' ) => '_self'
                        )
                    )
                )
            ) );
        }
    }
    add_action('widgets_init', 'g5plus_register_widget_free_text', 1);
}