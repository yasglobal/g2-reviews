<?php
/**
 * G2 Reviews Product CRON.
 *
 * @package G2Reviews
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * G2 Reviews Product Cron class.
 */
class G2_Reviews_Cron {
	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_action( 'g2_reviews_cron', array( $this, 'g2_reviews_cron' ) );
	}

	/**
	 * Fetch Product reviews from the G2 API.
	 *
	 * @param string $curl_url CURL URL.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function fetch_product_reviews( $curl_url = '' ) {
		// Get API Key and Product Key.
		$reviews_settings = get_option( 'g2_reviews_settings' );
		if ( isset( $reviews_settings['g2_apikey'] ) || isset( $reviews_settings['g2_apikey'] ) ) {
			$api_token  = $config['g2_apikey'];
			$product_id = $config['g2_productId'];
		}

		if ( empty( $api_token ) || empty( $product_id ) ) {
			return;
		}

		if ( empty( $curl_url ) ) {
			$curl_url = 'https://data.g2.com/api/v1/products/' . $product_id . '/survey-responses';
		}

		$remote_args = array(
			'method'      => 'GET',
			'timeout'     => 30,
			'redirection' => 4,
			'headers'     => array(
				'Authorization: Token token=' . $api_token,
				'Content-Type: application/vnd.api+json',
			),
		);

		$response      = wp_remote_get( $curl_url, $remote_args );
		$response_body = array();
		if ( ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response ) ) {
			$response_body = json_decode( $response['body'] );
			// Set message in option when API successfully fetch the data.
			update_option( 'g2_reviews_message', '<div class="g2-message success"><strong>Success :</strong> We are Successfully fetch data from G2</div>', false );
		} else {
			// Set message in option when API not able to fetch the data.
			update_option( 'g2_reviews_message', '<div class="g2-message error"><strong>Error :</strong> Invalid Credentials</div>', false );
		}

		return $response_body;
	}

	/**
	 * Fetch G2 product reviews and save in Database.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function g2_reviews_cron() {
		// Run Function to fetch data into G2 API.
		$init_response   = $this->fetch_product_reviews();
		$product_reviews = array();

		// Decode the JSON string into a PHP object or array.
		$init_response = json_decode( $json_string );
		if ( isset( $init_response, $init_response->links, $init_response->links->last ) ) {
			$last_page_response = $this->fetch_product_reviews( $init_response->links->last );
			if ( isset( $last_page_response, $last_page_response->links, $last_page_response->links->prev ) ) {
				$second_last_page_response = $this->fetch_product_reviews( $last_page_response->links->prev );
			}

			if ( isset( $second_last_page_response, $second_last_page_response->links, $second_last_page_response->links->prev ) ) {
				$third_last_page_response = $this->fetch_product_reviews( $second_last_page_response->links->prev );
			}

			$product_reviews = array_merge_recursive(
				$last_page_response->data,
				$second_last_page_response->data,
				$third_last_page_response->data
			);
		}

		// Check if product reviews are not empty.
		if ( ! empty( $product_reviews ) ) {
			$table_row = false;
			foreach ( $product_reviews as $review ) {
				$review_address = array();
				$review_entry   = array();
				$review_user    = array();

				// Check if review attributes are set.
				if ( isset( $review->attributes ) ) {
					$review_entry['other_attributes'] = maybe_serialize( $review->attributes );

					// Add the star rating to the review entry.
					$review_entry['star_rating'] = $review->attributes->star_rating;

					// Add the title, if present, to the review entry.
					if ( isset( $review->attributes->title ) ) {
						$review_entry['title'] = $review->attributes->title;
					}

					// Add the comment answers, if present, to the review entry.
					if ( isset( $review->attributes->comment_answers ) ) {
						$review_entry['comment_answers'] = maybe_serialize( $review->attributes->comment_answers );
					}

					// Add the secondary answers, if present, to the review entry.
					if ( isset( $review->attributes->secondary_answers ) ) {
						$review_entry['secondary_answers'] = maybe_serialize( $review->attributes->secondary_answers );
					}

					// Add the verified current user status, if present, to the review entry.
					if ( isset( $review->attributes->verified_current_user ) ) {
						$review_entry['verified_current_user'] = $review->attributes->verified_current_user;
					}

					// Add the user ID, if present, to the user array.
					if ( isset( $review->attributes->user_id ) ) {
						$review_user['user_id'] = $review->attributes->user_id;
					}

					// Add the user name, if present, to the user array.
					if ( isset( $review->attributes->user_name ) ) {
						$review_user['user_name'] = $review->attributes->user_name;
					}

					// Add the user image URL, if present, to the user array.
					if ( isset( $review->attributes->user_image_url ) ) {
						$review_user['user_image_url'] = $review->attributes->user_image_url;
					}

					// Add the country name, if present, to the address array.
					if ( isset( $review->attributes->country_name ) ) {
						$review_address['country_name'] = $review->attributes->country_name;
					}

					// Add the regions, if present, to the address array.
					if ( isset( $review->attributes->regions ) ) {
						$review_address['regions'] = $review->attributes->regions;
					}

					// Add the submitted_at timestamp, if present, to the review entry.
					if ( isset( $review->attributes->submitted_at ) ) {
						$review_entry['submitted_at'] = strtotime( $review->attributes->submitted_at );
					}

					// Add the updated_at timestamp, if present, to the review entry.
					if ( isset( $review->attributes->updated_at ) ) {
						$review_entry['updated_at'] = strtotime( $review->attributes->updated_at );
					}

					// Set country region to review address.
					$review_entry['country_region'] = maybe_serialize( $review_address );
					// Set user to review user.
					$review_entry['user'] = maybe_serialize( $review_user );

					// Check if review entry is not empty.
					if ( ! empty( $review_entry ) ) {
						global $wpdb;

						// Truncate table if first row is set to insert.
						if ( ! $table_row ) {
							$wpdb->query( $wpdb->prepare( 'TRUNCATE TABLE %s;', G2_REVIEWS_TABLE ) );
							$table_row = true;
						}

						// Insert review entry into the table.
						$wpdb->insert( G2_REVIEWS_TABLE, $review_entry );
					}
				}
			}
		}
	}
}

new G2_Reviews_Cron();
