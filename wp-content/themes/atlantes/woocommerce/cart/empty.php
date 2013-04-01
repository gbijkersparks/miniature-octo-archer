<?php
/**
* Empty cart page
*
* @author 		WooThemes
* @package 	WooCommerce/Templates
* @version     1.6.4
*
* Edited by WebMan
*/
?>

<div class="box color-orange iconbox warning"><?php _e('Your cart is currently empty.', 'woocommerce') ?></div>

<?php do_action('woocommerce_cart_is_empty'); ?>

<p><a class="button" href="<?php echo get_permalink(woocommerce_get_page_id('shop')); ?>"><?php _e('&larr; Return To Shop', 'woocommerce') ?></a></p>