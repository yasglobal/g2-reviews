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
			$g2_api_key       = filter_input( INPUT_POST, 'g2_apikey' );
			$g2_product_id    = filter_input( INPUT_POST, 'g2_productId' );
			$g2_cron          = filter_input( INPUT_POST, 'g2_cron' );
			$reviews_settings = array(
				'g2_apikey'    => $g2_api_key,
				'g2_productId' => $g2_product_id,
				'g2_cron'      => $g2_cron,
			);

			update_option( 'g2_reviews_settings', $reviews_settings );

			/*
			 * g2_reviews_cron function to run on Schedule time.
			 */
			$old_interval = wp_get_schedule( 'g2_reviews_cron' );
			// Check when event is not schedule or Event Interval is updated so scheduled event.
			if ( ! isset( $old_interval ) || $old_interval !== $g2_cron ) {
				wp_clear_scheduled_hook( 'g2_reviews_cron' );
				wp_schedule_event( time(), $g2_cron, 'g2_reviews_cron' );
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

		$g2_settings = get_option( 'g2_reviews_settings' );
		$user_id     = get_current_user_id();

		// Set the initial values for the G2 API key and product ID.
		$g2_api_key    = '';
		$g2_product_id = '';
		$g2_cron       = 'daily';

		// Check if G2 Reviews settings exist in the options table.
		if ( ! empty( $g2_settings ) ) {
			$g2_api_key    = $g2_settings['g2_apikey'];
			$g2_product_id = $g2_settings['g2_productId'];

			// Retrieve the G2 Cron Scheduling from the G2 Reviews settings array.
			if ( isset( $g2_settings['g2_cron'] ) ) {
				$g2_cron = $g2_settings['g2_cron'];
			}
		}

		// Get the G2 Reviews API Message.
		$g2_message = get_option( 'g2_reviews_message' );
		// Delete the plugin message options.
		delete_option( 'g2_reviews_message' );
		?>

		<div class="wrap">
			<?php
			// Print message when API key fetch or not.
			print esc_html( $g2_message );
			?>

			<h2>
				<strong>
					<?php
					esc_html_e( 'G2 Reviews Settings', 'g2-reviews' );
					?>
				</strong>
			</h2>

			<p><?php esc_html_e( 'We will get maximum 20 reviews.', 'g2-reviews' ); ?></p>
			<form enctype="multipart/form-data" action="" method="POST" id="g2-reviews">
				<?php wp_nonce_field( 'g2-reviews_' . $user_id, '_g2_reviews_nonce', true ); ?>

				<table class="g2-admin-table">
					<caption>
						<?php esc_html_e( 'Credentials', 'g2-reviews' ); ?>
					</caption>
					<tbody>
						<tr>
							<th>
								<?php esc_html_e( 'API Key :', 'g2-reviews' ); ?>
							</th>
							<td>
								<input type="password" autocomplete="false" name="g2_apikey" required id="g2-apikey" class="g2-field g2-apikey" value="<?php echo esc_attr( $g2_api_key ); ?>" />
							</td>
						</tr>
						<tr>
							<th>
								<?php esc_html_e( 'Product Id :', 'g2-reviews' ); ?>
							</th>
							<td>
								<input type="text" autocomplete="false" name="g2_productId" required id="g2-productId" class="g2-field g2-productId" value="<?php echo esc_attr( $g2_product_id ); ?>" />
							</td>
						</tr>
					</tbody>
				</table>

				<table class="g2-admin-table">
					<caption>
						<?php esc_html_e( 'Reviews Cron Scheduling', 'g2-reviews' ); ?>
					</caption>
					<tbody>
						<tr>
							<th>
								<?php esc_html_e( 'Cron Run :', 'g2-reviews' ); ?>
							</th>
							<td>
								<select type="select" name="g2_cron" required id="g2-cron" class="g2-cron g2-apikey">
									<option value="hourly" <?php echo( 'hourly' === $g2_cron ) ? 'selected' : ''; ?>><?php esc_html_e( 'Hourly', 'g2-reviews' ); ?></option>
									<option value="twicedaily" <?php echo( 'twicedaily' === $g2_cron ) ? 'selected' : ''; ?>><?php esc_html_e( 'Twice daily', 'g2-reviews' ); ?></option>
									<option value="daily" <?php echo( 'daily' === $g2_cron ) ? 'selected' : ''; ?>><?php esc_html_e( 'Daily', 'g2-reviews' ); ?></option>
									<option value="weekly" <?php echo( 'weekly' === $g2_cron ) ? 'selected' : ''; ?>><?php esc_html_e( 'weekly', 'g2-reviews' ); ?></option>
								</select>
							</td>
						</tr>
					</tbody>
				</table>

				<table class="g2-admin-table output">
					<caption>
						<?php esc_html_e( 'Output', 'g2-reviews' ); ?>
					</caption>
					<tbody>
						<tr>
							<th>
								<?php esc_html_e( 'Widget :', 'g2-reviews' ); ?>
							</th>
							<td>
								<?php esc_html_e( 'If you wants to show reviews in widget set "G2 review" widget in you sidebar', 'g2-reviews' ); ?>
							</td>
						</tr>
						<tr>
							<th>
								<?php esc_html_e( 'Shortcode :', 'g2-reviews' ); ?>
							</th>
							<td>
								<?php esc_html_e( 'Use "[g2reviews]" shortcode. Default 3 reviews with display.', 'g2-reviews' ); ?>
							</td>
						</tr>
						<tr>
							<th>
								<?php esc_html_e( 'Review items :', 'g2-reviews' ); ?>
							</th>
							<td>
								<?php esc_html_e( 'Use [g2reviews review-items="10"] shortcode to display <strong> 10 </strong> reviews.', 'g2-reviews' ); ?>
							</td>
						</tr>
						<tr>
							<th>
								<?php esc_html_e( 'Items in row:', 'g2-reviews' ); ?>
							</th>
							<td>
								<?php esc_html_e( 'Use [g2reviews items-row="4"] shortcode to display 4 reviews in a row.', 'g2-reviews' ); ?>
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

/**
 * Loads a CSS file on the front-end.
 *
 * @return void
 */
function wpb_load_style() {
	wp_enqueue_style( 'G2-admin-style', '/wp-content/plugins/g2-reviews/assets/admin-style.css', array(), '201903289' );
}

add_action( 'admin_enqueue_scripts', 'wpb_load_style' );
