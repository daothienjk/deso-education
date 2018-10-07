<?php
class Slickr_Flickr_Public extends Slickr_Flickr_Module {

    const GALLERIA_VERSION = '1.5.7';
    
	private $jquery_data; //write jQuery in one chunk	
	private $galleria_themes; //galleria themes
	private $is_present = false; //is there a galleria, gallery or slideshow on this page? 	

	function init() {
		$this->galleria_themes=array(); //initialize galleria themes
		$this->jquery_data=array(); //initialize jquery config
		add_shortcode('slickr-flickr', array($this,'display'));
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_filter('widget_text', 'do_shortcode', 11);			
		add_filter('jetpack_photon_skip_image', array($this, 'skip_flickr_images'), 15, 3 );
	}

	function display($attr) {
		$disp = new Slickr_Flickr_Display($this);
		return $disp->show($attr);
	}

    function skip_flickr_images($skip, $src, $tag) {
        if (strpos($src, 'flickr.com') !== FALSE) $skip = true;
        return $skip;        
    }

	function enqueue_scripts() {
	    $path = $this->get_url();
	    $options = $this->options->get_options();
	    $footer_scripts =  $options['scripts_in_footer'] ;

    	wp_enqueue_style('slickr-flickr', $path.'/styles/public.css', array(), $this->get_version());
    	$deps = array('jquery');
    	switch ($options['lightbox']) {
    		 case 'sf-lightbox':  {
		        wp_enqueue_style('slickr-flickr-lightbox', $path."/styles/lightGallery.css", array(),"1.0");
		        wp_enqueue_script('slickr-flickr-lightbox', $path."/scripts/lightGallery.min.js", array('jquery'),"1.0",$footer_scripts);
		        $deps[] = 'slickr-flickr-lightbox';
        	}
    		case 'thickbox': { //preinstalled by wordpress but needs to be activated
    		   wp_enqueue_style('thickbox');
    		   wp_enqueue_script('thickbox');
    		   $deps[] = 'thickbox';
 			   break;
    		}
    		default: { break; } //use another lightbox plugin
    	}
		//TODO wp_enqueue_script('jqpagination', $path."/scripts/jquery.jqpagination.min.js", array('jquery'),"1.3",$footer_scripts);     

		$gname = 'galleria';
    	$galleria = array_key_exists('galleria',$options) ? $options['galleria'] : 'galleria-latest';
    	$gfolder = $path . "/galleria/";    
	    switch ($galleria) {
		    case 'galleria-none': { break; }
		    case 'galleria-original':
		    case 'galleria-1.0': {
    			wp_enqueue_style($gname, $gfolder.'galleria-1.0.css',array(),'1.0');
    			wp_enqueue_script($gname, $gfolder.'galleria-1.0.noconflict.js', array('jquery'), $this->get_version(), $footer_scripts);
        		break;
			}
		    default: {
				$gversion = self::GALLERIA_VERSION;
				$gscript = $gfolder . 'galleria-'.$gversion.'.min.js';
				$gtheme = $options['galleria_theme'];
				$gloading = $options['galleria_theme_loading'];
		    	wp_enqueue_script($gname, $gscript, array('jquery'), $gversion, $footer_scripts); //enqueue loading of core galleria script
				if ('static' == $gloading) {
			    	wp_enqueue_script($gname.'-'.$gtheme, $this->get_galleria_theme_path($gtheme), array('jquery',$gname), $gversion, $footer_scripts); //enqueue loading of core galleria script
	    			wp_enqueue_style($gname.'-'.$gtheme, $this->get_galleria_theme_path($gtheme,true), array(), $gversion);
				}
    		    break;
    		}
		}
    	wp_enqueue_script('rslides', $path.'/scripts/responsiveslides.min.js', 'jquery', '1.54', $footer_scripts);
    	wp_enqueue_script('slickr-flickr', $path.'/scripts/public.js', $deps, $this->get_version(), $footer_scripts);
    	add_filter('print_footer_scripts', array($this,'print_scripts'),100); //start slickr flickr last
		if ($footer_scripts) add_action('wp_footer', array($this,'dequeue_redundant_scripts'),1);
	}

	function dequeue_redundant_scripts() {
		if (count($this->galleria_themes)==0) wp_dequeue_script('galleria'); 
		if (! $this->is_present) {
			wp_dequeue_script('slickr-flickr'); 
			wp_dequeue_script('slickr-flickr-lightbox');
		}
	}

	function print_scripts() {
		if ($this->is_present) {
			$this->print_jquery_data(); //setup of the image data
			$this->load_galleria_theme(); //lazy loading and possible change of Galleria theme
 			$this->start_show(); //start the gallerias, galleries and slideshows
 		}
	}

	function note_active() {
		$this->is_present = true;
	}
		
	function add_galleria_theme($theme) {
		if (! in_array($theme, $this->galleria_themes)) $this->galleria_themes[] = $theme;
	}

	function get_galleria_theme_path($theme, $css = false) {
		if (empty($theme)) $theme = 'classic';
		if ('classic'==$theme) 
    	    $themepath = $this->get_url() . '/galleria/themes/classic/galleria.classic';
		else  //premium themes are located outside the plugin folder
    	    $themepath = site_url( $this->options->get_option('galleria_themes_folder'). '/' . $theme .'/galleria.'. $theme);
		return $themepath . ($css ? '.css' : '.min.js');
	}	

	function load_galleria_theme() {
	    $options = $this->options->get_options();
		if (('galleria-latest' != $options['galleria']) 
		|| ('dynamic' != $options['galleria_theme_loading'])
		|| (count($this->galleria_themes) == 0)) return;

		print <<< LOAD_THEME_START
<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function() { 
LOAD_THEME_START;
		foreach ($this->galleria_themes as $theme) 
			printf( 'Galleria.loadTheme("%1$s");', $this->get_galleria_theme_path($theme)) ;
		print <<< LOAD_THEME_END
})
//]]>
</script>

LOAD_THEME_END;
	}

	function add_jquery($line) {
		$this->jquery_data[]= $line;
	}

	function print_jquery_data() {
		if (count($this->jquery_data) == 0) return;
		$output = '';
    	foreach ($this->jquery_data as $data) $output .= $data."\r\n";
		print <<< JQUERY_DATA
<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function() {
{$output}
});
//]]>
</script>
JQUERY_DATA;
	}

	function start_show() {
		print <<< START_SLIDESHOWS
<script type="text/javascript">
//<![CDATA[
jQuery.noConflict(); 
jQuery(document).ready(function() { slickr_flickr_start(); });
//]]>
</script>
START_SLIDESHOWS;
	}

}
