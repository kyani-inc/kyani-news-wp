<?php
/**
 * The header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package UnderStrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

$container = get_theme_mod('understrap_container_type');
?>
<!-- Hotjar Tracking Code for https://news.kyani.com -->
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	<script>
		function setCookie(sname, svalue, days) {
			const d = new Date();
			d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
			let expires = "expires=" + d.toUTCString();
			document.cookie = sname + "=" + svalue + ";" + expires + ";path=/;domain=kyani.com";
		}

		function getCookie(sname) {
			let name = sname + "=";
			let sa = document.cookie.split(";");
			for (let i = 0; i < sa.length; i++) {
				let s = sa[i];
				while (s.charAt(0) == " ") {
					s = s.substring(1);
				}
				if (s.indexOf(name) == 0) {
					return s.substring(name.length, s.length);
				}
			}
			return "";
		}

		if (getCookie("viewed_cookie_policy") == "yes") {
			// (function(h,o,t,j,a,r){
			// 	h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
			// 	h._hjSettings={hjid:3073526,hjsv:6};
			// 	a=o.getElementsByTagName('head')[0];
			// 	r=o.createElement('script');r.async=1;
			// 	r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
			// 	a.appendChild(r);
			// })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
		}
	</script>
</head>

<body <?php body_class(); ?> <?php understrap_body_attributes(); ?>>
<?php do_action('wp_body_open'); ?>
<div class="site" id="page">

	<!-- ******************* The Navbar Area ******************* -->
	<div id="wrapper-navbar" style="<?php echo(is_admin_bar_showing() ? 'margin-top: 32px' : ''); ?>">

		<a class="skip-link sr-only sr-only-focusable"
		   href="#content"><?php esc_html_e('Skip to content', 'understrap'); ?></a>

		<nav id="main-nav" class="navbar navbar-expand-md navbar-dark bg-primary" aria-labelledby="main-nav-label">

			<h2 id="main-nav-label" class="sr-only">
				<?php esc_html_e('Main Navigation', 'understrap'); ?>
			</h2>

			<!-- Your site title as branding in the menu -->
			<?php if (!has_custom_logo()) { ?>

				<?php if (is_front_page() && is_home()) : ?>

					<h1 class="navbar-brand mb-0"><a rel="home" href="<?php echo esc_url(home_url('/')); ?>"
													 itemprop="url"><?php bloginfo('name'); ?></a></h1>

				<?php else : ?>

					<a class="navbar-brand" rel="home" href="<?php echo esc_url(home_url('/')); ?>"
					   itemprop="url"><?php bloginfo('name'); ?></a>

				<?php endif; ?>

				<?php
			} else {
				the_custom_logo();
			}
			?>
			<!-- end custom logo -->

			<!-- The WordPress Menu goes here -->
			<?php
			wp_nav_menu(
					array(
							'theme_location' => 'primary',
							'container_class' => 'collapse navbar-collapse',
							'container_id' => 'navbarNavDropdown',
							'menu_class' => 'navbar-nav ml-auto',
							'fallback_cb' => '',
							'menu_id' => 'main-menu',
							'depth' => 3,
							'walker' => new Custom_WP_Bootstrap_Navwalker(),
					)
			);
			?>

			<!-- Custom Navbar Toggler -->
			<a class="navbar-toggler nav-button ml-auto">
					<span id="nav-icon3">
						<span class="side-panel-btn"></span>
						<span class="side-panel-btn"></span>
						<span class="side-panel-btn"></span>
						<span class="side-panel-btn"></span>
					</span>
			</a>
		</nav><!-- .site-navigation -->

		<!-- Secondary Nav .second-nav -->
		<nav class="navbar-expand second-nav desktop p-1">
			<?php
			wp_nav_menu(
					array(
							'theme_location' => 'secondary',
							'container_class' => 'secondary-menu-container navbar-collapse collapse justify-content-center',
							'container_id' => 'navbarNavDropdown',
							'menu_class' => 'navbar-nav align-self-end flex-wrap ',
							'fallback_cb' => '',
							'menu_id' => 'nav',
							'depth' => 1,
							'walker' => new Understrap_WP_Bootstrap_Navwalker(),
					)
			);
			?>
		</nav>
		<nav class="navbar-expand second-nav mobile">
			<?php
			wp_nav_menu(
					array(
							'theme_location' => 'secondary',
							'container_class' => 'navbar',
							'container_id' => 'navbarNavDropdown',
							'menu_class' => 'navbar-nav mx-auto',
							'fallback_cb' => '',
							'menu_id' => 'secondary-menu',
							'depth' => 1,
							'walker' => new Understrap_WP_Bootstrap_Navwalker(),
					)
			);
			?>

		</nav>

		</nav>
		<!-- Secondary Nav .second-nav-->

		<!-- Side Menu .side-menu -->
		<div class="side-menu hidden" id="side-panel-menu">
			<div class="side-menu-container">
				<?php
				wp_nav_menu(array(
						'theme_location' => 'side',
						'container' => false,
						'menu_class' => 'nav flex-column',
						'add_li_class' => 'nav-item',
						'depth' => 3,
						'walker' => new Custom_WP_Bootstrap_Navwalker()
				));
				?>
			</div>
		</div>

		<!-- Side Menu .side-menu -->


	</div><!-- #wrapper-navbar end -->
