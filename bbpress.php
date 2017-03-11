<?php
/*
*  
*  Description: A bbPress Default Template.
*/


get_header('bbp'); ?>

<h2 class='forum_h2'><a href='https://neyrinck.com/forum/'  > Forum </a></h2>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				

				<?php get_template_part( 'content', 'page' ); ?>

				

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
