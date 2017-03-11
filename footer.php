<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */
?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'storefront_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="col-full">

			<?php
			/**
			 * @hooked storefront_footer_widgets - 10
			 * @hooked storefront_credit - 20
			 */
			do_action( 'storefront_footer' ); ?>

		</div><!-- .col-full -->
	</footer><!-- #colophon -->

	<?php do_action( 'storefront_after_footer' ); ?>

</div><!-- #page -->

<div id="social_footer">
	<center><?php echo do_shortcode('[aps-social id="1"]')?></center>
</div><!-- #social_footer -->
<div id="copyright_footer">
	Copyright 2011 - <?php echo date("Y") ?> Neyrinck. All rights reserved.
</div>

<?php wp_footer(); ?>

</body>
</html>
