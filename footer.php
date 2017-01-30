<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MWD
 */

?>
		</div>
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container">
			<div class="col-md-2">
				<?php dynamic_sidebar( 'footer-1' ); ?>
			</div>
			<div class="col-md-2">
				<?php dynamic_sidebar( 'footer-2' ); ?>
			</div>
			<div class="col-md-2">
				<?php dynamic_sidebar( 'footer-3' ); ?>
			</div>
			<div class="col-md-5 col-md-offset-1">
				<?php dynamic_sidebar( 'footer-4' ); ?>
			</div>
		</div>
	</footer><!-- #colophon -->
	<div id="footer-contact">
		<div class="heading">Concierge</div>
		<div class="content">
			<?php echo do_shortcode('[gravityform id="2" title="false" description="false" ajax="true"]'); ?>
		</div>
	</div>
</div><!-- #page -->

<div style="display: none;">
	<div id="treasurehunt">
		<?php echo do_shortcode('[gravityform id="3" title="false" description="true" ajax="true"]'); ?>
	</div>
</div>
<script>
jQuery(document).ready(function($) {

	if($('.yith-wcwl-add-to-wishlist').length > 0) {
		if(!$('body').hasClass('logged-in')) {
			$('.yith-wcwl-add-to-wishlist').hide();
		}
	}

	var maxheight = '';
	$('.products li').each(function(index, el) {
		if($(this).height() > maxheight) {
			maxheight = $(this).height();
		}
	});
	$('.products li').height(maxheight);

	var blogheight = '';
	$('.similar .row .col-md-4').each(function(index, el) {
		if($(this).height() > blogheight) {
			blogheight = $(this).height();
		}
	});
	$('.similar .row .col-md-4').height(blogheight);

	$('.u-column1, .u-column2').height($('.u-columns').height());

	$( document ).ajaxStart(function() {
	 	if($('.filter-panel').is(':visible')) {
			$('.filter-panel').hide();
		}
	});

	$('.mobile-search').click(function(event) {
		$('.mobile-search-form').toggle();
	});

	$(window).resize(function(){
		var maxheight = '';
		$('.products li').each(function(index, el) {
			if($(this).height() > maxheight) {
				maxheight = $(this).height();
			}
		});
		$('.products li').height(maxheight);

		var blogheight = '';
		$('.similar .row .col-md-4').each(function(index, el) {
			if($(this).height() > blogheight) {
				blogheight = $(this).height();
			}
		});
		$('.similar .row .col-md-4').height(blogheight);
		$('.u-column1, .u-column2').height($('.u-columns').height());
	});
});
</script>
<?php wp_footer(); ?>

<?php if ( function_exists( 'is_product' ) && is_product() ) :
	global $post;
	$product = get_product( $post->ID );
	if ( $product->is_in_stock() ) {
		$price = $product->get_price();

	}
	?>
	<script type="text/javascript">
		var google_tag_params = {
			ecomm_prodid: '<?php echo esc_js( 'woocommerce_gpf_' . $product->id ); ?>',
			ecomm_pagetype: 'product',
			ecomm_totalvalue: <?php echo esc_js( number_format( $price, 2, '.', '') ); ?>
		};
	</script>
	<?php elseif ( function_exists( 'is_cart' ) && is_cart() ) :
		global $woocommerce;
	$products = $woocommerce->cart->get_cart();
?>
<script>

var id = new Array();
</script>
<?php
$product_ids = array();

			foreach( $products as $oneproduct ) {
?>
<script>
id.push(<?php echo "'woocommerce_gpf_" . str_replace( "'", "\\'", $oneproduct['product_id'] ) . "'"; ?>);
</script>
<?php
				$product_ids[] = "'woocommerce_gpf_" . str_replace( "'", "\\'", $oneproduct['product_id'] ) . "'";

			}
	?>
	<script type="text/javascript">
		var google_tag_params = {
			ecomm_prodid: id,
			ecomm_pagetype: 'cart',
			ecomm_totalvalue: <?php echo $woocommerce->cart->cart_contents_total; ?>
		};
	</script>


	<?php elseif ( function_exists('is_order_received_page') && is_order_received_page() ) :


		$order_id  = apply_filters( 'woocommerce_thankyou_order_id', empty( $_GET['order'] ) ? ($GLOBALS["wp"]->query_vars["order-received"] ? $GLOBALS["wp"]->query_vars["order-received"] : 0) : absint( $_GET['order'] ) );
		$order_key = apply_filters( 'woocommerce_thankyou_order_key', empty( $_GET['key'] ) ? '' : woocommerce_clean( $_GET['key'] ) );



		if ( $order_id > 0 ) {
			$order = new WC_Order( $order_id );
			if ( $order->order_key != $order_key )
				unset( $order );
		}

		if ( 1 == get_post_meta( $order_id, '_ga_tracked', true ) ) {
			unset( $order );
		}

		if ( isset( $order ) ) {
			$_products = array();
			$_sumprice = 0;
			$_product_ids = array();

			if ( $order->get_items() ) {
				foreach ( $order->get_items() as $item ) {
					$_product = $order->get_product_from_item( $item );

          $variation_data = null;

          if (get_class($_product) == "WC_Product_Variation") {
            $variation_data = $_product->get_variation_attributes();
          }

          if ( isset( $variation_data ) ) {
						$_category = woocommerce_get_formatted_variation( $_product->variation_data, true );

					} else {
						$out = array();
						$categories = get_the_terms( $_product->id, 'product_cat' );
						if ( $categories ) {
							foreach ( $categories as $category ) {
								$out[] = $category->name;
							}
						}

						$_category = implode( " / ", $out );
					}

					$_prodprice = $order->get_item_total( $item );

					$_products[] = array(
					  "id"       => $_product->id,
					  "name"     => $item['name'],
					  "sku"      => $_product->get_sku() ? __( 'SKU:', GTM4WP_TEXTDOMAIN ) . ' ' . $_product->get_sku() : $_product->id,
					  "category" => $_category,
					  "price"    => $_prodprice,
					  "currency" => get_woocommerce_currency(),
					  "quantity" => $item['qty']
					);


					$_sumprice += $_prodprice;
					$_product_ids[] = "'" . $_product->id . "'";

				}

			}


		}
	?>
	<script type="text/javascript">
		var google_tag_params = {
			ecomm_prodid: <?php echo implode( " ", $_product_ids ); ?>,
			ecomm_pagetype: 'purchase',
			ecomm_totalvalue: <?php echo $_sumprice; ?>
		};
	</script>



<?php else: ?>

	<script type="text/javascript">
if(window.location.pathname =='/')
{
		var google_tag_params = {
			ecomm_prodid: '',
			ecomm_pagetype: 'home',
			ecomm_totalvalue: ''
		};
}
if(window.location.href.indexOf('product-category') != -1)
{
var google_tag_params = {
			ecomm_prodid: '',
			ecomm_pagetype: 'category',
			ecomm_totalvalue: ''
		};
}
	</script>
<?php endif; ?>

<script>

dataLayer.push({'event':'d_rmkt','google_tag_params':window.google_tag_params});
</script>

</body>
</html>
