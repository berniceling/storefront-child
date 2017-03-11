<?php
/*
*  Template Name: Main : Compatible Apps Page for V-Control Pro 2 
*  Description: A Page Template for Compatible Apps for V-Control Pro.
*/

get_header('vcontrolplus'); ?>
<?php echo '<script type="text/javascript" src="/wp-content//themes/storefront-child/product_nav/script.js"></script>
<link rel="stylesheet" href="/wp-content//themes/storefront-child/product_nav/styles.css" type="text/css">
<link rel="stylesheet" href="/wp-content//themes/storefront-child/simplemenu.css" type="text/css">
'; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main"><br/>
			<div class='included_post'>
			<?php
				$my_id = 50495;
				$post_id_50495 = get_post($my_id);
				$content = $post_id_50495->post_content;
				$content = apply_filters('the_content', $content);
				// $content = str_replace(']]>', ']]>', $content);
				echo $content;
			?>
			</div>
			<?php wp_nav_menu( array('theme_location' => 'vcp2-compatibleapps-menu', 'container_id' => 'simplemenu')); ?>

			<div class='included_post'><br/>
			<?php
				$my_id = 50669;
				$post_id_50669 = get_post($my_id);
				$content = $post_id_50669->post_content;
				$content = apply_filters('the_content', $content);
				// $content = str_replace(']]>', ']]>', $content);
				echo $content;
			?>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->
	<script type='text/javascript'>
		jQuery('#simplemenu li:first').addClass('current-menu-item');
	</script>
<?php get_footer(); ?>