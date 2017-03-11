<?php
/**
 * Customer renewal invoice email
 *
 * @author	Brent Shepherd
 * @package WooCommerce_Subscriptions/Templates/Emails
 * @version 1.4
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php do_action( 'woocommerce_email_header', $email_heading ); ?>

<?php $order->status = 'failed'; ?>
<?php if ( $order->status == 'pending' ) : ?>
	<p><?php printf( __( 'An invoice has been created for you to renew your subscription with %s. To pay for this invoice please use the following link: <a href="%s">Pay Now &raquo;</a>', 'woocommerce-subscriptions' ), get_bloginfo( 'name' ), esc_url( $order->get_checkout_payment_url() ) ); ?></p>
<?php elseif ( 'failed' == $order->status ) : ?>
	<p>Hi <?php echo $order->billing_first_name?>
	<p>We were not able to process the next payment for your V-Control Pro Bundle subscription. 
	Please login to your account at Neyrinck to <a  style='color:#0599d8' href='https://neyrinck.com/store/my-account'> edit your payment information </a> and to <a style='color:#0599d8' href='https://neyrinck.com/store/my-account/'> manage your subscriptions </a>
	so that your V-Control Pro Bundle license will not expire. </p>	

	<p><?php //printf( __( 'The automatic payment to renew your subscription with %s has <em>failed</em>. To reactivate the subscription, please login and pay for the renewal from your account page: <a href="%s">Pay Now &raquo;</a>', 'woocommerce-subscriptions' ), get_bloginfo( 'name' ), esc_url( $order->get_checkout_payment_url() ) ); ?></p>
<?php endif; ?>

<?php do_action( 'woocommerce_email_before_order_table', $order, false ); ?>


<h2>
<?php printf( __( 'Order #%s', 'woocommerce'), $order->get_order_number() ); ?> (<?php printf( '<time datetime="%s">%s</time>', date_i18n( 'c', strtotime( $order->order_date ) ), date_i18n( wc_date_format(), strtotime( $order->order_date ) ) ); ?>)</h2>
</h2>

<table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
	<thead>
		<tr>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Product', 'woocommerce-subscriptions' ); ?></th>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Quantity', 'woocommerce-subscriptions' ); ?></th>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Price', 'woocommerce-subscriptions' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php echo $order->email_order_items_table( false, true, false ); ?>
	</tbody>
	<tfoot>
		<?php 
			if ( $totals = $order->get_order_item_totals() ) {
				$i = 0;
				foreach ( $totals as $total ) {
					$i++;
					?><tr>
						<th scope="row" colspan="2" style="text-align:left; border: 1px solid #eee; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>"><?php echo $total['label']; ?></th>
						<td style="text-align:left; border: 1px solid #eee; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>"><?php echo $total['value']; ?></td>
					</tr><?php 
				}
			}
		?>
	</tfoot>
</table>

<?php do_action( 'woocommerce_email_after_order_table', $order, false ); ?>

<br/><br/>
<p>Thank you,<br/>Neyrinck Team
</p>

<?php do_action( 'woocommerce_email_footer' ); ?>