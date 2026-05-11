<?php
/**
 * Block Pattern Class
 *
 * @author Jegstudio
 * @package sociatic
 */

namespace Sociatic;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use WP_Block_Pattern_Categories_Registry;

/**
 * Init Class
 *
 * @package sociatic
 */
class Block_Patterns {

	/**
	 * Instance variable
	 *
	 * @var $instance
	 */
	private static $instance;

	/**
	 * Class instance.
	 *
	 * @return BlockPatterns
	 */
	public static function instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->register_block_patterns();
	}

	/**
	 * Register Block Patterns
	 */
	private function register_block_patterns() {
		$block_pattern_categories = array(
			'sociatic-core' => array( 'label' => __( 'Sociatic Basic Patterns', 'sociatic' ) ),
		);

		if ( defined( 'GUTENVERSE' ) ) {
			$block_pattern_categories['sociatic-gutenverse'] = array( 'label' => __( 'Sociatic Gutenverse Patterns', 'sociatic' ) );
		}

		$block_pattern_categories = apply_filters( 'sociatic_block_pattern_categories', $block_pattern_categories );

		foreach ( $block_pattern_categories as $name => $properties ) {
			if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
				register_block_pattern_category( $name, $properties );
			}
		}

		$block_patterns = array(
			'sociatic-core-home-hero',
			'sociatic-core-icon',
			'sociatic-core-logo',
			'sociatic-core-about',
			'sociatic-core-service',
			'sociatic-core-strategy',
			'sociatic-core-pricing',
			'sociatic-core-testimonial',
			'sociatic-core-page',
			'sociatic-core-single ',
			'sociatic-core-single-content',
			'sociatic-core-archive',
			'sociatic-core-search',
			'sociatic-core-404',
			'sociatic-core-footer',
			'sociatic-core-index',
		);

		if ( defined( 'GUTENVERSE' ) ) {
			$block_patterns[] = 'sociatic-gutenverse-popup';
			$block_patterns[] = 'sociatic-gutenverse-home-hero';
			$block_patterns[] = 'sociatic-gutenverse-brand-logo';
			$block_patterns[] = 'sociatic-gutenverse-ceo';
			$block_patterns[] = 'sociatic-gutenverse-service';
			$block_patterns[] = 'sociatic-gutenverse-strategy';
			$block_patterns[] = 'sociatic-gutenverse-pricing';
			$block_patterns[] = 'sociatic-gutenverse-testimonial';
			$block_patterns[] = 'sociatic-gutenverse-about-hero';
			$block_patterns[] = 'sociatic-gutenverse-about';
			$block_patterns[] = 'sociatic-gutenverse-team';
			$block_patterns[] = 'sociatic-gutenverse-companies';
			$block_patterns[] = 'sociatic-gutenverse-strategy';
			$block_patterns[] = 'sociatic-gutenverse-service-hero';
			$block_patterns[] = 'sociatic-gutenverse-business';
			$block_patterns[] = 'sociatic-gutenverse-service';
			$block_patterns[] = 'sociatic-gutenverse-step-to-grow';
			$block_patterns[] = 'sociatic-gutenverse-blog-hero';
			$block_patterns[] = 'sociatic-gutenverse-blog-content';
			$block_patterns[] = 'sociatic-gutenverse-contact-hero';
			$block_patterns[] = 'sociatic-gutenverse-index-hero';
			$block_patterns[] = 'sociatic-gutenverse-page-hero';
			$block_patterns[] = 'sociatic-gutenverse-single-hero';
			$block_patterns[] = 'sociatic-gutenverse-single-content';
			$block_patterns[] = 'sociatic-gutenverse-archive-hero';
			$block_patterns[] = 'Sociatic-gutenverse-search-hero';
			$block_patterns[] = 'sociatic-gutenverse-404';
			$block_patterns[] = 'sociatic-gutenverse-header';
			$block_patterns[] = 'sociatic-gutenverse-footer';
		}

		$block_patterns = apply_filters( 'sociatic_block_patterns', $block_patterns );

		if ( function_exists( 'register_block_pattern' ) ) {
			foreach ( $block_patterns as $block_pattern ) {
				$pattern_file = get_theme_file_path( '/inc/patterns/' . $block_pattern . '.php' );

				register_block_pattern(
					'sociatic/' . $block_pattern,
					require $pattern_file
				);
			}
		}
	}
}
