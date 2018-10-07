<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 5/28/2015
 * Time: 5:18 PM
 */
if (!class_exists('g5plusFramework_Admin')) {
    class g5plusFramework_Admin
    {

        private $prefix;


        private $version;


        public function __construct($prefix, $version)
        {
            $this->prefix = $prefix;
            $this->version = $version;

            add_action('wp_ajax_popup_icon', array($this, 'popup_icon'));
        }

        /**
         * Register the stylesheets for the admin area.
         *
         * @since    1.0.0
         */
        public function enqueue_styles()
        {

            $pages = isset($_GET['page']) ? $_GET['page'] : '';
            if ($pages == '_options') return;

            wp_enqueue_style($this->prefix . 'admin', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME . '/admin/assets/css/admin.css'), array(), $this->version, 'all');

            wp_enqueue_style($this->prefix . 'popup-icon', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME . '/admin/assets/css/popup-icon.css'), array(), $this->version, 'all');

            wp_enqueue_style($this->prefix . 'bootstrap-tagsinput', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME . '/admin/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css'), array(), $this->version, 'all');

            wp_enqueue_style('select2', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME . '/admin/assets/plugins/jquery.select2/css/select2.min.css'), array(), '4.0.3');
        }

        /**
         * Register the JavaScript for the admin area.
         *
         * @since    1.0.0
         */
        public function enqueue_scripts()
        {
            $pages = isset($_GET['page']) ? $_GET['page'] : '';
            if ($pages == '_options') return;

            wp_enqueue_script($this->prefix . 'bootstrap-tagsinput', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME . '/admin/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js'), array('jquery'), $this->version, false);

            wp_enqueue_script('select2', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME . '/admin/assets/plugins/jquery.select2/js/select2.full.min.js'), array('jquery'), '4.0.3', true);

            wp_enqueue_script($this->prefix . 'media-init', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME . '/admin/assets/js/g5plus-media-init.js'), array('jquery'), $this->version, false);
            if (function_exists('wp_enqueue_media')) {
                wp_enqueue_media();
            }

            wp_enqueue_script($this->prefix . 'popup-icon', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME . '/admin/assets/js/popup-icon.js'), array('jquery'), $this->version, false);

            wp_enqueue_script($this->prefix . 'admin', plugins_url(PLUGIN_G5PLUS_FRAMEWORK_NAME . '/admin/assets/js/admin.js'), array('jquery'), $this->version, false);

            wp_localize_script($this->prefix . 'admin', 'g5plus_framework_meta', array(
                'ajax_url' => admin_url('admin-ajax.php?activate-multi=true')
            ));
        }

        public function dequeue_access(){

            $post_type = isset($_GET['post_type']) ? $_GET['post_type'] : '';
            //event calendar
            if ($post_type !== 'tribe_events') {
                wp_dequeue_script('tribe-buttonset');
                wp_dequeue_style('tribe-common-admin');
                wp_dequeue_script('tribe-dependency');
                wp_dequeue_style('tribe-dependency-style');
                wp_dequeue_script('tribe-pue-notices');
                wp_dequeue_style('tribe-datepicker');



                wp_dequeue_script('tribe-clipboard');
                wp_dequeue_script('datatables');
                wp_dequeue_script('tribe-select2');
                wp_dequeue_style('tribe-select2-css');
                wp_dequeue_style('datatables-css');
                wp_dequeue_script('datatables-responsive');
                wp_dequeue_style('datatables-responsive-css');
                wp_dequeue_script('datatables-select');
                wp_dequeue_style('datatables-select-css');
                wp_dequeue_script('datatables-scroller');
                wp_dequeue_style('datatables-scroller-css');
                wp_dequeue_script('datatables-fixedheader');
                wp_dequeue_style('datatables-fixedheader-css');
                wp_dequeue_script('tribe-datatables');
                wp_dequeue_script('tribe-bumpdown');
                wp_dequeue_style('tribe-bumpdown-css');
                wp_dequeue_style('tribe-buttonset-style');
                wp_dequeue_script('tribe-dropdowns');
                wp_dequeue_script('tribe-jquery-timepicker');
                wp_dequeue_style('tribe-jquery-timepicker-css');

                wp_dequeue_script('tribe-events-admin');
            }


        }

        public function popup_icon()
        {
            $academia_font_awesome = &academia_get_font_awesome();
            ob_start();
            ?>
            <div id="g5plus-framework-popup-icon-wrapper">
                <div id="TB_overlay" class="TB_overlayBG"></div>
                <div id="TB_window">
                    <div id="TB_title">
                        <div id="TB_ajaxWindowTitle">Icons</div>
                        <div id="TB_closeAjaxWindow"><a href="#" id="TB_closeWindowButton">
                                <div class="tb-close-icon"></div>
                            </a></div>
                    </div>
                    <div id="TB_ajaxContent">
                        <div class="popup-icon-wrapper">
                            <div class="popup-content">
                                <div class="popup-search-icon">
                                    <input placeholder="Search" type="text" id="txtSearch">

                                    <div class="preview">
                                        <span></span> <a id="iconPreview" href="javascript:;"><i class="fa fa-home"></i></a>
                                    </div>
                                    <div style="clear: both;"></div>
                                </div>
                                <div class="list-icon">
                                    <h3>Font Awesome</h3>
                                    <ul>
                                        <?php foreach ($academia_font_awesome as $icon) {
                                            $arrkey=array_keys($icon);
                                            ?>
                                            <li><a title="<?php echo esc_attr($arrkey[0]); ?>" href="javascript:;"><i
                                                        class="<?php echo esc_attr($arrkey[0]); ?>"></i></a></li>
                                            <?php
                                        } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="popup-bottom">
                                <a id="btnSave" href="javascript:;" class="button button-primary">Insert Icon</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php
            die(); // this is required to return a proper result
        }
    }
}