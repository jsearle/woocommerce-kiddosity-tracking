<?php
/*
   Plugin Name: Woocommerce Kiddosity Tracking
   Plugin URI: http://wordpress.org/extend/plugins/woocommerce-kiddosity-tracking/
   Version: 0.1
   Author: Kiddosity
   Description: Woocommerce plugin for pixel tracking on Kiddosity marketplace
   Text Domain: wkt
   License: GPLv3
  */



add_action( 'woocommerce_thankyou', 'wkt_custom_tracking' );
function wkt_custom_tracking( $order_id ) {

	// Lets grab the order
	$order = wc_get_order( $order_id );

	/**
	 * Put your tracking code here
	 * You can get the order total etc e.g. $order->get_total();
	 */
	 
	// This is the order total
	$tot = $order->get_total();
	
	$client_id = esc_attr( get_option('client_id') );
	
    wp_enqueue_script( 'wkt-thankyou', plugin_dir_url( __FILE__ ) . 'js/thankyou.js', array(), false, true );
	wp_add_inline_script( 'wkt-thankyou', 'var kd_total = '.$tot.'; var kd_client = "'+$client_id+'"; var kd_order="'+$order_id+'";','before' );
	
	/*
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
	*/
}




function wkt_footer_scripts() {
	?>
	<script type="text/javascript">
	var kd_token = decodeURIComponent((new RegExp('[?|&]kiddotoken=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [null, ''])[1].replace(/\+/g, '%20')) || null;
	if(kd_token){ var d = new Date(); d.setYear(d.getFullYear()+1);document.cookie = "kiddo=" + kd_token + "; expires="+d.toUTCString()+"; path=/"; }
	</script>
	<?php
}
add_action( 'wp_footer', 'wkt_footer_scripts' );







function wkt_create_menu() {
	add_menu_page('Kiddosity', 'Ajustes Kiddosity', 'administrator', __FILE__, 'wkt_settings_page' , plugins_url('/images/icon.png', __FILE__) );
	add_action( 'admin_init', 'register_wkt_settings' );
}
add_action('admin_menu', 'wkt_create_menu');


function register_wkt_settings() {
	register_setting( 'wkt-settings-group', 'client_id' );
}

function wkt_settings_page() {
?>
<div class="wrap">
<h1>Kiddosity</h1>
<p>Si necesita ayuda o desconoce su ID de cliente, póngase en contacto con nosotros en <a href="mailto:info@kiddosity.com" target="_blank">info@kiddosity.com</a>.
<form method="post" action="options.php">
    <?php settings_fields( 'wkt-settings-group' ); ?>
    <?php do_settings_sections( 'wkt-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">ID de cliente</th>
        <td><input type="text" name="client_id" value="<?php echo esc_attr( get_option('client_id') ); ?>" /></td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
<a href="https://kiddosity.com" target="_blank">kiddosity.com</a>
</div>
<?php }

