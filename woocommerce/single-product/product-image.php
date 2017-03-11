<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;

?>
<div class="images">

<?php

    $attachment_ids = $product->get_gallery_attachment_ids();

    isset ($placeholder_width)? : $placeholder_width=0;
    isset ($placeholder_height)? : $placeholder_height=0;

    if ( $attachment_ids ) {
        $attachment_id = $attachment_ids[0];

    if ( ! $placeholder_width )
        // $placeholder_width = $woocommerce->get_image_size( 'shop_catalog_image_width' );
    if ( ! $placeholder_height )
        // $placeholder_height = $woocommerce->get_image_size( 'shop_catalog_image_height' );

        $output = '<div class="imagewrapper">';

        //$classes = array( 'imagewrapper' );
        $classes = array();
        $image_link = wp_get_attachment_url( $attachment_id );

        if ( $image_link ) {

        $image       = wp_get_attachment_image( $attachment_id, apply_filters( 'shop_catalog_image_width', '700' ) );
        //	$image       = wp_get_attachment_image( $attachment_id );
        $image_class = esc_attr( implode( ' ', $classes ) );
       
        $image_title = esc_attr( get_the_title( $attachment_id ) );

        echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s"  rel="prettyPhoto[product-gallery]">%s</a>', $image_link, $image_title, $image ), $post->ID );

        } else {

            echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', woocommerce_placeholder_img_src() ), $post->ID );

        }

    }
?>

	<?php //do_action( 'woocommerce_product_thumbnails' ); ?>

</div>
