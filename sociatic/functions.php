<?php
/**
 * Theme Functions
 *
 * @author Jegstudio
 * @package sociatic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

defined( 'SOCIATIC_VERSION' ) || define( 'SOCIATIC_VERSION', '1.0.6' );
defined( 'SOCIATIC_DIR' ) || define( 'SOCIATIC_DIR', trailingslashit( get_template_directory() ) );
defined( 'SOCIATIC_URI' ) || define( 'SOCIATIC_URI', trailingslashit( get_template_directory_uri() ) );

require get_parent_theme_file_path( 'inc/autoload.php' );

Sociatic\Init::instance();
