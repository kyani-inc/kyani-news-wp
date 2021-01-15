<?php
/**
 * Single post partial template
 *
 * @package UnderStrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header text-center">
		<div class="entry-meta">

			<?php understrap_posted_on(); ?>

		</div><!-- .entry-meta -->

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-social text-center">
		<hr style="width: 20%">
		<div class="social-icons">
			<span>Share on: </span>
			<img src="<?php echo esc_url(bloginfo('template_directory') . "/images/facebook.svg") ?>">
			<img src="<?php echo esc_url(bloginfo('template_directory') . "/images/twitter.svg") ?>">
			<img src="<?php echo esc_url(bloginfo('template_directory') . "/images/instagram.svg") ?>">
		</div>
	</div>

	<div class="entry-image">
		<?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?>
	</div>

	<div class="entry-content">

		<?php the_content(); ?>

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

</article><!-- #post-## -->
