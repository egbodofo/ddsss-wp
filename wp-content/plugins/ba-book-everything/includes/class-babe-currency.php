<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * BABE_Currency Class.
 * Get general settings
 * @class 		BABE_Currency
 * @version		1.0.0
 * @author 		Booking Algorithms
 */

class BABE_Currency {

///////////////////////////////////////
    /**
	 * Get currency symbol.
     * @param string $currency (default: '')
     * @return string
	 */
    public static function get_currency_symbol($currency = '') {
        
       if ( ! $currency ) {
		$currency = self::get_currency();
	   }

	$symbols = apply_filters( 'babe_currency_symbols', array(
		'AED' => '&#x62f;.&#x625;',
		'AFN' => '&#x60b;',
		'ALL' => 'L',
		'AMD' => 'AMD',
		'ANG' => '&fnof;',
		'AOA' => 'Kz',
		'ARS' => '&#36;',
		'AUD' => '&#36;',
		'AWG' => '&fnof;',
		'AZN' => 'AZN',
		'BAM' => 'KM',
		'BBD' => '&#36;',
		'BDT' => '&#2547;&nbsp;',
		'BGN' => '&#1083;&#1074;.',
		'BHD' => '.&#x62f;.&#x628;',
		'BIF' => 'Fr',
		'BMD' => '&#36;',
		'BND' => '&#36;',
		'BOB' => 'Bs.',
		'BRL' => '&#82;&#36;',
		'BSD' => '&#36;',
		'BTC' => '&#3647;',
		'BTN' => 'Nu.',
		'BWP' => 'P',
		'BYR' => 'Br',
		'BZD' => '&#36;',
		'CAD' => '&#36;',
		'CDF' => 'Fr',
		'CHF' => '&#67;&#72;&#70;',
		'CLP' => '&#36;',
		'CNY' => '&yen;',
		'COP' => '&#36;',
		'CRC' => '&#x20a1;',
		'CUC' => '&#36;',
		'CUP' => '&#36;',
		'CVE' => '&#36;',
		'CZK' => '&#75;&#269;',
		'DJF' => 'Fr',
		'DKK' => 'DKK',
		'DOP' => 'RD&#36;',
		'DZD' => '&#x62f;.&#x62c;',
		'EGP' => 'EGP',
		'ERN' => 'Nfk',
		'ETB' => 'Br',
		'EUR' => '&euro;',
		'FJD' => '&#36;',
		'FKP' => '&pound;',
		'GBP' => '&pound;',
		'GEL' => '&#x10da;',
		'GGP' => '&pound;',
		'GHS' => '&#x20b5;',
		'GIP' => '&pound;',
		'GMD' => 'D',
		'GNF' => 'Fr',
		'GTQ' => 'Q',
		'GYD' => '&#36;',
		'HKD' => '&#36;',
		'HNL' => 'L',
		'HRK' => 'Kn',
		'HTG' => 'G',
		'HUF' => '&#70;&#116;',
		'IDR' => 'Rp',
		'ILS' => '&#8362;',
		'IMP' => '&pound;',
		'INR' => '&#8377;',
		'IQD' => '&#x639;.&#x62f;',
		'IRR' => '&#xfdfc;',
		'ISK' => 'kr.',
		'JEP' => '&pound;',
		'JMD' => '&#36;',
		'JOD' => '&#x62f;.&#x627;',
		'JPY' => '&yen;',
		'KES' => 'KSh',
		'KGS' => '&#x441;&#x43e;&#x43c;',
		'KHR' => '&#x17db;',
		'KMF' => 'Fr',
		'KPW' => '&#x20a9;',
		'KRW' => '&#8361;',
		'KWD' => '&#x62f;.&#x643;',
		'KYD' => '&#36;',
		'KZT' => 'KZT',
		'LAK' => '&#8365;',
		'LBP' => '&#x644;.&#x644;',
		'LKR' => '&#xdbb;&#xdd4;',
		'LRD' => '&#36;',
		'LSL' => 'L',
		'LYD' => '&#x644;.&#x62f;',
		'MAD' => '&#x62f;.&#x645;.',
		'MDL' => 'L',
		'MGA' => 'Ar',
		'MKD' => '&#x434;&#x435;&#x43d;',
		'MMK' => 'Ks',
		'MNT' => '&#x20ae;',
		'MOP' => 'P',
		'MRO' => 'UM',
		'MUR' => '&#x20a8;',
		'MVR' => '.&#x783;',
		'MWK' => 'MK',
		'MXN' => '&#36;',
		'MYR' => '&#82;&#77;',
		'MZN' => 'MT',
		'NAD' => '&#36;',
		'NGN' => '&#8358;',
		'NIO' => 'C&#36;',
		'NOK' => '&#107;&#114;',
		'NPR' => '&#8360;',
		'NZD' => '&#36;',
		'OMR' => '&#x631;.&#x639;.',
		'PAB' => 'B/.',
		'PEN' => 'S/.',
		'PGK' => 'K',
		'PHP' => '&#8369;',
		'PKR' => '&#8360;',
		'PLN' => '&#122;&#322;',
		'PRB' => '&#x440;.',
		'PYG' => '&#8370;',
		'QAR' => '&#x631;.&#x642;',
		'RMB' => '&yen;',
		'RON' => 'lei',
		'RSD' => '&#x434;&#x438;&#x43d;.',
		'RUB' => '&#8381;',
		'RWF' => 'Fr',
		'SAR' => '&#x631;.&#x633;',
		'SBD' => '&#36;',
		'SCR' => '&#x20a8;',
		'SDG' => '&#x62c;.&#x633;.',
		'SEK' => '&#107;&#114;',
		'SGD' => '&#36;',
		'SHP' => '&pound;',
		'SLL' => 'Le',
		'SOS' => 'Sh',
		'SRD' => '&#36;',
		'SSP' => '&pound;',
		'STD' => 'Db',
		'SYP' => '&#x644;.&#x633;',
		'SZL' => 'L',
		'THB' => '&#3647;',
		'TJS' => '&#x405;&#x41c;',
		'TMT' => 'm',
		'TND' => '&#x62f;.&#x62a;',
		'TOP' => 'T&#36;',
		'TRY' => '&#8378;',
		'TTD' => '&#36;',
		'TWD' => '&#78;&#84;&#36;',
		'TZS' => 'Sh',
		'UAH' => '&#8372;',
		'UGX' => 'UGX',
		'USD' => '&#36;',
		'UYU' => '&#36;',
		'UZS' => 'UZS',
		'VEF' => 'Bs F',
		'VND' => '&#8363;',
		'VUV' => 'Vt',
		'WST' => 'T',
		'XAF' => 'Fr',
		'XCD' => '&#36;',
		'XOF' => 'Fr',
		'XPF' => 'Fr',
		'YER' => '&#xfdfc;',
		'ZAR' => '&#82;',
		'ZMW' => 'ZK',
	) );

	$currency_symbol = isset( $symbols[ $currency ] ) ? $symbols[ $currency ] : '';

	return apply_filters( 'babe_currency_symbol', $currency_symbol, $currency );
    
    }
    
////////////////////
/**
 * Get Base Currency Code.
 *
 * @return string
 */
public static function get_currency() {
	return apply_filters( 'babe_currency', BABE_Settings::$settings['currency'] );
}

////////////////////
/**
 * Get full list of currency codes.
 *
 * @return array
 */
public static function get_currencies() {
	return array_unique(
		apply_filters( 'babe_currencies',
			array(
				'AED' => __( 'United Arab Emirates dirham', BABE_TEXTDOMAIN ),
				'AFN' => __( 'Afghan afghani', BABE_TEXTDOMAIN ),
				'ALL' => __( 'Albanian lek', BABE_TEXTDOMAIN ),
				'AMD' => __( 'Armenian dram', BABE_TEXTDOMAIN ),
				'ANG' => __( 'Netherlands Antillean guilder', BABE_TEXTDOMAIN ),
				'AOA' => __( 'Angolan kwanza', BABE_TEXTDOMAIN ),
				'ARS' => __( 'Argentine peso', BABE_TEXTDOMAIN ),
				'AUD' => __( 'Australian dollar', BABE_TEXTDOMAIN ),
				'AWG' => __( 'Aruban florin', BABE_TEXTDOMAIN ),
				'AZN' => __( 'Azerbaijani manat', BABE_TEXTDOMAIN ),
				'BAM' => __( 'Bosnia and Herzegovina convertible mark', BABE_TEXTDOMAIN ),
				'BBD' => __( 'Barbadian dollar', BABE_TEXTDOMAIN ),
				'BDT' => __( 'Bangladeshi taka', BABE_TEXTDOMAIN ),
				'BGN' => __( 'Bulgarian lev', BABE_TEXTDOMAIN ),
				'BHD' => __( 'Bahraini dinar', BABE_TEXTDOMAIN ),
				'BIF' => __( 'Burundian franc', BABE_TEXTDOMAIN ),
				'BMD' => __( 'Bermudian dollar', BABE_TEXTDOMAIN ),
				'BND' => __( 'Brunei dollar', BABE_TEXTDOMAIN ),
				'BOB' => __( 'Bolivian boliviano', BABE_TEXTDOMAIN ),
				'BRL' => __( 'Brazilian real', BABE_TEXTDOMAIN ),
				'BSD' => __( 'Bahamian dollar', BABE_TEXTDOMAIN ),
				'BTC' => __( 'Bitcoin', BABE_TEXTDOMAIN ),
				'BTN' => __( 'Bhutanese ngultrum', BABE_TEXTDOMAIN ),
				'BWP' => __( 'Botswana pula', BABE_TEXTDOMAIN ),
				'BYR' => __( 'Belarusian ruble', BABE_TEXTDOMAIN ),
				'BZD' => __( 'Belize dollar', BABE_TEXTDOMAIN ),
				'CAD' => __( 'Canadian dollar', BABE_TEXTDOMAIN ),
				'CDF' => __( 'Congolese franc', BABE_TEXTDOMAIN ),
				'CHF' => __( 'Swiss franc', BABE_TEXTDOMAIN ),
				'CLP' => __( 'Chilean peso', BABE_TEXTDOMAIN ),
				'CNY' => __( 'Chinese yuan', BABE_TEXTDOMAIN ),
				'COP' => __( 'Colombian peso', BABE_TEXTDOMAIN ),
				'CRC' => __( 'Costa Rican col&oacute;n', BABE_TEXTDOMAIN ),
				'CUC' => __( 'Cuban convertible peso', BABE_TEXTDOMAIN ),
				'CUP' => __( 'Cuban peso', BABE_TEXTDOMAIN ),
				'CVE' => __( 'Cape Verdean escudo', BABE_TEXTDOMAIN ),
				'CZK' => __( 'Czech koruna', BABE_TEXTDOMAIN ),
				'DJF' => __( 'Djiboutian franc', BABE_TEXTDOMAIN ),
				'DKK' => __( 'Danish krone', BABE_TEXTDOMAIN ),
				'DOP' => __( 'Dominican peso', BABE_TEXTDOMAIN ),
				'DZD' => __( 'Algerian dinar', BABE_TEXTDOMAIN ),
				'EGP' => __( 'Egyptian pound', BABE_TEXTDOMAIN ),
				'ERN' => __( 'Eritrean nakfa', BABE_TEXTDOMAIN ),
				'ETB' => __( 'Ethiopian birr', BABE_TEXTDOMAIN ),
				'EUR' => __( 'Euro', BABE_TEXTDOMAIN ),
				'FJD' => __( 'Fijian dollar', BABE_TEXTDOMAIN ),
				'FKP' => __( 'Falkland Islands pound', BABE_TEXTDOMAIN ),
				'GBP' => __( 'Pound sterling', BABE_TEXTDOMAIN ),
				'GEL' => __( 'Georgian lari', BABE_TEXTDOMAIN ),
				'GGP' => __( 'Guernsey pound', BABE_TEXTDOMAIN ),
				'GHS' => __( 'Ghana cedi', BABE_TEXTDOMAIN ),
				'GIP' => __( 'Gibraltar pound', BABE_TEXTDOMAIN ),
				'GMD' => __( 'Gambian dalasi', BABE_TEXTDOMAIN ),
				'GNF' => __( 'Guinean franc', BABE_TEXTDOMAIN ),
				'GTQ' => __( 'Guatemalan quetzal', BABE_TEXTDOMAIN ),
				'GYD' => __( 'Guyanese dollar', BABE_TEXTDOMAIN ),
				'HKD' => __( 'Hong Kong dollar', BABE_TEXTDOMAIN ),
				'HNL' => __( 'Honduran lempira', BABE_TEXTDOMAIN ),
				'HRK' => __( 'Croatian kuna', BABE_TEXTDOMAIN ),
				'HTG' => __( 'Haitian gourde', BABE_TEXTDOMAIN ),
				'HUF' => __( 'Hungarian forint', BABE_TEXTDOMAIN ),
				'IDR' => __( 'Indonesian rupiah', BABE_TEXTDOMAIN ),
				'ILS' => __( 'Israeli new shekel', BABE_TEXTDOMAIN ),
				'IMP' => __( 'Manx pound', BABE_TEXTDOMAIN ),
				'INR' => __( 'Indian rupee', BABE_TEXTDOMAIN ),
				'IQD' => __( 'Iraqi dinar', BABE_TEXTDOMAIN ),
				'IRR' => __( 'Iranian rial', BABE_TEXTDOMAIN ),
				'ISK' => __( 'Icelandic kr&oacute;na', BABE_TEXTDOMAIN ),
				'JEP' => __( 'Jersey pound', BABE_TEXTDOMAIN ),
				'JMD' => __( 'Jamaican dollar', BABE_TEXTDOMAIN ),
				'JOD' => __( 'Jordanian dinar', BABE_TEXTDOMAIN ),
				'JPY' => __( 'Japanese yen', BABE_TEXTDOMAIN ),
				'KES' => __( 'Kenyan shilling', BABE_TEXTDOMAIN ),
				'KGS' => __( 'Kyrgyzstani som', BABE_TEXTDOMAIN ),
				'KHR' => __( 'Cambodian riel', BABE_TEXTDOMAIN ),
				'KMF' => __( 'Comorian franc', BABE_TEXTDOMAIN ),
				'KPW' => __( 'North Korean won', BABE_TEXTDOMAIN ),
				'KRW' => __( 'South Korean won', BABE_TEXTDOMAIN ),
				'KWD' => __( 'Kuwaiti dinar', BABE_TEXTDOMAIN ),
				'KYD' => __( 'Cayman Islands dollar', BABE_TEXTDOMAIN ),
				'KZT' => __( 'Kazakhstani tenge', BABE_TEXTDOMAIN ),
				'LAK' => __( 'Lao kip', BABE_TEXTDOMAIN ),
				'LBP' => __( 'Lebanese pound', BABE_TEXTDOMAIN ),
				'LKR' => __( 'Sri Lankan rupee', BABE_TEXTDOMAIN ),
				'LRD' => __( 'Liberian dollar', BABE_TEXTDOMAIN ),
				'LSL' => __( 'Lesotho loti', BABE_TEXTDOMAIN ),
				'LYD' => __( 'Libyan dinar', BABE_TEXTDOMAIN ),
				'MAD' => __( 'Moroccan dirham', BABE_TEXTDOMAIN ),
				'MDL' => __( 'Moldovan leu', BABE_TEXTDOMAIN ),
				'MGA' => __( 'Malagasy ariary', BABE_TEXTDOMAIN ),
				'MKD' => __( 'Macedonian denar', BABE_TEXTDOMAIN ),
				'MMK' => __( 'Burmese kyat', BABE_TEXTDOMAIN ),
				'MNT' => __( 'Mongolian t&ouml;gr&ouml;g', BABE_TEXTDOMAIN ),
				'MOP' => __( 'Macanese pataca', BABE_TEXTDOMAIN ),
				'MRO' => __( 'Mauritanian ouguiya', BABE_TEXTDOMAIN ),
				'MUR' => __( 'Mauritian rupee', BABE_TEXTDOMAIN ),
				'MVR' => __( 'Maldivian rufiyaa', BABE_TEXTDOMAIN ),
				'MWK' => __( 'Malawian kwacha', BABE_TEXTDOMAIN ),
				'MXN' => __( 'Mexican peso', BABE_TEXTDOMAIN ),
				'MYR' => __( 'Malaysian ringgit', BABE_TEXTDOMAIN ),
				'MZN' => __( 'Mozambican metical', BABE_TEXTDOMAIN ),
				'NAD' => __( 'Namibian dollar', BABE_TEXTDOMAIN ),
				'NGN' => __( 'Nigerian naira', BABE_TEXTDOMAIN ),
				'NIO' => __( 'Nicaraguan c&oacute;rdoba', BABE_TEXTDOMAIN ),
				'NOK' => __( 'Norwegian krone', BABE_TEXTDOMAIN ),
				'NPR' => __( 'Nepalese rupee', BABE_TEXTDOMAIN ),
				'NZD' => __( 'New Zealand dollar', BABE_TEXTDOMAIN ),
				'OMR' => __( 'Omani rial', BABE_TEXTDOMAIN ),
				'PAB' => __( 'Panamanian balboa', BABE_TEXTDOMAIN ),
				'PEN' => __( 'Peruvian nuevo sol', BABE_TEXTDOMAIN ),
				'PGK' => __( 'Papua New Guinean kina', BABE_TEXTDOMAIN ),
				'PHP' => __( 'Philippine peso', BABE_TEXTDOMAIN ),
				'PKR' => __( 'Pakistani rupee', BABE_TEXTDOMAIN ),
				'PLN' => __( 'Polish z&#x142;oty', BABE_TEXTDOMAIN ),
				'PRB' => __( 'Transnistrian ruble', BABE_TEXTDOMAIN ),
				'PYG' => __( 'Paraguayan guaran&iacute;', BABE_TEXTDOMAIN ),
				'QAR' => __( 'Qatari riyal', BABE_TEXTDOMAIN ),
				'RON' => __( 'Romanian leu', BABE_TEXTDOMAIN ),
				'RSD' => __( 'Serbian dinar', BABE_TEXTDOMAIN ),
				'RUB' => __( 'Russian ruble', BABE_TEXTDOMAIN ),
				'RWF' => __( 'Rwandan franc', BABE_TEXTDOMAIN ),
				'SAR' => __( 'Saudi riyal', BABE_TEXTDOMAIN ),
				'SBD' => __( 'Solomon Islands dollar', BABE_TEXTDOMAIN ),
				'SCR' => __( 'Seychellois rupee', BABE_TEXTDOMAIN ),
				'SDG' => __( 'Sudanese pound', BABE_TEXTDOMAIN ),
				'SEK' => __( 'Swedish krona', BABE_TEXTDOMAIN ),
				'SGD' => __( 'Singapore dollar', BABE_TEXTDOMAIN ),
				'SHP' => __( 'Saint Helena pound', BABE_TEXTDOMAIN ),
				'SLL' => __( 'Sierra Leonean leone', BABE_TEXTDOMAIN ),
				'SOS' => __( 'Somali shilling', BABE_TEXTDOMAIN ),
				'SRD' => __( 'Surinamese dollar', BABE_TEXTDOMAIN ),
				'SSP' => __( 'South Sudanese pound', BABE_TEXTDOMAIN ),
				'STD' => __( 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe dobra', BABE_TEXTDOMAIN ),
				'SYP' => __( 'Syrian pound', BABE_TEXTDOMAIN ),
				'SZL' => __( 'Swazi lilangeni', BABE_TEXTDOMAIN ),
				'THB' => __( 'Thai baht', BABE_TEXTDOMAIN ),
				'TJS' => __( 'Tajikistani somoni', BABE_TEXTDOMAIN ),
				'TMT' => __( 'Turkmenistan manat', BABE_TEXTDOMAIN ),
				'TND' => __( 'Tunisian dinar', BABE_TEXTDOMAIN ),
				'TOP' => __( 'Tongan pa&#x2bb;anga', BABE_TEXTDOMAIN ),
				'TRY' => __( 'Turkish lira', BABE_TEXTDOMAIN ),
				'TTD' => __( 'Trinidad and Tobago dollar', BABE_TEXTDOMAIN ),
				'TWD' => __( 'New Taiwan dollar', BABE_TEXTDOMAIN ),
				'TZS' => __( 'Tanzanian shilling', BABE_TEXTDOMAIN ),
				'UAH' => __( 'Ukrainian hryvnia', BABE_TEXTDOMAIN ),
				'UGX' => __( 'Ugandan shilling', BABE_TEXTDOMAIN ),
				'USD' => __( 'United States dollar', BABE_TEXTDOMAIN ),
				'UYU' => __( 'Uruguayan peso', BABE_TEXTDOMAIN ),
				'UZS' => __( 'Uzbekistani som', BABE_TEXTDOMAIN ),
				'VEF' => __( 'Venezuelan bol&iacute;var', BABE_TEXTDOMAIN ),
				'VND' => __( 'Vietnamese &#x111;&#x1ed3;ng', BABE_TEXTDOMAIN ),
				'VUV' => __( 'Vanuatu vatu', BABE_TEXTDOMAIN ),
				'WST' => __( 'Samoan t&#x101;l&#x101;', BABE_TEXTDOMAIN ),
				'XAF' => __( 'Central African CFA franc', BABE_TEXTDOMAIN ),
				'XCD' => __( 'East Caribbean dollar', BABE_TEXTDOMAIN ),
				'XOF' => __( 'West African CFA franc', BABE_TEXTDOMAIN ),
				'XPF' => __( 'CFP franc', BABE_TEXTDOMAIN ),
				'YER' => __( 'Yemeni rial', BABE_TEXTDOMAIN ),
				'ZAR' => __( 'South African rand', BABE_TEXTDOMAIN ),
				'ZMW' => __( 'Zambian kwacha', BABE_TEXTDOMAIN ),
			)
		)
	);
}
////////////////////
/**
 * Get the price format depending on the currency place.
 *
 * @return string
 */
public static function get_price_format() {
	$currency_place = BABE_Settings::$settings['currency_place'];
	$format = '%1$s%2$s';

	switch ( $currency_place ) {
		case 'left' :
			$format = '%1$s%2$s';
		break;
		case 'right' :
			$format = '%2$s%1$s';
		break;
		case 'left_space' :
			$format = '%1$s&nbsp;%2$s';
		break;
		case 'right_space' :
			$format = '%2$s&nbsp;%1$s';
		break;
	}

	return apply_filters( 'babe_price_format', $format, $currency_place );
}

////////////////////
/**
 * Get the currency place.
 *
 * @return string
 */
public static function get_currency_place() {
    
	return BABE_Settings::$settings['currency_place'];
    
}
    
////////////////////////////////
/**
 * Format the price with a currency symbol.
 *
 * @param float $price
 * @param array $args (default: array())
 * @return string
 */
public static function get_currency_price( $price, $args = array() ) {
	$args = apply_filters( 'babe_price_args', wp_parse_args( $args, array(
		'currency'           => '',
		'decimal_separator'  => stripslashes( BABE_Settings::$settings['price_decimal_separator'] ),
		'thousand_separator' => stripslashes( BABE_Settings::$settings['price_thousand_separator'] ),
		'decimals'           => absint(BABE_Settings::$settings['price_decimals']),
		'price_format'       => self::get_price_format()
	) ) );
    
    foreach ($args as $key => $val){
        $$key = $val;
    }
    
    $price = floatval($price);

	$negative = $price < 0;
	$price = apply_filters( 'babe_raw_price', ($negative ? $price * -1 : $price ) );
	$price = apply_filters( 'babe_formatted_price', number_format( $price, $decimals, $decimal_separator, $thousand_separator ), $price, $decimals, $decimal_separator, $thousand_separator );
    
    if ( apply_filters( 'babe_price_trim_zeros', true ) && $decimals > 0 ) {
		$price = self::price_trim_zeros( $price );
	}

	$formatted_price = ( $negative ? '-' : '' ) . sprintf( $price_format, '<span class="currency_symbol">' . self::get_currency_symbol() . '</span>', $price );
	$return = '<span class="currency_amount" data-amount="'.$price.'">' . $formatted_price . '</span>';

	return apply_filters( 'babe_price', $return, $price, $args );
}

/////////////////////////////
/**
 * Trim trailing zeros off prices.
 *
 * @param mixed $price
 * @return string
 */
public static function price_trim_zeros( $price ) {
	return preg_replace( '/' . preg_quote( stripslashes( BABE_Settings::$settings['price_decimal_separator'] ), '/' ) . '0++$/', '', $price );
}         
        
////////////////////    
}
