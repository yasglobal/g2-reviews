<?php
/**
 * G2 Reviews Settings.
 *
 * @package G2Reviews
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create HTML of G2 Reviews Settings page.
 */
class G2_Reviews_Settings {
	/**
	 * Call G2 Settings Function.
	 */
	public function __construct() {
		$this->page_settings();
	}
	/**
	 * Save Reviews Settings.
	 *
	 * @access private
	 * @since 1.0.0
	 */
	private function save_reviews_settings() {
		$form_submit = filter_input( INPUT_POST, 'submit' );
		$user_id     = get_current_user_id();

		if ( $form_submit
			&& check_admin_referer( 'g2-reviews_' . $user_id, '_g2_reviews_nonce' )
		) {
			$g2_apikey = filter_input( INPUT_POST, 'g2_apikey' ); // Get G2 API key from POST request
			$g2_productId = filter_input( INPUT_POST, 'g2_productId' ); // Get G2 product ID from POST request
			$g2_cron = filter_input( INPUT_POST, 'g2_cron' ); // Get G2 product ID from POST request
			$reviews_settings = array(
				'g2_apikey' => $g2_apikey, // Enter your G2 API key here
				'g2_productId' => $g2_productId, // Enter your G2 product ID here
				'g2_cron' => $g2_cron, // Enter your Cron Scheduling here
			);

			update_option( 'g2_reviews_settings', $reviews_settings );

            /**
             * g2_reviews_cron function to run on Schedule time
             */
            $old_interval = wp_get_schedule( 'g2_reviews_cron' );  // Old interval for the g2_reviews_cron event
            // Check when event is not schedule or Event Interval is updated so scheduled event
            if(!$old_interval || $old_interval != $g2_cron){
                wp_clear_scheduled_hook( 'g2_reviews_cron' );
                wp_schedule_event( time(), $g2_cron, 'g2_reviews_cron' );
                do_action( 'g2_reviews_cron' );
            }
		}
	}

	/**
	 * Reviews Settings Page.
	 *
	 * @access private
	 * @since 1.0.0
	 */
	private function page_settings() {
		$this->save_reviews_settings();

		// Get the current user's ID
		$user_id = get_current_user_id();

		// Get the G2 Reviews settings from the options table
		$g2_settings = get_option( 'g2_reviews_settings' );

		// Set the initial values for the G2 API key and product ID
		$g2_apikey = '';
		$g2_productId = '';
		$g2_cron = '';

		// Check if G2 Reviews settings exist in the options table
		if($g2_settings){

			// Get the G2 Reviews settings from the options table
			$g2_settings = get_option( 'g2_reviews_settings' );

			// Retrieve the G2 API key from the G2 Reviews settings array
			$g2_apikey = $g2_settings['g2_apikey'];

			// Retrieve the G2 product ID from the G2 Reviews settings array
			$g2_productId = $g2_settings['g2_productId'];

			// Retrieve the G2 Cron Scheduling from the G2 Reviews settings array
            if($g2_settings['g2_cron']){
			    $g2_cron = $g2_settings['g2_cron'];
            }
		}else{
			$g2_cron = 'daily';
		}

		?>


		<div class="wrap">
			<h2>
			<?php
			esc_html_e( 'G2 Reviews Settings', 'g2-reviews' );
			?>

			</h2>

			<p><?php esc_html_e( 'We can get maximum 20 reviews', 'g2-reviews' );	?></p>
			<form enctype="multipart/form-data" action="" method="POST" id="g2-reviews">
			<?php wp_nonce_field( 'g2-reviews_' . $user_id, '_g2_reviews_nonce', true );?>

			<table class="g2-admin-table">
				<caption> Credentials </caption>
				<tbody>
					<tr>
						<th> API Key : </th>
						<td>
							<input type="password" name="g2_apikey" required id="g2-apikey" class="g2-field g2-apikey" value="<?php esc_html_e($g2_apikey); ?>" />
						</td>
					</tr>
					<tr>
						<th> Product Id : </th>
						<td>
							<input type="text" name="g2_productId" required id="g2-productId" class="g2-field g2-productId" value="<?php esc_html_e($g2_productId); ?>" />
						</td>
					</tr>
				</tbody>
			</table>

			<table class="g2-admin-table">
				<caption> Reviews Cron Scheduling </caption>
				<tbody>
					<tr>
						<th> API Key : </th>
						<td>
							<select type="select" name="g2_cron" required id="g2-cron" class="g2-cron g2-apikey">
								<option value="hourly" <?php echo($g2_cron == 'hourly')?'selected':'';?>>Hourly</option>
								<option value="twicedaily" <?php echo($g2_cron == 'twicedaily')?'selected':'';?>>Twice daily</option>
								<option value="daily" <?php echo($g2_cron == 'daily')?'selected':'';?>>Daily</option>
								<option value="weekly" <?php echo($g2_cron == 'weekly')?'selected':'';?>>weekly</option>
							</select>
						</td>
					</tr>
				</tbody>
			</table>

			<p class="submit">
				<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_html_e( 'Save Changes', 'g2-reviews' ); ?>" />
			</p>
			</form>
		</div>

		<?php
	}
}
