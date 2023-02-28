<?php
/**
 * G2 Reviews Cron.
 *
 * @package G2Reviews
 */
class G2_Reviews_Cron {

    public function __construct() {
      // Register the g2_reviews_cron event
      add_action( 'g2_reviews_cron', array( $this, 'g2_reviews_cron' ) );
    }

    //Fetch Product reviews from the G2 API.
    public function fetch_product_reviews(string $curl_url = '') {
        // Default settings.
        $config     = get_option( 'g2_reviews_settings' );
        $api_token  = $config['g2_apikey'];
        $product_id = $config['g2_productId'];

        if (empty($api_token) || empty($product_id)) {
            return;
        }

        if (empty($curl_url)) {
            $curl_url = 'https://data.g2.com/api/v1/products/' . $product_id . '/survey-responses';
        }

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => $curl_url,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 4,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_HTTPHEADER     => [
            'Authorization: Token token=' .  $api_token,
            'Content-Type: application/vnd.api+json',
            ],
        ]);

        $response    = curl_exec($curl);
        $err         = curl_error($curl);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);
        if ($err || $status_code !== 200) {
            $response = [];
        } else {
            $response = json_decode($response);
        }

        return $response;
    }

    //Fetch G2 product reviews and save in Database.
    public function g2_reviews_cron() {
        
         // Run Function to fect data into G2 API
          /*$init_response = $this->fetch_product_reviews();
          print '<script>alert(1);</script>';
          print '<pre>';
          print_r($init_response);
          print '</pre>';

          exit;*/

          // Read the contents of the JSON file
            $json_string = file_get_contents('https://dev-wp-plugins.pantheonsite.io/wp-content/plugins/g2-reviews/admin/g2-review.json');


            // Decode the JSON string into a PHP object or array
            $init_response = json_decode($json_string);
            print '<script>alert(32);</script>';
          
          if (isset($init_response, $init_response->links, $init_response->links->last)) {
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
          }

          print '<pre>';
          print_r($product_reviews);
          print '</pre>';
    
      
          if (!empty($product_reviews)) {      
            foreach ($product_reviews as $review) {
              $review_entry = [];
              if (isset($review->attributes)) {
                $review_entry['attributes'] = serialize($review->attributes);
                if (!isset($review->attributes->star_rating)
                  || $review->attributes->star_rating < 4
                ) {
                  continue;
                }
      
                $review_entry['star_rating'] = $review->attributes->star_rating;
                if (isset($review->attributes->country_name)) {
                  $review_entry['country_name'] = $review->attributes->country_name;
                }
      
                if (isset($review->attributes->submitted_at)) {
                  $review_entry['created'] = strtotime($review->attributes->submitted_at);
                }
      
                if (isset($review->attributes->title)) {
                  $review_entry['title'] = $review->attributes->title;
                }
      
                if (isset($review->attributes->updated_at)) {
                  $review_entry['updated'] = strtotime($review->attributes->updated_at);
                }
      
                if (!empty($review_entry)) {
                  $database->truncate($new_table_name)->execute();
                  $database->insert($new_table_name)
                    ->fields($review_entry)
                    ->execute();
                }
              }
            }
      
        }
      
    }
}

new G2_Reviews_Cron();
