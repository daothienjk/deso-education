<?php
class Slickr_Flickr_Cache {

	const FLICKR_CACHE_TABLE = 'flickr_cache'; 
	const FLICKR_CACHE_FOLDER = 'flickr-cache';
	const FLICKR_CACHE_CUSTOM = 'sflickr';

	function get_element($id) { return @unserialize(base64_decode(get_transient(self::FLICKR_CACHE_CUSTOM.$id))); }
	
	function set_element($id, $photos, $expiry) { 
	  return set_transient(self::FLICKR_CACHE_CUSTOM.$id, serialize(base64_encode($photos)), $expiry); 
	}

	function clear_all() {
    	$this->clear_rss_cache();
    	$this->clear_rss_cache_transient();
    	$this->clear_transient_flickr_cache();
    	$this->clear_flickr_cache();
    	$this->optimise_options();
	}

	private function clear_rss_cache() {
    	global $wpdb;
    	$table = $this->get_options_table();
    	$sql = "DELETE FROM ".$table." WHERE option_name LIKE 'rss_%' and LENGTH(option_name) IN (36, 39)";
    	$wpdb->query($sql);
	}
	
	private function clear_rss_cache_transient() {
    	global $wpdb;
    	$table = $this->get_options_table();
    	$sql = "DELETE FROM ".$table." WHERE option_name LIKE '_transient_feed_%' or option_name LIKE '_transient_rss_%' or option_name LIKE '_transient_timeout_%'";
    	$wpdb->query($sql);
	}
	
	private function clear_transient_flickr_cache() {
    	global $wpdb;
    	$table = $this->get_options_table();
    	$wpdb->query("DELETE FROM ".$table." WHERE option_name LIKE '_transient_".self::FLICKR_CACHE_CUSTOM."%' ");
    	$wpdb->query("DELETE FROM ".$table." WHERE option_name LIKE '_transient_timeout_".self::FLICKR_CACHE_CUSTOM."%' ");
    	$wpdb->query("DELETE FROM ".$table." WHERE option_name LIKE '_transient_flickr_%' ");
    	$wpdb->query("DELETE FROM ".$table." WHERE option_name LIKE '_transient_timeout_flickr_%' ");
	}

	private function clear_flickr_cache() {
    	global $wpdb;
		$table_name = $this->get_cache_table();
		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {				
	    	try {
	    		$wpdb->query("TRUNCATE TABLE ".$table_name); //ignore error if user does not have permission to truncate table
			}
			catch (Exception $e) {
			}
		}
	}

	private function optimise_options() {
    	global $wpdb;
    	try {
    		$wpdb->query("OPTIMIZE TABLE ".$this->get_options_table()); //ignore error if user does not have permission to optimise table
		}
		catch (Exception $e) {
		}
	}
	
	private function get_options_table() {
    	global $wpdb, $table_prefix;
    	$prefix = $table_prefix ? $table_prefix : $wpdb->prefix;
    	return $prefix.'options';
    }

	private function get_cache_table() {
    	global $wpdb, $table_prefix;
    	$prefix = $table_prefix ? $table_prefix : $wpdb->prefix;
    	return $prefix . self::FLICKR_CACHE_TABLE;
    }	

}