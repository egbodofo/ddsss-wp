<?php
/**
 * The template for displaying start room loop.
 *
 * This template can be overridden by copying it to yourtheme/wp-hotel-booking/loop/loop-start.php.
 *
 * @package WP-Hotel-Booking/Templates
 * @version 1.6
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

global $hb_settings;
/**
 * @var $hb_settings WPHB_Settings
 */
?>

<div class="hb-rooms hb-catalog-column-<?php echo esc_attr( $hb_settings->get( 'catalog_number_column', 4 ) ) ?>">