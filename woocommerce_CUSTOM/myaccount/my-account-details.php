<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
/**
 * My Addresses
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $current_user;
get_currentuserinfo();

$customer_id = get_current_user_id();

$fname= $current_user->user_firstname;
$lname= $current_user->user_lastname;
$country= get_user_meta($customer_id, 'billing_country', true );
$email = $current_user->user_email;



// if ( ! wc_ship_to_billing_address_only() && get_option( 'woocommerce_calc_shipping' ) !== 'no' ) {
// 	$page_title = apply_filters( 'woocommerce_my_account_my_address_title', __( 'Account Details', 'woocommerce' ) );
// 	$get_addresses    = apply_filters( 'woocommerce_my_account_get_addresses', array(
// 		'billing' => __( 'Billing Address', 'woocommerce' )
// 	), $customer_id );
// } else {
// 	$page_title = apply_filters( 'woocommerce_my_account_my_address_title', __( 'Account Details', 'woocommerce' ) );
// 	$get_addresses    = apply_filters( 'woocommerce_my_account_get_addresses', array(
// 		'billing' =>  __( 'Billing Address', 'woocommerce' )
// 	), $customer_id );
// }


?>

<h2>Account Details</h2>


<table class="shop_table shop_table_responsive my_account_orders" style='table-layout: fixed; width: 100%;'>
	<thead>
		<tr>
			<th style='text-align:center' class="order-name"><span class="nobr"><?php _e( 'NAME', 'woocommerce' ); ?></span></th>
			<th style='text-align:center' class="order-last-name"><span class="nobr"><?php _e( 'LAST NAME', 'woocommerce' ); ?></span></th>
			<th style='text-align:center' class="order-email"><span class="nobr"><?php _e( 'EMAIL', 'woocommerce' ); ?></span></th>
			<th style='text-align:center' class="order-telephone"><span class="nobr"><?php _e( 'COUNTRY', 'woocommerce' ); ?></span></th>
			<th style='text-align:center' class="order-actions">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style='text-align:center'  class="order-name"> <?php echo $fname; ?>
			</td>
			<td style='text-align:center' class="order-last-name"><?php echo $lname; ?>
			</td>
			<td style='text-align:center' class="order-email"><?php echo $email; ?>
			</td>
			<td style='text-align:center' class="order-telephone"><?php echo $country; ?>
			</td>
			<td style='text-align:center' class="order-actions"><a  href="<?php echo wc_customer_edit_account_url() ?>" class="button"><?php _e( 'Update', 'woocommerce' ); ?></a>
		</tr>
	</tbody>
</table>





