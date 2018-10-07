<?php
 abstract class Slickr_Flickr_Module {

    protected $plugin;
    protected $options;   

    abstract function init(); 
            
    function __construct() {
      $this->plugin = Slickr_Flickr_Plugin::get_instance();
      $this->options = $this->plugin->get_options();
      $this->init();
    }

    function get_defaults() {
        return $this->options->get_options();
    }

    function get_url() {
        return $this->plugin->get_url();
    }

    function get_version() {
        return $this->plugin->get_version();
    }
    
}