<?php
/**
* Checkout coupon form
*
* @author  WooThemes
* @package WooCommerce/Templates
* @version 2.0.0
*
* Edited by WebMan
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

if ( ! $woocommerce->cart->coupons_enabled() )
	return;

$info_message = apply_filters('woocommerce_checkout_coupon_message', __( 'Have a coupon?', 'woocommerce' ));
?>

<div class="woocommerce-info box iconbox info color-blue">
	<?php echo $info_message; ?> <a href="#" class="showcoupon"><?php _e( 'Click here to enter your code', 'woocommerce' ); ?></a>
</div>

<form class="checkout_coupon" method="post" style="display:none">

	<p class="form-row column col-12">
		<input type="text" name="coupon_code" class="input-text" placeholder="<?php _e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
	</p>

	<p class="form-row column col-12 last">
		<input type="submit" class="button color-blue" name="apply_coupon" value="<?php _e( 'Apply Coupon', 'woocommerce' ); ?>" />
	</p>

	<div class="clear"></div>
</form>