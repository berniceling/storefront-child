<?php
/**
 * Customer completed order email
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>


<?php do_action( 'woocommerce_email_header', $email_heading ); ?>
<p><?php printf( __( 'Hi %s,', 'woocommerce' ), $order->billing_first_name ); ?></p>

<p>
	Your order on NEYRINCK has been completed. 
	The order details are shown below for your reference. 
	If you have any questions about your order, please contact us at <a style='color:#0599d8' href="mailto:support@neyrinck.com" target="_top">support@neyrinck.com</a>. 
	You can also access the order details by logging in to your account at <a style='color:#0599d8' href='https://neyrinck.com/store/my-account/'>Neyrinck Store</a>.
</p>


<?php do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text ); ?>



<h2>
<?php printf( __( 'Order #%s', 'woocommerce'), $order->get_order_number() ); ?> (<?php printf( '<time datetime="%s">%s</time>', date_i18n( 'c', strtotime( $order->order_date ) ), date_i18n( wc_date_format(), strtotime( $order->order_date ) ) ); ?>)</h2>
</h2>

<table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
	<thead>
		<tr>
			<th scope="col" style="text-align:left; border: 1px solid #eee; width:70%;"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th scope="col" style="text-align:left; border: 1px solid #eee; width:10%;"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th scope="col" style="text-align:left; border: 1px solid #eee; width:20%;"><?php _e( 'Price', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php echo $order->email_order_items_table( true, false, true ); ?>
	</tbody>
	<tfoot>
		<?php
			if ( $totals = $order->get_order_item_totals() ) {
				$i = 0;
				foreach ( $totals as $total ) {
					$i++;
					?><tr>
						<th scope="row" colspan="2" style="text-align:left; border: 1px solid #eee; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>"><?php echo $total['label']; ?></th>
						<td style="text-align:left; border: 1px solid #eee; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>">

						<?php 
							if ($i==1) echo $totals['order_total']['value'];
							else echo $total['value']; 

							?></td>
					</tr><?php
				}
			}
		?>
	</tfoot>
</table>

<?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text ); ?>

<?php do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text ); ?>

<?php //do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text ); ?>
<br/><br/>
<p>Thank you,<br/>Neyrinck Team
</p>

<?php do_action( 'woocommerce_email_footer' ); ?>




