<?php
/**
 * The template for displaying loop room title in archive room page.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/loop/title.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();
?>
<h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
