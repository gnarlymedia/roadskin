<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';

if ("variable" == $product->product_type) {
	$classes[] = 'gs_product_item_min_width';
}
?>

<li <?php post_class( $classes ); ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<a href="<?php the_permalink(); ?>">

		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
		?>

		<h3><?php the_title(); ?></h3>

		<?php 
		/** 
		* ADD PRODUCT VARIABLE WITH ADD TO CART ON CATALOG PAGE 
		ADDED BY GW 
		**/ 
		?>
		
		<?php 
		//ADD SHORT DESCRIPTION TO PRODUCT 
/* 		add_action('woocommerce_after_shop_loop_item_title','woocommerce_template_single_excerpt', 5); */
		
		/** 
		* woocommerce_after_shop_loop_item_title hook 
		* 
		* @hooked woocommerce_template_loop_rating - 5 
		* @hooked woocommerce_template_loop_price - 10 
		*/
		
		do_action( 'woocommerce_after_shop_loop_item_title' );
		
		?>
		
	</a>
	
	<?php
/* 		do_action( 'woocommerce_after_shop_loop_item' ); */
		
		//ADD VARIATIONS BEFORE ADD TO CART
		
		if ("variable" == $product->product_type) {
			woocommerce_variable_add_to_cart(); 
		} else {
			do_action( 'woocommerce_after_shop_loop_item' );
/* 			woocommerce_template_loop_add_to_cart();  */
		}
		
		?>
		
</li>