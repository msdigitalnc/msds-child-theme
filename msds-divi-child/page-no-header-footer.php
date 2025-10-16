<?php
/*
Template Name: No Header or Footer
Description: A minimal template with no global header or footer. Ideal for landing pages, splash pages, and campaign microsites.
*/

defined( 'ABSPATH' ) || exit;

$is_page_builder_used = function_exists( 'et_pb_is_pagebuilder_used' ) && et_pb_is_pagebuilder_used( get_the_ID() );

do_action( 'msds_before_noheader_content' );
?>

<div id="main-content" class="no-header-footer-template">
	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-content">
				<?php
					the_content();
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

<?php do_action( 'msds_after_noheader_content' ); ?>
