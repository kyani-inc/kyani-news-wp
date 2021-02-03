<?php
/**
 * Single post partial template
 *
 * @package UnderStrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class('news-single-post'); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<div class="entry-meta">

			<?php understrap_posted_on(); ?>

		</div><!-- .entry-meta -->

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<hr/>

		<div class="entry-social-share">
			<span><?php echo esc_html__('Share on: ', 'understrap')?></span>
			<img src="<?php echo esc_url(bloginfo('template_directory') . "/images/facebook.svg") ?>">
			<img src="<?php echo esc_url(bloginfo('template_directory') . "/images/twitter.svg") ?>">
			<img src="<?php echo esc_url(bloginfo('template_directory') . "/images/instagram.svg") ?>">
		</div>

	</header><!-- .entry-header -->

	<?php echo get_the_post_thumbnail( $post->ID, 'full', array('class'=> 'single-post-banner')); ?>

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
