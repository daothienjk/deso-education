<?php
/**
 * Created by PhpStorm.
 * User: phuongth
 * Date: 1/15/2016
 * Time: 11:02 AM
 */

class G5Plus_Widget_Course_Categories extends  G5Plus_Widget {
    public function __construct() {
        $this->widget_cssclass    = 'woocommerce widget_product_categories';
        $this->widget_description = esc_html__( 'A list or dropdown of course categories.', 'g5plus-academia' );
        $this->widget_id          = 'woocommerce_course_categories';
        $this->widget_name        = esc_html__( 'G5Plus: Course Categories', 'g5plus-academia' );
        $this->settings           = array(
            'title'  => array(
                'type'  => 'text',
                'std'   => esc_html__( 'Course Categories', 'g5plus-academia' ),
                'label' => esc_html__( 'Title', 'g5plus-academia' )
            ),
            'orderby' => array(
                'type'  => 'select',
                'std'   => 'name',
                'label' => esc_html__( 'Order by', 'g5plus-academia' ),
                'options' => array(
                    'order' => esc_html__( 'Category Order', 'g5plus-academia' ),
                    'name'  => esc_html__( 'Name', 'g5plus-academia' )
                )
            ),
            'dropdown' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => esc_html__( 'Show as dropdown', 'g5plus-academia' )
            ),
            'count' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => esc_html__( 'Show course counts', 'g5plus-academia' )
            ),
            'hierarchical' => array(
                'type'  => 'checkbox',
                'std'   => 1,
                'label' => esc_html__( 'Show hierarchy', 'g5plus-academia' )
            ),
            'show_children_only' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => esc_html__( 'Only show children of the current category', 'g5plus-academia' )
            )
        );

        parent::__construct();
    }

    function widget( $args, $instance ) {

        if(!class_exists('WooCommerce')){
            return;
        }

        if ( $this->get_cached_widget( $args ) )
            return;
        extract( $args, EXTR_SKIP );
        global $wp_query, $post;
        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
        echo wp_kses_post($args['before_widget']);
        echo wp_kses_post($args['before_title'] . $title . $args['after_title']);


        $c             = isset( $instance['count'] ) ? $instance['count'] : $this->settings['count']['std'];
        $h             = isset( $instance['hierarchical'] ) ? $instance['hierarchical'] : $this->settings['hierarchical']['std'];
        $s             = isset( $instance['show_children_only'] ) ? $instance['show_children_only'] : $this->settings['show_children_only']['std'];
        $d             = isset( $instance['dropdown'] ) ? $instance['dropdown'] : $this->settings['dropdown']['std'];
        $o             = isset( $instance['orderby'] ) ? $instance['orderby'] : $this->settings['orderby']['std'];
        $dropdown_args = array( 'hide_empty' => false );
        $list_args     = array( 'show_count' => $c, 'hierarchical' => $h, 'taxonomy' => 'product_cat', 'hide_empty' => false );

        // Menu Order
        $list_args['menu_order'] = false;
        if ( $o == 'order' ) {
            $list_args['menu_order'] = 'asc';
        } else {
            $list_args['orderby']    = 'title';
        }

        // Setup Current Category
        $this->current_cat   = false;
        $this->cat_ancestors = array();

        if ( is_tax( 'product_cat' ) ) {

            $this->current_cat   = $wp_query->queried_object;
            $this->cat_ancestors = get_ancestors( $this->current_cat->term_id, 'product_cat' );

        } elseif ( is_singular( 'product' ) ) {

            $product_category = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent' ) );

            if ( $product_category ) {
                $this->current_cat   = end( $product_category );
                $this->cat_ancestors = get_ancestors( $this->current_cat->term_id, 'product_cat' );
            }

        }

        // Show Siblings and Children Only
        if ( $s && $this->current_cat ) {

            // Top level is needed
            $top_level = get_terms(
                'product_cat',
                array(
                    'fields'       => 'ids',
                    'parent'       => 0,
                    'hierarchical' => true,
                    'hide_empty'   => false
                )
            );

            // Direct children are wanted
            $direct_children = get_terms(
                'product_cat',
                array(
                    'fields'       => 'ids',
                    'parent'       => $this->current_cat->term_id,
                    'hierarchical' => true,
                    'hide_empty'   => false
                )
            );

            // Gather siblings of ancestors
            $siblings  = array();
            if ( $this->cat_ancestors ) {
                foreach ( $this->cat_ancestors as $ancestor ) {
                    $ancestor_siblings = get_terms(
                        'product_cat',
                        array(
                            'fields'       => 'ids',
                            'parent'       => $ancestor,
                            'hierarchical' => false,
                            'hide_empty'   => false
                        )
                    );
                    $siblings = array_merge( $siblings, $ancestor_siblings );
                }
            }

            if ( $h ) {
                $include = array_merge( $top_level, $this->cat_ancestors, $siblings, $direct_children, array( $this->current_cat->term_id ) );
            } else {
                $include = array_merge( $direct_children );
            }

            $dropdown_args['include'] = implode( ',', $include );
            $list_args['include']     = implode( ',', $include );

            if ( empty( $include ) ) {
                return;
            }

        } elseif ( $s ) {
            $dropdown_args['depth']        = 1;
            $dropdown_args['child_of']     = 0;
            $dropdown_args['hierarchical'] = 1;
            $list_args['depth']            = 1;
            $list_args['child_of']         = 0;
            $list_args['hierarchical']     = 1;
        }

        // Dropdown
        if ( $d ) {
            $dropdown_defaults = array(
                'show_counts'        => $c,
                'hierarchical'       => $h,
                'show_uncategorized' => 0,
                'orderby'            => $o,
                'selected'           => $this->current_cat ? $this->current_cat->slug : ''
            );
            $dropdown_args = wp_parse_args( $dropdown_args, $dropdown_defaults );

            // Stuck with this until a fix for http://core.trac.wordpress.org/ticket/13258
            wc_product_dropdown_categories( apply_filters( 'woocommerce_product_categories_widget_dropdown_args', $dropdown_args ) );

            wc_enqueue_js( "
				jQuery( '.dropdown_product_cat' ).change( function() {
					if ( jQuery(this).val() != '' ) {
						var this_page = '';
						var home_url  = '" . esc_js( home_url( '/' ) ) . "';
						if ( home_url.indexOf( '?' ) > 0 ) {
							this_page = home_url + '&product_cat=' + jQuery(this).val();
						} else {
							this_page = home_url + '?product_cat=' + jQuery(this).val();
						}
						location.href = this_page;
					}
				});
			" );

            // List
        } else {

            $plugin_path = untrailingslashit(plugin_dir_path(__FILE__));
            $template_path = $plugin_path . '/class-product-cat-list-walker.php';
            include_once( $template_path );

            $list_args['walker']                     = new WC_Product_Cat_List_Walker;
            $list_args['title_li']                   = '';
            $list_args['pad_counts']                 = 1;
            $list_args['show_option_none']           = esc_html__('No product categories exist.', 'g5plus-academia' );
            $list_args['current_category']           = ( $this->current_cat ) ? $this->current_cat->term_id : '';
            $list_args['current_category_ancestors'] = $this->cat_ancestors;

            echo '<ul class="product-categories">';

            wp_list_categories( apply_filters( 'woocommerce_product_categories_widget_args', $list_args ) );

            echo '</ul>';
        }
        echo wp_kses_post($args['after_widget']);
    }
}

if (!function_exists('g5plus_register_widget_course_categories')) {
    function g5plus_register_widget_course_categories() {
        if(class_exists('WooCommerce')){
            register_widget('G5Plus_Widget_Course_Categories');
        }

    }
    add_action('widgets_init', 'g5plus_register_widget_course_categories', 1);
}