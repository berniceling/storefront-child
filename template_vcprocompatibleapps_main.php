<?php
/*
*  Template Name: Main : Compatible Apps Page for V-Control Pro 
*  Description: A Page Template for Compatible Apps for V-Control Pro.
*/

get_header('vcontrolpro'); ?>
<?php echo '<script type="text/javascript" src="/wp-content//themes/storefront-child/product_nav/script.js"></script>
<link rel="stylesheet" href="/wp-content//themes/storefront-child/product_nav/styles.css" type="text/css">
<link rel="stylesheet" href="/wp-content//themes/storefront-child/simplemenu.css" type="text/css">
'; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class='included_post'>
			<?php
				$my_id = 6321;
				$post_id_6321 = get_post($my_id);
				$content = $post_id_6321->post_content;
				$content = apply_filters('the_content', $content);
				// $content = str_replace(']]>', ']]>', $content);
				echo $content;
			?>
			</div>
			<?php wp_nav_menu( array('theme_location' => 'vcontropro-compatibleapps-menu', 'container_id' => 'simplemenu')); ?>

			<div class='included_post'><br/>
			<?php
				$my_id = 6688;
				$post_id_6688 = get_post($my_id);
				$content = $post_id_6688->post_content;
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