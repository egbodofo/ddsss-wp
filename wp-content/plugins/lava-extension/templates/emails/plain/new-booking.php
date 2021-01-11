<?php
/**
 * New booking email
 *
 * $name            Full name
 * $email           Email
 * $phone           Phone
 * $check_in_date   Check in date
 * $check_out_date  Check out date
 * $guests          Guests
 * $room_type       Room Type
 * $message         Message
 * 
 * This template can be overridden by copying it to yourtheme/lava/emails/new-booking.php.
 *
 * @package 	Lava Extension/Templates/Emails/Plain
 * @version     1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

echo sprintf( __( 'New booking request has been submitted on %s.', 'lava-extension' ), date( 'F j, Y, g:i a' ) ) . "\n\n";

echo sprintf( __( 'Full Name: %s', 'lava-extension' ), $name ) . "\n\n";

echo sprintf( __( 'Email: %s', 'lava-extension' ), $email ) . "\n\n";

echo sprintf( __( 'Phone: %s', 'lava-extension' ), $phone ) . "\n\n";

echo sprintf( __( 'Check In Date: %s', 'lava-extension' ), $check_in_date ) . "\n\n";

echo sprintf( __( 'Check Out Date: %s', 'lava-extension' ), $check_out_date ) . "\n\n";

echo sprintf( __( 'Guests: %s', 'lava-extension' ), $guests ) . "\n\n";

echo sprintf( __( 'Room Type: %s', 'lava-extension' ), $room_type ) . "\n\n";

echo sprintf( __( 'Message: %s', 'lava-extension' ), $message ) . "\n\n";

echo "\n=====================================================================\n\n";
