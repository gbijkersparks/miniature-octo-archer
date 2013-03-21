<?php
/**
* Show error messages
*
* @author  WooThemes
* @package WooCommerce/Templates
* @version 2.0.0
*
* Edited by WebMan
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! $errors ) return;
?>
<div class="woocommerce-error box iconbox error color-red">
	<ul>
		<?php foreach ( $errors as $error ) : ?>
			<li><?php echo wp_kses_post( $error ); ?></li>
		<?php endforeach; ?>
	</ul>
</div>