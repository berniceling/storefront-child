<?php
/**
 * Order details
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$order = wc_get_order( $order_id );

?>

<h2><?php _e( 'Order Details', 'woocommerce' ); ?></h2>

<table class="shop_table  my_account_orders" style='margin-top: 30px;'>
	<tbody>
		<tr>
			<td><strong><span class="nobr"><?php _e( 'ORDER', 'woocommerce' ); ?></span></strong></td>
			<td> <?php echo $order->get_order_number(); ?></td>
			<td><strong><span class="nobr"><?php _e( 'DATE', 'woocommerce' ); ?></span></strong></td>
			<td><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></td>
		</tr>
		<tr>
			<td style="padding-top: 20px;"><strong><span class="nobr"><?php _e( 'EMAIL', 'woocommerce' ); ?></span></strong></td>
			<td style="padding-top: 20px;"><?php if ( $order->billing_email ) { echo $order->billing_email; } ?></td>
			<td style="padding-top: 20px;"><strong><span class="nobr"><?php _e( 'PAYMENT METHOD', 'woocommerce' ); ?></span></strong></td>
			<td style="padding-top: 20px;"><?php echo $order->payment_method_title ?></td>
		</tr>
	</tbody>
</table>


<table class="shop_table  my_account_orders" style='margin-top: 30px;' style='table-layout: fixed; width: 100%;'>
	<thead>
		<tr>
			<th style='text-align:center' ><span class="nobr"><?php _e( 'PRODUCT NAME', 'woocommerce' ); ?></span></th>
			<th style='text-align:center' ><span class="nobr"><?php _e( 'QTY', 'woocommerce' ); ?></span></th>
			<th style='text-align:center' ><span class="nobr"><?php _e( 'UNIT/YEARLY PRICE', 'woocommerce' ); ?></span></th>
			<th style='text-align:center' ><span class="nobr"><?php _e( 'TOTAL', 'woocommerce' ); ?></span></th>
			<th style='text-align:center' ><span class="nobr"><?php _e( 'STATUS', 'woocommerce' ); ?></span></th>
			<th style='text-align:center' ><span class="nobr"><?php _e( '', 'woocommerce' ); ?></span></th>
			
		</tr>
	</thead>
	<tbody>


		<?php
		if ( sizeof( $order->get_items() ) > 0 ) {
			foreach( $order->get_items() as $item_id => $item ) {
				$_product  = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );
				$item_meta = new WC_Order_Item_Meta( $item['item_meta'], $_product );

				if ( apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
					?>
					<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'order_item', $item, $order ) ); ?>">
						<td class="product-name" style='text-align:center'>
							<?php
								if ( $_product && ! $_product->is_visible() ) {
									echo apply_filters( 'woocommerce_order_item_name', $item['name'], $item );
								} else {
									echo apply_filters( 'woocommerce_order_item_name', sprintf( '<a href="%s">%s</a>', get_permalink( $item['product_id'] ), $item['name'] ), $item );
								}
						?>
						</td>
						<td style='text-align:center'> <?php
								echo apply_filters( 'woocommerce_order_item_quantity_html', $item['qty']);
							?>
						</td>
						<td style='text-align:center' class="product-unit-price" style='text-align:center'>
							<?php echo $_product->get_price_html(); ?>
						</td>
						<td style='text-align:center' lass="product-total">
							<?php echo $order->get_formatted_line_subtotal( $item ); ?> 
						</td>

						<td style='text-align:center' class="order-status" data-title="<?php _e( 'Status', 'woocommerce' ); ?>" style="text-align:left; white-space:nowrap;">
							<?php echo wc_get_order_status_name( $order->get_status() ); ?>
						</td>
						<td style='text-align:center' class="order-actions">
						<?php
							$actions = array();

							if ( in_array( $order->get_status(), apply_filters( 'woocommerce_valid_order_statuses_for_payment', array( 'pending', 'failed' ), $order ) ) ) {
								$actions['pay'] = array(
									'url'  => $order->get_checkout_payment_url(),
									'name' => __( 'Pay Now', 'woocommerce' )
								);
							}

							if ( in_array( $order->get_status(), apply_filters( 'woocommerce_valid_order_statuses_for_cancel', array( 'pending', 'failed' ), $order ) ) ) {
								$actions['cancel'] = array(
									'url'  => $order->get_cancel_order_url( wc_get_page_permalink( 'myaccount' ) ),
									'name' => __( 'Cancel', 'woocommerce' )
								);
							}

							$actions = apply_filters( 'woocommerce_my_account_my_orders_actions', $actions, $order );

							if ($actions) {
								foreach ( $actions as $key => $action ) {
									echo '<a href="' . esc_url( $action['url'] ) . '" class="button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
								}
							}
						?>
					</td>
					</tr>
					<?php
				}}}
						do_action( 'woocommerce_order_items_table', $order );
						?>



		
	</tbody>
</table>


<div style='float:right; padding-top: 50px;'>
<span style='width: 200px'><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account','woothemes'); ?>"><?php _e('BACK TO MY ACCOUNT','woothemes'); ?></a></span>
<span style='padding-left: 30px; width: 200px'><a href='#' onclick='window.print()';> PRINT THIS PAGE</a></span>


</div>

