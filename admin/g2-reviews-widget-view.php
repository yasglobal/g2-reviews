<?php
/**
 * G2 Reviews View.
 *
 */
global $wpdb;

$page_data = $wpdb->get_results('SELECT * FROM wp_g2_reviews');
print_r($page_data);

?>
<div class="wp-g2-reviews">
	<div class="wp-g2-rev-front">
		<?php
		if ($fileCall === 'widget') {
			for ($i = 0; $i < $instance['review_limit']; $i++) {
				echo '<div data-rev="' . $i + 1 . '" class="rev-verified-user">
					  <div class="rev-user-icon">
						<span><img src="https://www.sageintacct.com/themes/custom/sageintacct/images/g2-anonymous-avatar.svg"></span>
						<span>Verified User in Health, Wellness and Fitness</span>
						<time datetime="2021-09-23">23 Sep 2021</time>
					  </div>
					  <div class="rev-rate star-3-5"> <i></i> <i></i> <i></i> <i></i> <i></i> </div>
					  <div class="rev-topic">Reliable and always available tool</div>
					  <div class="rev-qa-scroll">
							<div class="rev-q">What do you like best about the product?</div>
							<div class="rev-a">The chief benefits of using Sage Intacct are the product features and capabilities of the software.</div>
							<div class="rev-q">What do you dislike about the product?</div>
							<div class="rev-a">There is a learning curve to Sage Intacct, as it takes a while to get used to report-building features, import data template structures, etc.</div>
							<div class="rev-q">What problems is the product solving and how is that benefiting you?</div>
							<div class="rev-a">Automation. As I use features that improve automation, I see a massive benefit for my company.</div>
						</div>
					</div>';
			}
		} else {
			for ($i = 0; $i < $atts['review-items']; $i++) {
				$output .= '<div data-rev="' . $i + 1 . '" class="rev-verified-user" style="width:' . esc_html($atts['width']) . 'px">
					  <div class="rev-user-icon">
						<span><img src="https://www.sageintacct.com/themes/custom/sageintacct/images/g2-anonymous-avatar.svg"></span>
						<span>Verified User in Health, Wellness and Fitness</span>
						<time datetime="2021-09-23">23 Sep 2021</time>
					  </div>
					  <div class="rev-rate star-3-5"> <i></i> <i></i> <i></i> <i></i> <i></i> </div>
					  <div class="rev-topic">Reliable and always available tool</div>
						<div class="rev-qa-scroll">
							<div class="rev-q">What do you like best about the product?</div>
							<div class="rev-a">The chief benefits of using Sage Intacct are the product features and capabilities of the software.</div>
							<div class="rev-q">What do you dislike about the product?</div>
							<div class="rev-a">There is a learning curve to Sage Intacct, as it takes a while to get used to report-building features, import data template structures, etc.</div>
							<div class="rev-q">What problems is the product solving and how is that benefiting you?</div>
							<div class="rev-a">Automation. As I use features that improve automation, I see a massive benefit for my company.</div>
						</div>
					</div>';
			}
		} ?>
	</div>
</div>
