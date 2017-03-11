<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> <?php storefront_html_tag_schema(); ?>>
<head>
<meta name="google-site-verification" content="sLSfBAwvR5Jwol1cJa25jMLjRrAtFvcjKMgXFYMkJBA" />
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<title>NEYRINCK</title>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<style>
	.site-header-cart {display: block !important;}
</style>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'storefront' ); ?></a>

	<?php
	do_action( 'storefront_before_header' ); ?>
	
	<div class="col-full">
	<header id="masthead" class="site-header" role="banner" <?php if ( get_header_image() != '' ) { echo 'style="background-image: url(' . esc_url( get_header_image() ) . ');"'; } ?>>
			<?php global $current_user;
			      get_currentuserinfo();

			      $username = $current_user->user_login;
			      $email = $current_user->user_email;
			      $firstname = $current_user->user_firstname;
			      $displayname =$current_user->display_name;
			      
			      if ($displayname) $hello = $displayname;
			      else if ($firstname) $hello = $firstname;
			      else if ($username) $hello = $username;
			      else $hello = $email;

			      
			
				if ( is_user_logged_in() ) { ?>
					
						<div class='header_login_wrapper'>
							<span id='loggedIn_email' class='header_login'><?php echo $email;?></span><span class='header_login'><a href='https://neyrinck.com/store/my-account/'>My Account</a></span>
							<a class='header_login' href="<?php echo wp_logout_url(); ?>" title="Logout">Logout</a>
							<!-- <a class='header_login' href="<?php echo wp_logout_url(); ?>" title="Logout">Logout</a> -->
						</div>
					<?php 
				} else { ?>
					
						<div class='header_login_wrapper'>
							<?php $url = $_SERVER['REQUEST_URI'];
							      $url = str_replace("loggedout=true", "", $url); 

									$redirect_to = $_GET['redirect_to'];
									if (!isset($_SESSION)) session_start();
									$_SESSION['bl_orignial_refererer'] = $redirect_to;


							 ?>

							<a class='header_login' href="<?php echo get_settings('siteurl') . '/login?redirect_to=' . $url; ?>" title="Login">Login</a>
							<a class='header_login' href="<?php echo site_url() ?>/login?action=register&redirect_to=<?php echo $url ?>">Register</a>
			
						</div>
				<?php } ?>


			<?php
			/**
			 * @hooked storefront_social_icons - 10
			 * @hooked storefront_site_branding - 20
			 * @hooked storefront_secondary_navigation - 30
			 * @hooked storefront_product_search - 40
			 * @hooked storefront_primary_navigation - 50
			 * @hooked storefront_header_cart - 60
			 */

			do_action( 'storefront_header' ); 

			?>
			

		</div>
	</header><!-- #masthead -->
	
	<?php
	/**
	 * @hooked storefront_header_widget_region - 10
	 */
	do_action( 'storefront_before_content' ); 
	?>

	<div id="content" class="site-content">
		<div class="col-full">
		<?php
		/**
		 * @hooked woocommerce_breadcrumb - 10
		 */
		do_action( 'storefront_content_top' ); ?>

		
