<?php
/*
Template Name: Full Width Page
Description: A clean full-width layout without sidebar.
*/

defined( 'ABSPATH' ) || exit;

add_filter( 'body_class', function( $classes ) {
    return array_diff( $classes, [ 'et_right_sidebar' ] );
});

get_header();

$is_page_builder_used = function_exists( 'et_pb_is_pagebuilder_used' ) && et_pb_is_pagebuilder_used( get_the_ID() );
?>

<div id="main-content">
    <?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php if ( ! $is_page_builder_used ) : ?>
                <h1 class="main_title"><?php the_title(); ?></h1>
                <?php if ( has_post_thumbnail() && 'on' === et_get_option( 'divi_page_thumbnails', 'false' ) ) : ?>
                    <div class="post-thumbnail">
                        <?php the_post_thumbnail( 'large' ); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="entry-content">
                <?php the_content(); ?>
                <?php
                if ( ! $is_page_builder_used ) {
                    wp_link_pages( [
                        'before' => '<div class="page-links">' . __( 'Pages:', 'msds-divi-child' ),
                        'after'  => '</div>',
                    ] );
                }
                ?>
            </div>
        </article>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
