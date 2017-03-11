<?php

/**
 * Search 
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<?php $forum_id = bbp_get_forum_id(); 
?>
<?php if( $forum_id ): ?>
    <input class="button" type="hidden" name="bbp_search_forum_id" value="<?php echo $forum_id; ?>" />
<?php endif; ?>


<form role="search" method="get" id="bbp-search-form" action="<?php bbp_search_url(); ?>">
	<div>
		<label class="screen-reader-text hidden" for="bbp_search"><?php _e( 'Search for:', 'bbpress' ); ?></label>
		<input type="hidden" name="action" value="bbp-search-request" />
		<!-- <input placeholder="Search <?php the_title(); ?> Topics" tabindex="<?php bbp_tab_index(); ?>" type="text" value="<?php echo esc_attr( bbp_get_search_terms() ); ?>" name="bbp_search" id="bbp_search" /> -->
 
		<input placeholder='Search posts...' tabindex="<?php bbp_tab_index(); ?>" type="text" value="<?php echo esc_attr( bbp_get_search_terms() ); ?>" name="bbp_search" id="bbp_search" />
	<!--<input placeholder='&#128269; Search posts...' tabindex="<?php bbp_tab_index(); ?>" type="text" value="<?php echo esc_attr( bbp_get_search_terms() ); ?>" name="bbp_search" id="bbp_search" /> -->

		<input tabindex="<?php bbp_tab_index(); ?>" class="button" type="submit" id="bbp_search_submit" value="<?php esc_attr_e( 'Search', 'bbpress' ); ?>" />
	</div>
</form>
