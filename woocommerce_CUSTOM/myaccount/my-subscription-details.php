<?php
/**
 * My Subscriptions
 */
?>
<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	error_reporting(0);

	$subscription_key = $_GET['key'];

	$subscription = WC_Subscriptions_Manager::get_subscription( $subscription_key );
	
	$order_id = $subscription['order_id'];
	$status = $subscription['status'];
	$product_id = $subscription['product_id'];
	$start_date = $subscription['start_date'];
	$end_date = $subscription['end_date'];
	$product_name = WC_Subscriptions_Order::get_item_name($order_id, $product_id ); 

	$order = new WC_Order( $order_id );
	$user = $order ->get_user();
	$subscriber_email = $user->user_email;
	$items = $order->get_items();
	
	
    foreach ( $order->get_items()as $item ) {
    	$delivery =  $item['pa_delivery'] ;
    	if ($item['iLok User ID']) $iLok_user_id = $item['iLok User ID'];
    	else $iLok_user_id =$item['ilok_id'];
    	$platform = $item['pa_platform'];
    }

  
	$interval = $subscription['interval'];
	$period =  $subscription['period'];
	$subscription_term = $interval . " ". $period;
	$start_date = $subscription['start_date'];
	$end_date = $subscription['end_date'];
	$deposits = [];

	$period_string = "+".$interval." ".$period;
	$payment_till_date=date('Y-m-d', strtotime($period_string, strtotime($start_date)) );
	$next_payment_date=WC_Subscriptions_Order::get_next_payment_date ( $order, $product_id ); /* This should get the next payment date... */
?>


<div class="woocommerce_account_subscriptions">
<h3>Subscription Details</h3>
	<table class="shop_table shop_table_responsive my_account_subscriptions my_account_orders">
		<tbody>
		<tr>
			<td style="padding-top: 15px; color: #666; font-weight: 600"><span class="nobr"><?php _e( 'PRODUCT NAME', 'woocommerce' ); ?></span></td>
			<td style="padding-top: 15px;"><?php echo $product_name ?></td>
			<td style="padding-top: 15px; color: #666; font-weight: 600"> <span class="nobr"><?php _e( 'ILOK USER ID', 'woocommerce' ); ?></span></td>
			<td style="padding-top: 15px;"><?php echo $iLok_user_id; ?></td>
		</tr>
		<tr>
			<td style="padding-top: 10px; color: #666; font-weight: 600"><span class="nobr"><?php _e( 'SUBSCRIPTION ID', 'woocommerce' ); ?></span></td>
			<td style="padding-top: 10px;"><?php echo $subscription_key ?></td>
			<td style="padding-top: 10px; color: #666; font-weight: 600"><span class="nobr"><?php _e( 'DELIVERY', 'woocommerce' ); ?></span></td>
			<td style="padding-top: 10px;"><?php echo $delivery; ?></td>
		</tr>
		<tr>
			<td style="padding-top: 10px; color: #666; font-weight: 600"><span class="nobr"><?php _e( 'ORDER', 'woocommerce' ); ?></span></td>
			<td style="padding-top: 10px;"><?php echo $order_id ?></td>
			<td style="padding-top: 10px; color: #666; font-weight: 600"><span class="nobr"><?php _e( 'PLATFORM', 'woocommerce' ); ?></span></td>
			<td style="padding-top: 10px;"><?php echo $platform; ?></td>
		</tr>
		<tr>
			<td style="padding-top: 10px; color: #666; font-weight: 600"><span class="nobr"><?php _e( 'STATUS', 'woocommerce' ); ?></span></td>
			<td style="padding-top: 10px;"><?php echo $status?></td>
			<td style="padding-top: 10px; color: #666; font-weight: 600"><span class="nobr"><?php _e( 'SUBSCRIPTION TERMS', 'woocommerce' ); ?></span></td>
			<td style="padding-top: 10px;"><?php echo $subscription_term; ?></td>
		</tr>
		<tr>
			<td style="padding-top: 10px; color: #666; font-weight: 600"><span class="nobr"><?php _e( 'START DATE', 'woocommerce' ); ?></span></strong></td>
			<td style="padding-top: 10px;"><time datetime="<?php echo date( 'Y-m-d', strtotime( $start_date ) ); ?>" title="<?php echo esc_attr( strtotime( $start_date ) ); ?>"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $start_date ) ); ?></time></td>
			<td style="padding-top: 10px; color: #666; font-weight: 600"><span class="nobr"><?php _e( 'SUBSCRIBER EMAIL', 'woocommerce' ); ?></span></td>
			<td style="padding-top: 10px;"><?php echo $subscriber_email ?></td>
		</tr>
		<tr>
			<td style="padding-top: 10px; color: #666; font-weight: 600"><span class="nobr"><?php _e( 'CANCELLATION DATE ', 'woocommerce' ); ?></span></td>
			<td style="padding-top: 10px;"><?php if ($end_date) { ?><time datetime="<?php echo date( 'Y-m-d', strtotime( $end_date ) ); ?>" title="<?php echo esc_attr( strtotime(  $end_date ) ); ?>"><?php echo date_i18n( get_option( 'date_format' ), strtotime(  $end_date) ); ?></time> <?php } ?> </td>
			<!-- <td style="padding-top: 10px; color: #666; font-weight: 600"><span class="nobr"><?php _e( 'PAYMENT METHOD', 'woocommerce' ); ?></span></td>
			<td style="padding-top: 10px;"><?php echo $order->payment_method_title ?></td> -->
			<td></td>
		</tr>
	</tbody>
		

	</table>
	

	<?php 
	echo do_shortcode('[IC_License_Details payment_till_date="'.$payment_till_date.'" next_payment_date="'.$next_payment_date.'" subscription_key="'.$subscription_key.'" ilok_id="'.$iLok_user_id.'"]'); 
	
	?>

