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

$logoLink = "logo-header.svg";
if (isset($_SERVER['HTTP_X_KYANI_REP'])) {
	$rep = explode(';', $_SERVER['HTTP_X_KYANI_REP'])[0];
	$homeLink = $rep . '.' . $_SERVER['HTTP_HOST'] . get_blog_details(get_current_blog_id())->path;
}

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
	<header class="fixed-top background-white navigation-header">
		<nav id="HeaderNav" class="navbar navbar-expand-md d-flex">
			<!-- ******************* The Navbar Area ******************* -->
			<?php if ((is_page() || is_singular())) : ?>

			<?php endif; ?>
			<a href="<?php echo($homeLink != "" ? "//" . $homeLink : esc_url(home_url('/'))); ?>"
			   class="navbar-brand">
				<img src="<?php echo esc_url(bloginfo('template_directory') . "/images/" . $logoLink) ?>"
					 alt="Kyani Logo" width="80px">
			</a>
			<?php wp_nav_menu(
					array(
							'theme_location' => 'primary',
							'container_class' => 'collapse navbar-collapse',
							'container_id' => 'navbarNavDropdown',
							'menu_class' => 'navbar-nav',
							'fallback_cb' => '',
							'menu_id' => 'main-menu',
							'depth' => 3,
							'walker' => new Custom_WP_Bootstrap_Navwalker()
					)
			); ?>
			<div id="navbarNavDropdown" class="collapse navbar-collapse">
				<ul id="main-menu" class="navbar-nav ml-auto">
					<li class="nav-item dropdown"><?php echo do_shortcode('[countrySwitcher]'); ?></li>
				</ul>
			</div>
		</nav>
			<nav class="navbar-expand second-nav desktop p-3">
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

	</header>
	</div><!-- #wrapper-navbar end -->
