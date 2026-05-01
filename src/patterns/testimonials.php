<?php
/**
 * Title: Testimonials
 * Slug: seiler-2026/testimonials
 * Categories: seiler-testimonials
 * Description: Customer testimonials section. Use Splide Carousel plugin to create a testimonial slider.
 */
?>

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|x-large","bottom":"var:preset|spacing|x-large","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"},"margin":{"top":"0","bottom":"0"}}},"backgroundColor":"white","className":"testimonials-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull testimonials-section has-white-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--x-large);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--x-large);padding-left:var(--wp--preset--spacing--medium)">
	<!-- wp:heading {"textAlign":"center","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|large"}},"typography":{"fontSize":"48px"}}} -->
	<h2 class="wp-block-heading has-text-align-center" style="margin-bottom:var(--wp--preset--spacing--large);font-size:48px">What Our Customers Say</h2>
	<!-- /wp:heading -->

	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|large","left":"var:preset|spacing|large"}}}} -->
	<div class="wp-block-columns alignwide">
		<!-- wp:column {"style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"}},"border":{"width":"1px","color":"var(--wp--preset--color--light-gray)","radius":"8px"}},"backgroundColor":"light-gray","className":"testimonial-card is-style-hover-lift"} -->
		<div class="wp-block-column testimonial-card is-style-hover-lift has-light-gray-background-color has-background has-border-color" style="border-color:var(--wp--preset--color--light-gray);border-width:1px;border-radius:8px;padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--medium)">
			<!-- wp:paragraph {"style":{"typography":{"fontSize":"18px"}}} -->
			<p style="font-size:18px;line-height:1.6">"The team provided exceptional support throughout our entire implementation. Their expertise and solutions are unmatched."</p>
			<!-- /wp:paragraph -->

			<!-- wp:separator {"style":{"spacing":{"margin":{"top":"var:preset|spacing|small","bottom":"var:preset|spacing|small"}}}} /-->

			<!-- wp:paragraph {"style":{"typography":{"fontWeight":"600"}},"fontSize":"medium"} -->
			<p class="has-medium-font-size" style="font-weight:600">Chief John Anderson</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"textColor":"medium-gray","fontSize":"small"} -->
			<p class="has-medium-gray-color has-text-color has-small-font-size">Metro Police Department</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"}},"border":{"width":"1px","color":"var(--wp--preset--color--light-gray)","radius":"8px"}},"backgroundColor":"light-gray","className":"testimonial-card is-style-hover-lift"} -->
		<div class="wp-block-column testimonial-card is-style-hover-lift has-light-gray-background-color has-background has-border-color" style="border-color:var(--wp--preset--color--light-gray);border-width:1px;border-radius:8px;padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--medium)">
			<!-- wp:paragraph {"style":{"typography":{"fontSize":"18px"}}} -->
			<p style="font-size:18px;line-height:1.6">"We've been partners for over 15 years. Their reliability and cutting-edge technology keep our operations running smoothly."</p>
			<!-- /wp:paragraph -->

			<!-- wp:separator {"style":{"spacing":{"margin":{"top":"var:preset|spacing|small","bottom":"var:preset|spacing|small"}}}} /-->

			<!-- wp:paragraph {"style":{"typography":{"fontWeight":"600"}},"fontSize":"medium"} -->
			<p class="has-medium-font-size" style="font-weight:600">Sarah Martinez</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"textColor":"medium-gray","fontSize":"small"} -->
			<p class="has-medium-gray-color has-text-color has-small-font-size">Emergency Services Coordinator</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"style":{"spacing":{"padding":{"top":"var:preset|spacing|medium","bottom":"var:preset|spacing|medium","left":"var:preset|spacing|medium","right":"var:preset|spacing|medium"}},"border":{"width":"1px","color":"var(--wp--preset--color--light-gray)","radius":"8px"}},"backgroundColor":"light-gray","className":"testimonial-card is-style-hover-lift"} -->
		<div class="wp-block-column testimonial-card is-style-hover-lift has-light-gray-background-color has-background has-border-color" style="border-color:var(--wp--preset--color--light-gray);border-width:1px;border-radius:8px;padding-top:var(--wp--preset--spacing--medium);padding-right:var(--wp--preset--spacing--medium);padding-bottom:var(--wp--preset--spacing--medium);padding-left:var(--wp--preset--spacing--medium)">
			<!-- wp:paragraph {"style":{"typography":{"fontSize":"18px"}}} -->
			<p style="font-size:18px;line-height:1.6">"Outstanding training and customer service. They truly understand the unique challenges of our industry."</p>
			<!-- /wp:paragraph -->

			<!-- wp:separator {"style":{"spacing":{"margin":{"top":"var:preset|spacing|small","bottom":"var:preset|spacing|small"}}}} /-->

			<!-- wp:paragraph {"style":{"typography":{"fontWeight":"600"}},"fontSize":"medium"} -->
			<p class="has-medium-font-size" style="font-weight:600">Captain Michael Roberts</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"textColor":"medium-gray","fontSize":"small"} -->
			<p class="has-medium-gray-color has-text-color has-small-font-size">City Fire Department</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"top":"var:preset|spacing|medium"}},"typography":{"fontSize":"14px"}},"textColor":"medium-gray","className":"slider-note"} -->
	<p class="has-text-align-center slider-note has-medium-gray-color has-text-color" style="margin-top:var(--wp--preset--spacing--medium);font-size:14px"><em>Note: Use Splide Carousel plugin to convert this into a rotating testimonial slider.</em></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
