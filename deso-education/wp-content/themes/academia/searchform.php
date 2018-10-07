<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) )  ?>">
	<input type="text" class="search-field" placeholder="<?php esc_html_e('ENTER YOUR KEYWORD', 'g5plus-academia') ?>" value="<?php echo get_search_query() ?>" name="s" autocomplete="off"/>
	<button type="submit"><i class="fa fa-search"></i> <?php esc_html_e('Search','g5plus-academia') ?></button>
</form>
