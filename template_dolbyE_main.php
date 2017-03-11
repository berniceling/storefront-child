<?php
/*
*  Template Name: Overview : SoundCode For Dolby E 
*  Description: It template for SoundCode For Dolby E  Overview Page
*               It gets it's content from Overview : SoundCode For Dolby E  Page
*               This template does not contain the "moveWindow function".
*
*/


get_header('dolbye'); ?>
<?php echo '<script type="text/javascript" src="/wp-content//themes/storefront-child/product_nav/script.js"></script>
<link rel="stylesheet" href="/wp-content//themes/storefront-child/product_nav/styles.css" type="text/css">
'; ?>		

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<div class='included_post'>
			<?php
				$my_id = 6733;
				$post_id_6733 = get_post($my_id);
				$content = $post_id_6733->post_content;
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