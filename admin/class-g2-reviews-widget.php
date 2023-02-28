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
//		echo $instance['review_limit'];

		for ($i = 0; $i < $instance['review_limit']; $i++) {
			echo '<div class="wp-g2-reviews"><div class="wp-g2-rev-front"></div><div class="wp-g2-rev-data"><div class="wp-g2-answer" data-num="1" data-icon="flase" data-reviewer="Adam VanderHeiden" data-topic="Beyond QuickBooks" data-rating="3-5"><div data-qus="1">What do you like best about the product?</div><div data-ans="1">Its very easy to manage expenses and other reports. Very easy and convenient when billing schedules especially when using contract module. Its indeed helpful when you want to generate financial analysis.</div><div data-qus="2">What do you dislike about the product?</div><div data-ans="2">Havent experienced any difficulties so far.</div><div data-qus="3">What problems is the product solving and how is that benefiting you?</div><div data-ans="3">Its very easy to manage expenses and other reports. Very easy and convenient when billing schedules especially when using contract module. Its indeed helpful when you want to generate financial analysis.</div></div><div class="wp-g2-answer" data-num="2" data-icon="true" data-iconurl="https://www.sageintacct.com/themes/custom/sageintacct/images/g2-anonymous-avatar.svg" data-reviewer="Verified User in Health, Wellness and Fitness" data-topic="Reliable and always available tool" data-rating="5"><div data-qus="1">What do you like best about the product?</div><div data-ans="1">The chief benefits of using Sage Intacct are the product features and capabilities of the software.</div><div data-qus="2">What do you dislike about the product?</div><div data-ans="2">There is a learning curve to Sage Intacct, as it takes a while to get used to report-building features, import data template structures, etc.</div><div data-qus="3">What problems is the product solving and how is that benefiting you?</div><div data-ans="3">Automation. As I use features that improve automation, I see a massive benefit for my company.</div></div><div class="wp-g2-answer" data-num="3" data-icon="false" data-reviewer="Roberta Lambert" data-topic="Great accounting tool!" data-rating="5"><div data-qus="1">What do you like best about the product?</div><div data-ans="1">It has streamlined our data. Where we had many paper files earlier, we moved things here during my last project. We have made dashboards on it, which are direct and uncluttered. It now reduces our time for audits and improved decision-making. The best feature I liked was I could use wildcard characters like excel to search for bills.</div><div data-qus="2">What do you dislike about the product?</div><div data-ans="2">In-depth analyses of data using slice and dice are complex, so we export the data to PowerBI. Automating manual entries and logs for them will be a great addition to the software.</div><div data-qus="3">What problems is the product solving and how is that benefiting you?</div><div data-ans="3">During my last project, we set it up for the Accounting team. We were earlier manually bringing data from banks, payment gateways and manual files and collating and making reports, which are now all shifted to Sage Intacct. Now we are using it for cash management; even the HR team is also onboarded for payrolls. Manual intervention is reduced by 50%, as only one team is involved, and manual bill handling is also stopped.</div></div></div></div>';
		}
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
	$plugin_url = plugin_dir_url( __FILE__ );
	register_widget('G2_Reviews_Widget');
	wp_enqueue_style('G2-style', '/wp-content/plugins/g2-reviews/front/style.css', array(), '20190328');


}

add_action('widgets_init', 'wpb_load_widget');
