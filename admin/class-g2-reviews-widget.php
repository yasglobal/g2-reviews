<?php
/**
 * G2 Reviews Widget.
 *
 * @package G2Reviews
 */

if (!class_exists('WP_Widget')) {
	require_once(ABSPATH . 'wp-includes/class-wp-widget.php');
}

class G2_Reviews_Widget extends WP_Widget
{
	function __construct()
	{
		parent::__construct(
			'my_reviews',
			__('My Reviews', 'text_domain'),
			array('description' => __('Your plugin widget description.', 'text_domain'),)
		);
	}

	public function widget($args, $instance)
	{
		// Output the widget frontend
		echo $args['before_widget'];

		// Get the widget title
		$title = apply_filters('widget_title', $instance['title']);
		if (!empty($title)) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		echo '<div class="wp-g2-reviews"> <div class="wp-g2-rev-front">';
		for ($i = 0; $i < $instance['review_limit']; $i++) {
			echo '<div data-rev="2"><div class="rev-user-icon"><span><img src="https://www.sageintacct.com/themes/custom/sageintacct/images/g2-anonymous-avatar.svg"></span><span>Verified User in Health, Wellness and Fitness</span></div><div class="rev-rate star-3-5"><i></i><i></i><i></i><i></i><i></i></div><div class="rev-topic">Reliable and always available tool</div><div class="rev-q">What do you like best about the product?</div><div class="rev-a">The chief benefits of using Sage Intacct are the product features and capabilities of the software.</div><div class="rev-q">What do you dislike about the product?</div><div class="rev-a">There is a learning curve to Sage Intacct, as it takes a while to get used to report-building features, import data template structures, etc.</div><div class="rev-q">What problems is the product solving and how is that benefiting you?</div><div class="rev-a">Automation. As I use features that improve automation, I see a massive benefit for my company.</div></div>';
		}
		echo '  </div></div>';
		echo $args['after_widget'];
	}


	public function form($instance)
	{
		// Output the widget settings form
		$title = isset($instance['title']) ? $instance['title'] : '';
		$review_limit = isset($instance['review_limit']) ? $instance['review_limit'] : '';
		$options = array(
			'1',
			'2',
			'3',
			'4',
			'5',
			'6',
			'7',
			'8',
			'9',
			'10',
		);
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('review_limit'); ?>"><?php _e('Review Limit'); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('review_limit'); ?>" name="<?php echo $this->get_field_name('review_limit'); ?>">
				<?php foreach ($options as $option) : ?>
					<option value="<?php echo esc_attr($option); ?>" <?php selected($review_limit, $option); ?>><?php echo esc_html($option); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<?php
	}

	public function update($new_instance, $old_instance)
	{
		// Save widget settings
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['review_limit'] = sanitize_text_field($new_instance['review_limit']);
		return $instance;
	}

}

function wpb_load_widget()
{
	register_widget('G2_Reviews_Widget');
	wp_enqueue_style('G2-style', '/wp-content/plugins/g2-reviews/assets/style.css', array(), '20190328');
	wp_enqueue_script('G2-script', '/wp-content/plugins/g2-reviews/assets/script.js', array(), '20161114', true);
}

add_action('widgets_init', 'wpb_load_widget');
