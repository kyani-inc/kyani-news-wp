<?php
/**
 * The template for displaying search forms
 *
 * @package UnderStrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search" class="col-12 col-md-8 col-lg-6">
	<label class="sr-only" for="s"><?php esc_html_e( 'Search', 'understrap' ); ?></label>
	<div class="input-group">
		<input class="field form-control" id="s" name="s" type="text"
			placeholder="<?php esc_attr_e( 'Search', 'understrap' ); ?>" value="<?php the_search_query(); ?>">
		<span class="input-group-append">
			<a class="searchform-search submit">
				<img src="<?php echo esc_url(bloginfo('template_directory') . "/images/Search.svg") ?>">
			</a>
<!--			<input class="submit btn btn-primary" id="searchsubmit" name="submit" type="submit"-->
<!--			value="--><?php //esc_attr_e( 'Search', 'understrap' ); ?><!--">-->
		</span>
	</div>
</form>
