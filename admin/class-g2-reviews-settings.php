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
			$g2_apikey = filter_input( INPUT_POST, 'g2_apikey' );
			$g2_productId = filter_input( INPUT_POST, 'g2_productId' );
			$reviews_settings = array(
				'g2_apikey' => $g2_apikey, // Enter your G2 API key here
				'g2_productId' => $g2_productId, // Enter your G2 product ID here
			 );

			update_option( 'g2_reviews_settings', $reviews_settings );
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

		$user_id     = get_current_user_id();
		$g2_settings = get_option( 'g2_reviews_settings' );
		$g2_apikey = '';
		$g2_productId = '';

		if($g2_settings){
			$g2_settings = get_option( 'g2_reviews_settings' );
			$g2_apikey = $g2_settings['g2_apikey'];
			$g2_productId =$g2_settings['g2_productId'];
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
			<p class="apikey">
			<label for="g2-apikey">API Key:</label><br>				
				<input type="password" name="g2_apikey" required id="g2-apikey" class="g2-field g2-apikey" value="<?php esc_html_e($g2_apikey); ?>" />
			</p>
			
			<p class="product-id">
			    <label for="g2-productId">Product Id:</label><br>				
				<input type="password" name="g2_productId" required id="g2-productId" class="g2-field g2-productId" value="<?php esc_html_e($g2_productId); ?>" />
			</p>


			<p class="submit">
				<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_html_e( 'Save Changes', 'g2-reviews' ); ?>" />
			</p>
			</form>
		</div>

		<?php
	}
}