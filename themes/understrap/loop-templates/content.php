<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package UnderStrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<div class="col-12 col-md-4 col-xl-3 d-flex align-items-stretch">
	<div <?php post_archive_class(); ?> id="post-<?php the_ID(); ?>">

		<?php echo get_the_post_thumbnail( $post->ID, 'thumbnail' ); ?>
		<div class="card-body">


			<header class="entry-header archive">

				<div class="entry-meta">
					<?php understrap_posted_on(); ?>
				</div><!-- .entry-meta -->

				<?php
				the_title(
						sprintf( '<h5 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
						'</a></h5>'
				);
				?>

			</header><!-- .entry-header -->



			<div class="entry-content">

				<?php the_excerpt(); ?>

				<?php
				wp_link_pages(
						array(
								'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
								'after'  => '</div>',
						)
				);
				?>

			</div><!-- .entry-content -->

			<footer class="entry-footer">

				<?php understrap_entry_footer(); ?>

			</footer><!-- .entry-footer -->
		</div>
	</div><!-- #post-## -->
</div>

