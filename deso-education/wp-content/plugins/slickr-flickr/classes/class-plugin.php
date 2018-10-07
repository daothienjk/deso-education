<?php
class Slickr_Flickr_Plugin {

    const ACTIVATE_KEY = 'slickr_flickr_activation';
	const CACHE_EXPIRY = 43200;	
	const OPTIONS_NAME  = 'slickr_flickr_options';			

 	private $name = SLICKR_FLICKR_PLUGIN_NAME;
 	private $path = SLICKR_FLICKR_PATH;
 	private $slug = SLICKR_FLICKR_SLUG;
 	private $version = SLICKR_FLICKR_VERSION;
	
	private $defaults = array(	    
		'id' => '',
	    'group' => 'n',
	    'use_key' => '',
	    'api_key' => '',
	    'use_rss' => '',  
	    'search' => 'photos',
 		'photo_id' => '',
	    'tag' => '',
	    'tagmode' => '',
	    'set' => '',
	    'gallery' => '',
	    'license' => '',
	    'date_type' => '',
	    'date' => '',
	    'before' => '',
	    'after' => '',
	    'text' => '',
	    'cache' => 'on',
	    'cache_expiry' => self::CACHE_EXPIRY,
	    'items' => '20',
	    'type' => 'gallery',
	    'captions' => 'on',
	    'lightbox' => 'sf-lightbox',
	    'galleria' => 'galleria-latest',
	    'galleria_theme' => 'classic',
	    'galleria_theme_loading' => 'static',
    	'galleria_themes_folder' => 'galleria/themes',
    	'galleria_options' => '',
    	'options' => '',
    	'delay' => '5',
    	'transition' => '0.5',
    	'start' => '1',
    	'autoplay' => 'on',
    	'pause' => '',
    	'orientation' => 'landscape',
    	'size' => 'medium',
    	'responsive' => '',
 	    'width' => '',
	    'height' => '',
	    'private' => '',
	    'random' => '',
    	'bottom' => '',
    	'thumbnail_size' => '',
    	'thumbnail_scale' => '',
    	'thumbnail_captions' => '',
    	'thumbnail_border' => '',
    	'photos_per_row' => '',
		'class' => '',
    	'align' => '',
    	'border' => '',
    	'descriptions' => '',
    	'ptags' => '',
    	'flickr_link' => '',
    	'flickr_link_title' => 'Click to see the photo on Flickr',
    	'flickr_link_target' => '',
    	'link' => '',
    	'target' => '_self',
    	'attribution' => '',
    	'nav' => '',
    	'sort' => '',
    	'direction' => '',
    	'album_order' => false,
    	'per_page' => 50,
    	'page' => 1,
    	'pagination'=> '',
        'element_id' => '',
    	'restrict' => '',
    	'scripts_in_footer' => false,
    	'silent' => false,
    	'message' => '' 	
	); 

  	private $options;
  	private $utils;
  	private $news;
  	private $public;

  	static function get_instance() {
        static $instance = null;
        if (null === $instance) {
            // $instance = new static(); //use self instead of static to support 5.2 - not the same but okay as the plugin class is not extended 
            $instance = new self(); 
            register_activation_hook($instance->path, array($instance, 'activate'));            
            add_action('init', array($instance, 'init'),0);
            add_action('init', array($instance, is_admin() ? 'admin_init' : 'public_init'), 0);                
        }
        return $instance;
  	}
   
  	protected function __construct() {}

  	private function __clone() {}

  	private function __wakeup() {}

	public function init() {
		$dir = dirname(__FILE__) . '/';
		require_once($dir . 'class-options.php');
		require_once($dir . 'class-utils.php');
		require_once($dir . 'class-module.php');
		require_once($dir . 'class-cache.php');
		$this->utils = new Slickr_Flickr_Utils();
		$this->options = new Slickr_Flickr_Options( self::OPTIONS_NAME, $this->defaults);
	}

	public function public_init() {
		$dir = dirname(__FILE__) . '/';
		require_once($dir . 'class-feed-photo.php');
		require_once($dir . 'class-api-photo.php');
		require_once($dir . 'class-feed.php');
		require_once($dir . 'class-fetcher.php');
		require_once($dir . 'class-display.php');
		require_once($dir . 'class-public.php');		
		$this->public = new Slickr_Flickr_Public();
	}

	public function admin_init() {
		$dir = dirname(__FILE__) . '/';	
		require_once($dir . 'class-tooltip.php');
		require_once($dir . 'class-admin.php');
		require_once($dir . 'class-news.php');
		require_once($dir . 'class-dashboard.php');
		$this->news = new Slickr_Flickr_News($this->version);
		new Slickr_Flickr_Dashboard($this->version, $this->path, $this->slug);
 		if (get_option(self::ACTIVATE_KEY)) add_action('admin_init',array($this, 'upgrade')); 
	}
	
	public function activate() { //called on plugin activation
    	update_option(self::ACTIVATE_KEY, true);
	}
	
	public function upgrade() { 
		$this->options->upgrade_options(); //save any new options on plugin update
		delete_option(self::ACTIVATE_KEY); //delete key so upgrade runs only on activation		
        $cache = new Slickr_Flickr_Cache();
		$cache->clear_all(); //clear out the cache
	}		

	public function get_news(){
		return $this->news;
	}		

	public function get_options(){
		return $this->options;
	}

	public function get_utils(){
		return $this->utils;
	}

	public function get_name(){
		return $this->name;
	}

	public function get_path(){
		return $this->path;
	}
	
 	public function get_slug(){
		return $this->slug;
	}

 	public function get_url(){
		return plugins_url($this->slug);
	}

	public function get_version(){
		return $this->version;
	}

	public function get_public(){
		return $this->public;
	}

}
