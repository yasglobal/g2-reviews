<?php
/**
 * G2 Reviews View.
 *
 */
global $wpdb; ?>

<div class="wp-g2-reviews">
	<div class="wp-g2-rev-front">
		<?php
		if ($fileCall === 'widget') {
			$page_data = $wpdb->get_results('SELECT * FROM wp_g2_reviews LIMIT ' . $instance['review_limit']);
			foreach ($page_data as $data) {

				$comment_answers = maybe_unserialize($data->comment_answers);
				$secondary_answers = maybe_unserialize($data->secondary_answers);
				$other_attributes = maybe_unserialize($data->other_attributes);
				$newDate = date("d-m-Y", strtotime($other_attributes->submitted_at));
				$verified = ($other_attributes->verified_current_user == 1)?"rev-verified-user" :"";

				?>
				<div class="rev-user <?php echo $verified?>">
					<div class="rev-user-icon">
						<span><img src="https://www.sageintacct.com/themes/custom/sageintacct/images/g2-anonymous-avatar.svg"></span>
						<span><?php echo $other_attributes->user_name ?></span>
						<time datetime="<?php echo $newDate; ?>"><?php echo $newDate; ?></time>
					</div>
					<div class="rev-rate <?php echo 'star-' . str_replace(".", "-", $data->star_rating) ?>"><i></i> <i></i> <i></i> <i></i> <i></i></div>
					<div class="rev-topic"><?php echo $data->title ?></div>
					<div class="rev-qa-scroll">
						<div class="rev-q"><?php echo $comment_answers->love->text ?></div>
						<div class="rev-a"><?php echo $comment_answers->love->value ?></div>
						<div class="rev-q"><?php echo $comment_answers->hate->text ?></div>
						<div class="rev-a"><?php echo $comment_answers->hate->value ?></div>
						<div class="rev-q"><?php echo $comment_answers->recommendations->text ?></div>
						<div class="rev-a"><?php echo $comment_answers->recommendations->value ?></div>
					</div>
				</div>

			<?php }
		} else {
			$page_data = $wpdb->get_results('SELECT * FROM wp_g2_reviews LIMIT ' . $atts['review-items']);
			foreach ($page_data as $data) {
				$comment_answers = maybe_unserialize($data->comment_answers);
				$secondary_answers = maybe_unserialize($data->secondary_answers);
				$other_attributes = maybe_unserialize($data->other_attributes);
				$newDate = date("d-m-Y", strtotime($other_attributes->submitted_at));
				$verified = ($other_attributes->verified_current_user == 1)?"rev-verified-user" :"";
				?>
				<div class="rev-user <?php echo $verified?>">
					<div class="rev-user-icon">
						<span><img src="https://www.sageintacct.com/themes/custom/sageintacct/images/g2-anonymous-avatar.svg"></span>
						<span><?php echo $other_attributes->user_name ?></span>
						<time datetime="<?php echo $newDate; ?>"><?php echo $newDate; ?></time>
					</div>
					<div class="rev-rate <?php echo 'star-' . str_replace(".", "-", $data->star_rating) ?>"><i></i> <i></i> <i></i> <i></i> <i></i></div>
					<div class="rev-topic"><?php echo $data->title ?></div>
					<div class="rev-qa-scroll">
						<div class="rev-q"><?php echo $comment_answers->love->text ?></div>
						<div class="rev-a"><?php echo $comment_answers->love->value ?></div>
						<div class="rev-q"><?php echo $comment_answers->hate->text ?></div>
						<div class="rev-a"><?php echo $comment_answers->hate->value ?></div>
						<div class="rev-q"><?php echo $comment_answers->recommendations->text ?></div>
						<div class="rev-a"><?php echo $comment_answers->recommendations->value ?></div>
					</div>
				</div>
			<?php }
		} ?>
	</div>
</div>
