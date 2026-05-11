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

/**
 * Init Class
 *
 * @package sociatic
 */
class Asset_Enqueue {
	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Enqueue scripts and styles.
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'sociatic-style', get_stylesheet_uri(), array(), SOCIATIC_VERSION );

		wp_enqueue_style( 'sociatic-preset-styling', SOCIATIC_URI . '/assets/css/sociatic-preset-styling.css', array(), SOCIATIC_VERSION );
		wp_enqueue_style( 'sociatic-custom-styling', SOCIATIC_URI . '/assets/css/sociatic-custom-styling.css', array(), SOCIATIC_VERSION );
		wp_enqueue_script( 'sociatic-animation-script', SOCIATIC_URI . '/assets/js/sociatic-animation-script.js', array(), SOCIATIC_VERSION, true );
		wp_enqueue_style( 'sociatic-animation-styling', SOCIATIC_URI . '/assets/css/sociatic-animation-styling.css', array(), SOCIATIC_VERSION );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}
