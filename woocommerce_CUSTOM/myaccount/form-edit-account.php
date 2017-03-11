<?php
/**
 * Edit account form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>

<form action="" method="post">

	<?php do_action( 'woocommerce_edit_account_form_start' );  ?>

	<h3>Account Details</h3>
	<table border="0" cellpadding="0" cellspacing="0" width="80%">
		<tbody>
			<tr style="height: 2.5em;">
				<td style="vertical-align:middle;" width="150px">FIRST NAME:<span class="required">*</span></td>
				<td><input type="text" style='width:100%'  class="input-text" name="account_first_name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" />
				</td>
			</tr>
			<tr style="height: 2.5em;">
				<td style="vertical-align:middle;" width="150px">LAST NAME:<span class="required">*</span></td>
				<td><input type="text" style='width:100%' class="input-text" name="account_last_name" id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>" />
				</td>
			</tr>

			<tr style="height: 2.5em;">
				<td style="vertical-align:middle;" width="150px">EMAIL:<span class="required">*</span></td>
				<td><input type="email" style='width:100%' class="input-text" name="account_email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>" />
				</td>
			</tr>

			<tr style="height: 2.5em;">
				<td style="vertical-align:middle;" width="150px">ORGANIZATION:</td>
				<td><input type="text" style='width:100%' class="input-text" name="account_organization" id="account_organization" value="<?php  echo esc_attr( $user->billing_company) ;?>" />
				</td>
			</tr>

			<tr style="height: 2.5em;">
				<td style="vertical-align:middle;" width="150px">COUNTRY:<span class="required">*</span></td>
				<td><input type="text" style='width:100%' class="input-text" name="account_country" id="account_country" value="<?php echo esc_attr( $user->billing_country);?>" />
				</td>
			</tr>

		</tbody>

	</table>

	<div class="clear"></div>

	<h3>Change Password</h3>
	<table border="0" cellpadding="0" cellspacing="0" width="80%">
		<tbody>
			<tr style="height: 2.5em;">
				<td style="vertical-align:middle;" width="240px">OLD PASSWORD:</td>
				<td><input style='width:100%' type="password" class="input-text" name="password_current" id="password_current" />
				</td>
			</tr>
			<tr style="height: 2.5em;">
				<td style="vertical-align:middle;" width="240px">NEW PASSWORD:</td>
				<td><input style='width:100%' type="password" class="input-text" name="password_1" id="password_1" />
				</td>
			</tr>
			<tr style="height: 2.5em;">
				<td style="vertical-align:middle;" width="240px">CONFIRM NEW PASSWORD:</td>
				<td><input style='width:100%' type="password" class="input-text" name="password_2" id="password_2" />
				</td>
			</tr>
			
		</tbody>

	</table>
	<div class="clear"></div>



<?php
 
if (isset($_SERVER['HTTP_REFERER'])) // check if referrer is set
{
    $cancel_url =  $_SERVER['HTTP_REFERER']; // echo referrer
}
else
{
    $cancel_url = get_option( 'siteurl' );
}
 
?>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>
	<div class='form' style='padding-top:40px'>
		<p style="text-align:center; width: 320px; margin: 0 auto;">
			<?php wp_nonce_field( 'save_account_details' ); ?>
			<input type="submit" style=" font-size: 24px; width:320px; padding-left: 30px; padding-right: 30px;" class="button button-primary button-large" name="save_account_details" value="<?php _e( 'Save changes', 'woocommerce' ); ?>" />
			<input type="hidden" name="action" value="save_account_details" />
		</p>
		<p style="text-align:center; width: 320px; margin: 0 auto;"><a href='<?php echo $cancel_url; ?>'>Or Cancel</a></p>
	</div>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>

</form>

