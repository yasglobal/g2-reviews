<?php

/**
 * G2 Reviews Cron.
 *
 * @package G2Reviews
 */
class G2_Reviews_Cron
{

	public function __construct()
	{
		// Register the g2_reviews_cron event
		add_action('g2_reviews_cron', array($this, 'g2_reviews_cron'));
	}

	//Fetch Product reviews from the G2 API.
	public function fetch_product_reviews(string $curl_url = '')
	{
		// Default settings.
		$config = get_option('g2_reviews_settings');
		$api_token = $config['g2_apikey'];
		$product_id = $config['g2_productId'];

		if (empty($api_token) || empty($product_id)) {
			return;
		}

		if (empty($curl_url)) {
			$curl_url = 'https://data.g2.com/api/v1/products/' . $product_id . '/survey-responses';
		}

		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_URL => $curl_url,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 4,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => [
				'Authorization: Token token=' . $api_token,
				'Content-Type: application/vnd.api+json',
			],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);
		$status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		curl_close($curl);
		if ($err || $status_code !== 200) {
			$response = [];
			//set message in option when api not fetch the data;
			update_option( 'g2_reviews_message', '<div class="g2-message error"><strong>Error :</strong> Invalid Credentials</div>' );
			delete_option( 'g2_reviews_settings' );
		} else {
			$response = json_decode($response);
			//set message in option when api successfully fetch the data;
			update_option( 'g2_reviews_message', '<div class="g2-message success"><strong>Success :</strong> We are Successfully fetch data from G2</div>' );
		}

		return $response;
	}

	//Fetch G2 product reviews and save in Database.
	public function g2_reviews_cron()
	{

		// Run Function to fect data into G2 API
		/*$init_response = $this->fetch_product_reviews();
		return;
			
		print '<script>alert(1);</script>';
		print '<pre>';
		print_r($init_response);
		print '</pre>';

		exit;*/

		// Read the contents of the JSON file
		$json_string = file_get_contents('https://dev-wp-plugins.pantheonsite.io/wp-content/plugins/g2-reviews/admin/g2-review.json');


		// Decode the JSON string into a PHP object or array
		$init_response = json_decode($json_string);

		/*if (isset($init_response, $init_response->links, $init_response->links->last)) {
		  $last_page_response = fetch_product_reviews($init_response->links->last);
		  if (isset($last_page_response, $last_page_response->links, $last_page_response->links->prev)) {
			$second_last_page_response = fetch_product_reviews($last_page_response->links->prev);
		  }

		  if (isset($second_last_page_response, $second_last_page_response->links, $second_last_page_response->links->prev)) {
			$third_last_page_response = fetch_product_reviews($second_last_page_response->links->prev);
		  }

		  $product_reviews = array_merge_recursive(
			$last_page_response->data,
			$second_last_page_response->data,
			$third_last_page_response->data
		  );
		}*/

		$product_reviews = $init_response;

		$table_name = G2_REVIEWS_TABLE; // define table name using WP database prefix
		// check if product reviews are not empty
		if (!empty($product_reviews)) {
			$table_row == false; // set $table_row variable to false
			foreach ($product_reviews as $review) {

				$review_entry = []; //define an empty array for review entry
				$review_user = []; //define an empty array for review user
				$review_address = []; //define an empty array for review address
				

				if (isset($review->attributes)) { //check if review attributes are set
					/*if (!isset($review->attributes->star_rating) || $review->attributes->star_rating < 4) {
						continue;
					}*/
					$review_entry['other_attributes'] = serialize($review->attributes);
//					$review_entry['other_attributes'] = '';

					// Add the star rating to the review entry
					$review_entry['star_rating'] = $review->attributes->star_rating;

					// Add the title, if present, to the review entry
					if (isset($review->attributes->title)) {
						$review_entry['title'] = $review->attributes->title;
					}

					// Add the comment answers, if present, to the review entry
					if (isset($review->attributes->comment_answers)) {
						$review_entry['comment_answers'] = serialize($review->attributes->comment_answers);
//						$review_entry['comment_answers'] = '';
					}

					// Add the secondary answers, if present, to the review entry
					if (isset($review->attributes->secondary_answers)) {
						$review_entry['secondary_answers'] = serialize($review->attributes->secondary_answers);
//						$review_entry['secondary_answers'] = '';
					}

					// Add the verified current user status, if present, to the review entry
					if (isset($review->attributes->verified_current_user)) {
						$review_entry['verified_current_user'] = $review->attributes->verified_current_user;
					}

					// Add the user ID, if present, to the user array
					if (isset($review->attributes->user_id)) {
						$review_user['user_id'] = $review->attributes->user_id;
					}

					// Add the user name, if present, to the user array
					if (isset($review->attributes->user_name)) {
						$review_user['user_name'] = $review->attributes->user_name;
					}

					// Add the user image URL, if present, to the user array
					if (isset($review->attributes->user_image_url)) {
						$review_user['user_image_url'] = $review->attributes->user_image_url;
					}

					// Add the country name, if present, to the address array
					if (isset($review->attributes->country_name)) {
						$review_address['country_name'] = $review->attributes->country_name;
					}

					// Add the regions, if present, to the address array
					if (isset($review->attributes->regions)) {
						$review_address['regions'] = $review->attributes->regions;
					}

					// Add the submitted_at timestamp, if present, to the review entry
					if (isset($review->attributes->submitted_at)) {
						$review_entry['submitted_at'] = strtotime($review->attributes->submitted_at);
					}

					// Add the updated_at timestamp, if present, to the review entry
					if (isset($review->attributes->updated_at)) {
						$review_entry['updated_at'] = strtotime($review->attributes->updated_at);
					}

					$review_entry['country_region'] = serialize($review_address); // set country region to review address
					$review_entry['user'] = serialize($review_user); // set user to review user

					global $wpdb;
					if (!empty($review_entry)) { // check if review entry is not empty
						if ($table_row == false) { // Check if there is any row in the table
							$wpdb->query("DELETE FROM $table_name"); // Delete all rows from the table
							$table_row = true;
						}

						// Insert review entry into the table
						$wpdb->insert($table_name, $review_entry);

					}
				}
			}

		}

	}
}

new G2_Reviews_Cron();
