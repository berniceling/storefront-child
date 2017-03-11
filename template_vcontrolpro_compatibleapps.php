<?php
/*
*  Template Name: Compatible Apps for V-Control Pro 
*  Description: A Page Template for Compatible Apps for V-Control Pro.
*/

get_header('vcontrolpro'); ?>
<?php echo '<script type="text/javascript" src="/wp-content//themes/storefront-child/product_nav/script.js"></script>
<link rel="stylesheet" href="/wp-content//themes/storefront-child/product_nav/styles.css" type="text/css">
<link rel="stylesheet" href="/wp-content//themes/storefront-child/simplemenu.css" type="text/css">
'; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class='included_post' >
				<?php
					$my_id = 50495;
					$post_id_50495 = get_post($my_id);
					$content = $post_id_50495->post_content;
					$content = apply_filters('the_content', $content);
					echo $content;
				?>
			</div>
			<div id='am'></div>
			<?php wp_nav_menu( array('theme_location' => 'vcontropro-compatibleapps-menu', 'container_id' => 'simplemenu')); ?>
			<?php while ( have_posts() ) : the_post(); ?>
				
				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<script type='text/javascript'>
		jQuery('#cssmenu li:nth-child(3)').addClass('current-menu-item');
	</script>
<?php get_footer(); ?>