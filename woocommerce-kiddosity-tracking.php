<?php
/*
   Plugin Name: Woocommerce Kiddosity Tracking
   Plugin URI: http://wordpress.org/extend/plugins/woocommerce-kiddosity-tracking/
   Version: 0.1
   Author: Kiddosity
   Description: nada
   Text Domain: wkt
   License: GPLv3
  */



add_action( 'woocommerce_thankyou', 'my_custom_tracking' );

function my_custom_tracking( $order_id ) {

	// Lets grab the order
	$order = wc_get_order( $order_id );

	/**
	 * Put your tracking code here
	 * You can get the order total etc e.g. $order->get_total();
	 */
	 
	// This is the order total
	$order->get_total();
 
	// This is how to grab line items from the order 
	$line_items = $order->get_items();

	// This loops over line items
	foreach ( $line_items as $item ) {
  		// This will be a product
  		$product = $order->get_product_from_item( $item );
  
  		// This is the products SKU
		$sku = $product->get_sku();
		
		// This is the qty purchased
		$qty = $item['qty'];
		
		// Line item total cost including taxes and rounded
		$total = $order->get_line_total( $item, true, true );
		
		// Line item subtotal (before discounts)
		$subtotal = $order->get_line_subtotal( $item, true, true );
	}
}