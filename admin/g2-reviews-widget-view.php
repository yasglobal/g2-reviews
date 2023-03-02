<?php
/**
 * G2 Reviews View.
 *
 */
global $wpdb;

$output = 'Testing';
/*
?>

<div class="wp-g2-reviews">
	<div class="wp-g2-rev-front">
		<?php

		if ($fileCall === 'widget') {
			$item = $instance['review_limit'];
		}else{
			$item = $atts['review-items'];
			$items_row = $atts['items-row'];
			?>
			<svg style="display:none"><style>:root .wp-g2-reviews {--box-number:<?php echo $items_row;?>;}</style></svg>
			<?php
		}

			?>

			<?php
			$page_data = $wpdb->get_results('SELECT * FROM wp_g2_reviews LIMIT ' . $item);
			foreach ($page_data as $data) {
				if(isset($_GET['cucu'])){
				print '<pre>';
				print_r(maybe_unserialize($data->other_attributes));
				print '</pre>';
				}
				$comment_answers = maybe_unserialize($data->comment_answers);
				$secondary_answers = maybe_unserialize($data->secondary_answers);
				$other_attributes = maybe_unserialize($data->other_attributes);
				$newDate = date("d M, Y", strtotime($other_attributes->submitted_at));
				$newDateAttr = date("Y-m-d", strtotime($other_attributes->submitted_at));
				$verified = ($other_attributes->verified_current_user == 1) ? "<i></i>" : "";
				$g2_user = maybe_unserialize($data->user);
				if (strpos($g2_user['user_image_url'], 'http') === false ||
					!preg_match('/\.(svg|png|jpeg)$/', $g2_user['user_image_url'])) {
					 $g2_user_image = substr($g2_user['user_name'], 0, 1);
				}else{
					$g2_user_image = '<img src="'.$g2_user['user_image_url'].'" alt="'.$g2_user['user_name'].'">';
				}

				?>
				<div class="rev-user">
					<div class="rev-user-icon">
						<span class="user-image"><?php echo $g2_user_image;?></span>
						<span class="user-name"><?php echo $g2_user['user_name']; ?><?php echo $verified ?></span>
            <div class="rev-rate <?php echo 'star-' . str_replace(".", "-", $data->star_rating) ?>"><i></i> <i></i> <i></i> <i></i> <i></i></div>
						<time datetime="<?php echo $newDateAttr; ?>"><?php echo $newDate; ?></time>
					</div>
					<div class="rev-qa-scroll">
            <div class="rev-topic"><?php echo $data->title ?></div>
						<?php foreach($comment_answers as $queston_answer){?>
							<?php if(!empty($queston_answer->value) && $queston_answer->value != 'NA'){?>
								<div class="rev-q"><?php echo $queston_answer->text ?></div>
								<div class="rev-a"><?php echo $queston_answer->value ?></div>
							<?php } ?>
						<?php } ?>
					</div>
				</div>
			<?php }?>
	</div>
</div>
*/
