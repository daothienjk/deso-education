<?php
get_header();
do_action('g5plus_before_page');
if ( have_posts() ) {
    // Start the Loop.
    while ( have_posts() ) : the_post();
        the_content();
    endwhile;
}
?>
<?php get_footer(); ?>
