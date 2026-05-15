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
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 20 );
		add_action( 'enqueue_block_assets', array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ), 20 );
	}

    /**
	 * Enqueue scripts and styles.
	 */
	public function enqueue_scripts() {
		wp_register_style(
			'sociatic-style',
			get_stylesheet_uri(),
			array(),
			SOCIATIC_VERSION
		);

		wp_style_add_data( 'sociatic-style', 'path', SOCIATIC_DIR );
		
		wp_enqueue_style( 'sociatic-style' );

				wp_register_style( 'sociatic-presset', trailingslashit( get_template_directory_uri() ) . 'assets/css/sociatic-presset.css', array(), SOCIATIC_VERSION );
		if ( file_exists( trailingslashit( get_template_directory() ) . 'assets/css/sociatic-presset.css' ) && filesize( trailingslashit( get_template_directory() ) . 'assets/css/sociatic-presset.css' ) < 51200 ) {
			wp_style_add_data( 'sociatic-presset', 'path', trailingslashit( get_template_directory() ) . 'assets/css/sociatic-presset.css' );
		}
		wp_enqueue_style( 'sociatic-presset' );
		wp_register_style( 'sociatic-custom-styling', trailingslashit( get_template_directory_uri() ) . 'assets/css/sociatic-custom-styling.css', array(), SOCIATIC_VERSION );
		if ( file_exists( trailingslashit( get_template_directory() ) . 'assets/css/sociatic-custom-styling.css' ) && filesize( trailingslashit( get_template_directory() ) . 'assets/css/sociatic-custom-styling.css' ) < 51200 ) {
			wp_style_add_data( 'sociatic-custom-styling', 'path', trailingslashit( get_template_directory() ) . 'assets/css/sociatic-custom-styling.css' );
		}
		wp_enqueue_style( 'sociatic-custom-styling' );
		wp_register_script( 'sociatic-animation-script', trailingslashit( get_template_directory_uri() ) . 'assets/js/sociatic-animation-script.js', array(), SOCIATIC_VERSION, true );
		wp_enqueue_script( 'sociatic-animation-script' );


        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
    }

	/**
	 * Enqueue admin scripts and styles.
	 */
	public function admin_scripts() {
		
    }
}
