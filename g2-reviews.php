<?php
/**
 * Plugin Name: G2 Reviews
 * Plugin URI: https://www.yasglobal.com/web-design-development/wordpress/g2-reviews/
 * Description: Fetch Reviews from G2.
 * Version: 0.0.1
 * Requires at least: 5.0
 * Requires PHP: 5.6
 * Author: Sami Ahmed Siddiqui
 * Author URI: https://www.linkedin.com/in/sami-ahmed-siddiqui/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * Text Domain: g2-reviews
 * Domain Path: /languages/
 *
 * @package G2Reviews
 */

/**
 *  G2 Reviews - Fetch Reviews from G2.
 *  Copyright 2023 Sami Ahmed Siddiqui <sami.siddiqui@yasglobal.com>
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.

 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.

 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'G2_REVIEWS_FILE' ) ) {
	define( 'G2_REVIEWS_FILE', __FILE__ );
}

// Include the main G2 Reviews class.
require_once plugin_dir_path( G2_REVIEWS_FILE ) . 'includes/class-g2-reviews.php';
