<?php

/**
 * Archive Forum Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
<?php error_reporting(E_ALL & ~E_NOTICE); ?>
<div id="bbpress-forums"> 
	<?php if ( bbp_allow_search() ) : ?>

	<?php endif; ?>

	<?php bbp_breadcrumb(); ?>

	<?php bbp_forum_subscription_link(); ?>


	<?php do_action( 'bbp_template_before_forums_index' ); ?>

	<?php if ( bbp_has_forums() ) : ?>

		<?php //bbp_get_template_part( 'loop',     'forums'    ); ?>
		<?php bbp_get_template_part( 'loop',     'custom-forum'    ); ?>

	<?php else : ?>

		<?php bbp_get_template_part( 'feedback', 'no-forums' ); ?>

	<?php endif; ?>

	<?php do_action( 'bbp_template_after_forums_index' ); ?>

</div>
