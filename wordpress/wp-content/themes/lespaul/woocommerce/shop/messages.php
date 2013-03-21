<?php
/**
* Show messages
*
* @author  WooThemes
* @package WooCommerce/Templates
* @version 2.0.0
*
* Edited by WebMan
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! $messages ) return;
?>

<?php foreach ( $messages as $message ) : ?>
	<div class="woocommerce-message box color-green iconbox check"><?php echo $message; ?></div>
<?php endforeach; ?>
