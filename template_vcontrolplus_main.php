<?php
/*
*  Template Name: Overview : V-Control Pro 2
*  Description: It template for V-Control Plus Overview Page
*               It gets it's content from Overview : V-Control Plus Page
*               This template does not contain the "moveWindow function".
*
*/


get_header('vcontrolplus'); ?>
<?php echo '<script type="text/javascript" src="/wp-content//themes/storefront-child/product_nav/script.js"></script>
<link rel="stylesheet" href="/wp-content//themes/storefront-child/product_nav/styles.css" type="text/css">
'; ?>	

	<div id="primary" class="content-area" style="padding-top: 20px">
		<main id="main" class="site-main" role="main">

			<div class='included_post'>
			<?php
				$my_id = 6748;
				$post_id_6748 = get_post($my_id);
				$content = $post_id_6748->post_content;
				$content = apply_filters('the_content', $content);
				// $content = str_replace(']]>', ']]>', $content);
				echo $content;
			?>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->
	<script type='text/javascript'>
		jQuery('#cssmenu li:first').addClass('current-menu-item');
	</script>
<?php get_footer(); ?>