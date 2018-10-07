<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/6/2015
 * Time: 9:36 AM
 */

/* CUSTOM PAGE TEMPLATE
    ================================================== */
if (!function_exists('g5plus_page_template_custom')) {
	function g5plus_page_template_custom($template ){
		if (isset($_REQUEST['custom-page']) && !empty($_REQUEST['custom-page'])) {
			if (G5Plus_Global::get_is_do_action_custom_page()) {
				do_action('custom-page/'.$_REQUEST['custom-page']);
				return;
			}
		}
		return $template;

	}
	add_filter( "page_template", "g5plus_page_template_custom" );
}
if (!function_exists('g5plus_style_loader_tag')) {
	function g5plus_style_loader_tag($html, $handle ) {
		return str_replace( " href='", " property='stylesheet' href='", $html );
	}
	add_filter( 'style_loader_tag', 'g5plus_style_loader_tag', 10, 2);
}