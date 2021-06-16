<?php
/**
 * Plugin Name:       Kirkwood 
 * Plugin URI:        https://github.com/hashinteractive/kirkwood 
 * Description:       Custom Plugin for Kirkwood functionalty to extend WordPress.
 * Version:           1.0
 * Author:            Hash Interactive 
 * Author URI:        https://hashinteractive.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       kirkwood 
 */
add_filter('use_block_editor_for_post', '__return_false', 10);