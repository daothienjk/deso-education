<?php
class Slickr_Flickr_Fetcher {

	protected $id;
	protected $params;
	protected $pages;
	protected $message;
	protected $feed;

	function get_message() { return $this->message;}
	function get_pages() { return $this->pages;}
			
	function __construct($id, $params) {  
		$this->id = $id;
		$this->params = $params;
		$this->message = '';
		$this->pages = 0;
	}

	function fetch_photos() {
      	return $this->fetch_photos_with_failover();
	}

	function fetch_photos_with_failover() {  
	    $photos = $this->fetch_from_flickr();
	    if ((! is_array($photos)) && ($this->params['use_key']=='y') && ($this->params['api_required']!='y') ) {
	   		$this->params['use_key']='n';
	   		return $this->fetch_from_flickr();
	   	} else {
	   		return $photos;
	   	}
	}

	function fetch_from_flickr() {
		$photos = $this->fetch_single_source() ;
	  	if ($photos && !empty($this->params['restrict'])) $photos = $this->restrict_photos($photos);
		return $photos;
	}
	function fetch_single_source() {
		$this->pages = 0;
        $this->feed = new Slickr_Flickr_Feed();
        $this->feed->init($this->params);
		$page=$this->params['page'];
        $photos = $this->feed->fetch_photos($page);
		$this->pages = $this->feed->get_pages();
  	  	if ((count($photos) == 0) || $this->feed->is_error()) {
  	  		$this->message = $this->feed->get_message();
			return false;
		} else {
  	  		return $photos; //return array of photos
		}
	}

	function restrict_photos ($items) {
	    $filtered_items = array();
	    if ($this->params['restrict']=='orientation') {
	    	$orientation = $this->params['orientation'];
	    	foreach ($items as $item)  if ($item->get_orientation()==$orientation) $filtered_items[] = $item;
	    	if (count($filtered_items) == 0) {
              $this->message = sprintf('No matching %1$s format photos were found', $orientation);
              return false;  
	    	} else {  
	    	return $filtered_items;
	    	}
		} else {
		    return $items;
		}
	}

}
