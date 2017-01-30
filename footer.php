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

</body>
</html>
