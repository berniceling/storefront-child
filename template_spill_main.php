<?php
/*
*  Template Name: Overview : Spill
*  Description: It template for Spill
*               It gets it's content from Overview : Spill  Page
*               This template does not contain the "moveWindow function".
*
*/


get_header('spill'); ?>
<?php echo '<script type="text/javascript" src="/wp-content//themes/storefront-child/product_nav/script.js"></script>
<link rel="stylesheet" href="/wp-content//themes/storefront-child/product_nav/styles.css" type="text/css">
'; ?>		

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<div class='included_post'>
			<?php
				$my_id = 59719;
				$post_id_59719 = get_post($my_id);
				$content = $post_id_59719->post_content;
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]>', $content);
				echo $content;
			?>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->
	<script type='text/javascript'>
		jQuery('#cssmenu li:first').addClass('current-menu-item');
	</script>
<?php get_footer(); ?>