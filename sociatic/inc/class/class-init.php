<?php
/**
 * Init Configuration
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
class Init {

	/**
	 * Instance variable
	 *
	 * @var $instance
	 */
	private static $instance;

	/**
	 * Class instance.
	 *
	 * @return Init
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
	private function __construct() {
		$this->load_hooks();
		$this->init_instance();
	}

	/**
	 * Load initial hooks.
	 */
	private function load_hooks() {
		add_action( 'init', array( $this, 'register_block_patterns' ), 9 );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'backend_scripts' ) );

		add_action( 'wp_ajax_sociatic_set_admin_notice_viewed', array( $this, 'notice_closed' ) );
		add_action( 'admin_notices', array( $this, 'notice_install_plugin' ) );

		add_filter( 'gutenverse_template_path', array( $this, 'template_path' ), null, 3 );
		add_filter( 'gutenverse_themes_template', array( $this, 'add_template' ), 10, 2 );
		add_filter( 'gutenverse_block_config', array( $this, 'default_font' ), 10 );
		add_filter( 'gutenverse_font_header', array( $this, 'default_header_font' ) );
		add_filter( 'gutenverse_global_css', array( $this, 'global_header_style' ) );

		add_filter( 'gutenverse_stylesheet_directory', array( $this, 'change_stylesheet_directory' ) );
		add_filter( 'gutenverse_themes_override_mechanism', '__return_true' );
	}

	/**
	 * Change Stylesheet Directory.
	 *
	 * @return string
	 */
	public function change_stylesheet_directory() {
		return SOCIATIC_DIR . 'gutenverse-files';
	}

	/**
	 * Initialize Instance.
	 */
	public function init_instance() {
		new Asset_Enqueue();
	}

	/**
	 * Notice Closed
	 */
	public function notice_closed() {
		if ( isset( $_POST['nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'sociatic_admin_notice' ) ) {
			update_user_meta( get_current_user_id(), 'gutenverse_install_notice', 'true' );
		}
		die;
	}

	/**
	 * Show notification to install Gutenverse Plugin.
	 */
	public function notice_install_plugin() {
		// Skip if gutenverse block activated.
		if ( defined( 'GUTENVERSE' ) ) {
			return;
		}

		// Skip if gutenverse pro activated.
		if ( defined( 'GUTENVERSE_PRO' ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( isset( $screen->parent_file ) && 'themes.php' === $screen->parent_file && 'appearance_page_sociatic-dashboard' === $screen->id ) {
			return;
		}

		if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
			return;
		}

		if ( 'true' === get_user_meta( get_current_user_id(), 'gutenverse_install_notice', true ) ) {
			return;
		}

		$all_plugin = get_plugins();
		$plugins    = $this->theme_config()['plugins'];
		$actions    = array();

		foreach ( $plugins as $plugin ) {
			$slug   = $plugin['slug'];
			$path   = "$slug/$slug.php";
			$active = is_plugin_active( $path );

			if ( isset( $all_plugin[ $path ] ) ) {
				if ( $active ) {
					$actions[ $slug ] = 'active';
				} else {
					$actions[ $slug ] = 'inactive';
				}
			} else {
				$actions[ $slug ] = '';
			}
		}

		$button_text = __( 'Install Required Plugins', 'sociatic' );
		$button_link = wp_nonce_url( self_admin_url( 'themes.php?page=sociatic-dashboard' ), 'install-plugin_gutenverse' );
		?>
		<style>
			.install-gutenverse-plugin-notice {
				border: 1px solid #E6E6EF;
				position: relative;
				overflow: hidden;
				padding: 0 !important;
				margin-bottom: 30px !important;
				background: url( <?php echo esc_url( SOCIATIC_URI . '/assets/img/background-banner.png' ); ?> );
				background-size: cover;
				background-position: center;
			}

			.install-gutenverse-plugin-notice .gutenverse-notice-content {
				display: flex;
				align-items: center;
			}

			.gutenverse-notice-text, .gutenverse-notice-image {
				width: 50%;
			}

			.gutenverse-notice-text {
				padding: 40px 0 40px 40px;
			}

			.install-gutenverse-plugin-notice img {
				max-width: 100%;
				display: flex;
			}

			.install-gutenverse-plugin-notice:after {
				content: "";
				position: absolute;
				left: 0;
				top: 0;
				height: 100%;
				width: 5px;
				display: block;
				background: linear-gradient(to bottom, #68E4F4, #4569FF, #F045FF);
			}

			.install-gutenverse-plugin-notice .notice-dismiss {
				top: 20px;
				right: 20px;
				padding: 0;
				background: white;
				border-radius: 6px;
			}

			.install-gutenverse-plugin-notice .notice-dismiss:before {
				content: "\f335";
				font-size: 17px;
				width: 25px;
				height: 25px;
				line-height: 25px;
				border: 1px solid #E6E6EF;
				border-radius: 3px;
			}

			.install-gutenverse-plugin-notice h3 {
				margin-top: 5px;
				margin-bottom: 15px;
				font-weight: 600;
				font-size: 25px;
				line-height: 1.4em;
			}

			.install-gutenverse-plugin-notice h3 span {
				font-weight: 700;
				background-clip: text !important;
				-webkit-text-fill-color: transparent;
				background: linear-gradient(80deg, rgba(208, 77, 255, 1) 0%,rgba(69, 105, 255, 1) 48.8%,rgba(104, 228, 244, 1) 100%);
			}

			.install-gutenverse-plugin-notice p {
				font-size: 13px;
				font-weight: 300;
				margin: 5px 100px 20px 0 !important;
			}

			.install-gutenverse-plugin-notice .gutenverse-bottom {
				display: flex;
				align-items: center;
				margin-top: 30px;
			}

			.install-gutenverse-plugin-notice a {
				text-decoration: none;
				margin-right: 20px;
			}

			.install-gutenverse-plugin-notice a.gutenverse-button {
				font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
				text-decoration: none;
				cursor: pointer;
				font-size: 12px;
				line-height: 18px;
				border-radius: 5px;
				background: #3B57F7;
				color: #fff;
				padding: 8px 30px;
				font-weight: 500;
				background: linear-gradient(to left, #68E4F4, #4569FF, #F045FF);
			}

			#gutenverse-install-plugin.loader:after {
				display: block;
				content: '';
				border: 5px solid white;
				border-radius: 50%;
				border-top: 5px solid rgba(255, 255, 255, 0);
				width: 10px;
				height: 10px;
				-webkit-animation: spin 2s linear infinite;
				animation: spin 2s linear infinite;
			}

			@-webkit-keyframes spin {
				0% {
					-webkit-transform: rotate(0deg);
				}
				100% {
					-webkit-transform: rotate(360deg);
				}
			}

			@keyframes spin {
				0% {
					transform: rotate(0deg);
				}
				100% {
					transform: rotate(360deg);
				}
			}

			@media screen and (max-width: 1024px) {
				.gutenverse-notice-text {
					width: 100%;
				}

				.gutenverse-notice-image {
					display: none;
				}
			}
		</style>
		<script>
		var promises = [];
		var actions = <?php echo wp_json_encode( $actions ); ?>;

		function sequenceInstall (plugins, index = 0) {
			if (plugins[index]) {
				var plugin = plugins[index];

				switch (actions[plugin?.slug]) {
					case 'active':
						break;
					case 'inactive':
						var path = plugin?.slug + '/' + plugin?.slug;
						promises.push(
							new Promise((resolve) => {
								fetch(wpApiSettings.root + 'wp/v2/plugins/' + path, {									
									method: 'POST',
									headers: {
										"X-WP-Nonce": wpApiSettings.nonce,
										'Content-Type': 'application/json',
									},
									body: JSON.stringify(
										{
											status: 'active'
										}
									)
								}).then(() => {
									sequenceInstall(plugins, index + 1);
									resolve(plugin);
								}).catch((error) => {
									alert('Plugin Install Failed')	
								});
							})
						);
						break;
					default:
						promises.push(
							new Promise((resolve) => {
								fetch(wpApiSettings.root + 'wp/v2/plugins', {									
									method: 'POST',
									headers: {
										"X-WP-Nonce": wpApiSettings.nonce,
										'Content-Type': 'application/json',
									},
									body: JSON.stringify(
										{
											slug: plugin?.slug,
											status: 'active'
										}
									)
								}).then(() => {
									sequenceInstall(plugins, index + 1);
									resolve(plugin);
								}).catch((error) => {
									alert('Plugin Install Failed')	
								});
							})
						);
						break;
				}
			}

			return;
		};

		jQuery( function( $ ) {
			$( 'div.notice.install-gutenverse-plugin-notice' ).on( 'click', 'button.notice-dismiss', function( event ) {
				event.preventDefault();
				$.post( ajaxurl, {
					action: 'sociatic_set_admin_notice_viewed',
					nonce: '<?php echo esc_html( wp_create_nonce( 'sociatic_admin_notice' ) ); ?>',
				} );
			} );

			$("#gutenverse-install-plugin").on('click', function(e) {
				var hasFinishClass = $(this).hasClass('finished');
				var hasLoaderClass = $(this).hasClass('loader');

				if(!hasFinishClass) {
					e.preventDefault();
				}

				if(!hasLoaderClass && !hasFinishClass) {
					promises = [];
					var plugins = <?php echo wp_json_encode( $plugins ); ?>;
					$(this).addClass('loader').text('');

					sequenceInstall(plugins);
					Promise.all(promises).then(() => {						
						$(this).removeClass('loader').addClass('finished').text('Visit Theme Dashboard');
					});
				}
			});
		} );
		</script>
		<div class="notice is-dismissible install-gutenverse-plugin-notice">
			<div class="gutenverse-notice-inner">
				<div class="gutenverse-notice-content">
					<div class="gutenverse-notice-text">
						<h3><?php esc_html_e( 'Take Your Website To New Height with', 'sociatic' ); ?> <span>Gutenverse!</span></h3> 
						<p><?php esc_html_e( 'Sociatic theme work best with Gutenverse plugin. By installing Gutenverse plugin you may access Sociatic templates built with Gutenverse and get access to more than 40 free blocks, hundred free Layout and Section.', 'sociatic' ); ?></p>
						<div class="gutenverse-bottom">
							<a class="gutenverse-button" id="gutenverse-install-plugin" href="<?php echo esc_url( $button_link ); ?>">
								<?php echo esc_html( $button_text ); ?>
							</a>
						</div>
					</div>
					<div class="gutenverse-notice-image">
						<img src="<?php echo esc_url( SOCIATIC_URI . '/assets/img/banner-install-gutenverse-2.png' ); ?>"/>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Generate Global Font
	 *
	 * @param string $value  Value of the option.
	 *
	 * @return string
	 */
	public function global_header_style( $value ) {
		$theme_name      = get_stylesheet();
		$global_variable = get_option( 'gutenverse-global-variable-font-' . $theme_name );

		if ( empty( $global_variable ) && function_exists( 'gutenverse_global_font_style_generator' ) ) {
			$font_variable = $this->default_font_variable();
			$value        .= \gutenverse_global_font_style_generator( $font_variable );
		}

		return $value;
	}

	/**
	 * Header Font.
	 *
	 * @param mixed $value  Value of the option.
	 *
	 * @return mixed Value of the option.
	 */
	public function default_header_font( $value ) {
		if ( ! $value ) {
			$value = array(
				array(
					'value'  => 'Alfa Slab One',
					'type'   => 'google',
					'weight' => 'bold',
				),
			);
		}

		return $value;
	}

	/**
	 * Alter Default Font.
	 *
	 * @param array $config Array of Config.
	 *
	 * @return array
	 */
	public function default_font( $config ) {
		if ( empty( $config['globalVariable']['fonts'] ) ) {
			$config['globalVariable']['fonts'] = $this->default_font_variable();

			return $config;
		}

		if ( ! empty( $config['globalVariable']['fonts'] ) ) {
			// Handle existing fonts.
			$theme_name   = get_stylesheet();
			$initial_font = get_option( 'gutenverse-font-init-' . $theme_name );

			if ( ! $initial_font ) {
				$config['globalVariable']['fonts'] = array_merge( $config['globalVariable']['fonts'], $this->default_font_variable() );
				update_option( 'gutenverse-font-init-' . $theme_name, true );
			}
		}

		return $config;
	}

	/**
	 * Default Font Variable.
	 *
	 * @return array
	 */
	public function default_font_variable() {
		return array(
			array(
				'id'   => 'a0sRlN',
				'name' => 'Text Body',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Hind Siliguri',
						'value' => 'Hind Siliguri',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Desktop' =>
						array(
							'point' => '16',
							'unit'  => 'px',
						),
					),
					'weight'     => '400',
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1.5',
						),
					),
				),
			),
			array(
				'id'   => 'uiccB6',
				'name' => 'H1',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Muli',
						'value' => 'Muli',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Desktop' =>
						array(
							'point' => '66',
							'unit'  => 'px',
						),
						'Tablet'  =>
						array(
							'point' => '74',
							'unit'  => 'px',
						),
						'Mobile'  =>
						array(
							'point' => '36',
							'unit'  => 'px',
						),
					),
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1.1',
						),
					),
					'weight'     => '800',
				),
			),
			array(
				'id'   => '1Isv3n',
				'name' => 'H1 Hero Page',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Muli',
						'value' => 'Muli',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Desktop' =>
						array(
							'point' => '56',
							'unit'  => 'px',
						),
						'Mobile'  =>
						array(
							'point' => '36',
							'unit'  => 'px',
						),
						'Tablet'  =>
						array(
							'point' => '44',
							'unit'  => 'px',
						),
					),
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1.1',
						),
					),
					'weight'     => '800',
				),
			),
			array(
				'id'   => 'oTRAFP',
				'name' => 'H2',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Muli',
						'value' => 'Muli',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Desktop' =>
						array(
							'point' => '46',
							'unit'  => 'px',
						),
						'Mobile'  =>
						array(
							'point' => '32',
							'unit'  => 'px',
						),
						'Tablet'  =>
						array(
							'point' => '44',
							'unit'  => 'px',
						),
					),
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1.1',
						),
					),
					'weight'     => '800',
				),
			),
			array(
				'id'   => 'LzdbXD',
				'name' => 'H3',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Muli',
						'value' => 'Muli',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Desktop' =>
						array(
							'point' => '34',
							'unit'  => 'px',
						),
						'Mobile'  =>
						array(
							'point' => '28',
							'unit'  => 'px',
						),
						'Tablet'  =>
						array(
							'point' => '28',
							'unit'  => 'px',
						),
					),
					'weight'     => '800',
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1.2',
						),
					),
				),
			),
			array(
				'id'   => 'PaPuy7',
				'name' => 'H4',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Muli',
						'value' => 'Muli',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Desktop' =>
						array(
							'point' => '26',
							'unit'  => 'px',
						),
						'Tablet'  =>
						array(
							'point' => '24',
							'unit'  => 'px',
						),
						'Mobile'  =>
						array(
							'point' => '24',
							'unit'  => 'px',
						),
					),
					'weight'     => '800',
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1.2',
						),
					),
				),
			),
			array(
				'id'   => 'rhlJXQ',
				'name' => 'H5',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Muli',
						'value' => 'Muli',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Desktop' =>
						array(
							'point' => '24',
							'unit'  => 'px',
						),
					),
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1.1',
						),
					),
					'weight'     => '800',
				),
			),
			array(
				'id'   => 'hdpsvl',
				'name' => 'H6',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Muli',
						'value' => 'Muli',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Mobile'  =>
						array(
							'point' => '20',
							'unit'  => 'px',
						),
						'Tablet'  =>
						array(
							'point' => '22',
							'unit'  => 'px',
						),
						'Desktop' =>
						array(
							'point' => '22',
							'unit'  => 'px',
						),
					),
					'weight'     => '800',
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1.3',
						),
					),
				),
			),
			array(
				'id'   => 'CfBlR9',
				'name' => 'Text Hero',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Muli',
						'value' => 'Muli',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Desktop' =>
						array(
							'point' => '18',
							'unit'  => 'px',
						),
						'Tablet'  =>
						array(
							'point' => '18',
							'unit'  => 'px',
						),
						'Mobile'  =>
						array(
							'point' => '16',
							'unit'  => 'px',
						),
					),
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1.5',
						),
					),
					'weight'     => '400',
				),
			),
			array(
				'id'   => 'HyL09M',
				'name' => '185',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Muli',
						'value' => 'Muli',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Desktop' =>
						array(
							'point' => '30',
							'unit'  => 'px',
						),
						'Tablet'  =>
						array(
							'point' => '24',
							'unit'  => 'px',
						),
						'Mobile'  =>
						array(
							'point' => '24',
							'unit'  => 'px',
						),
					),
					'weight'     => '800',
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1.5',
						),
					),
				),
			),
			array(
				'id'   => 'BBe7T5',
				'name' => 'Pricing Number',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Muli',
						'value' => 'Muli',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Desktop' =>
						array(
							'point' => '50',
							'unit'  => 'px',
						),
						'Mobile'  =>
						array(
							'point' => '48',
							'unit'  => 'px',
						),
						'Tablet'  =>
						array(
							'point' => '48',
							'unit'  => 'px',
						),
					),
					'weight'     => '800',
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1',
						),
					),
				),
			),
			array(
				'id'   => 'vRlVnG',
				'name' => 'Focus Title',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Hind Siliguri',
						'value' => 'Hind Siliguri',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Desktop' =>
						array(
							'point' => '18',
							'unit'  => 'px',
						),
						'Tablet'  =>
						array(
							'point' => '18',
							'unit'  => 'px',
						),
						'Mobile'  =>
						array(
							'point' => '16',
							'unit'  => 'px',
						),
					),
					'weight'     => '400',
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1.2',
						),
					),
				),
			),
			array(
				'id'   => 'pnXC9z',
				'name' => 'Button',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Hind Siliguri',
						'value' => 'Hind Siliguri',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Desktop' =>
						array(
							'point' => '16',
							'unit'  => 'px',
						),
						'Tablet'  =>
						array(
							'point' => '16',
							'unit'  => 'px',
						),
						'Mobile'  =>
						array(
							'point' => '16',
							'unit'  => 'px',
						),
					),
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1',
						),
					),
					'weight'     => '500',
				),
			),
			array(
				'id'   => 'C1iLU3',
				'name' => 'Category',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Muli',
						'value' => 'Muli',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Desktop' =>
						array(
							'point' => '14',
							'unit'  => 'px',
						),
						'Tablet'  =>
						array(
							'point' => '16',
							'unit'  => 'px',
						),
						'Mobile'  =>
						array(
							'point' => '14',
							'unit'  => 'px',
						),
					),
					'weight'     => '500',
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1',
						),
					),
				),
			),
			array(
				'id'   => 'VpadVK',
				'name' => 'Author',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Hind Siliguri',
						'value' => 'Hind Siliguri',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Tablet'  =>
						array(
							'point' => '12',
							'unit'  => 'px',
						),
						'Desktop' =>
						array(
							'point' => '12',
							'unit'  => 'px',
						),
						'Mobile'  =>
						array(
							'point' => '12',
							'unit'  => 'px',
						),
					),
					'weight'     => '400',
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'point' => '1',
							'unit'  => 'px',
						),
					),
				),
			),
			array(
				'id'   => 'FPIdVf',
				'name' => 'Nav Menu',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Hind Siliguri',
						'value' => 'Hind Siliguri',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Desktop' =>
						array(
							'point' => '18',
							'unit'  => 'px',
						),
						'Tablet'  =>
						array(
							'point' => '18',
							'unit'  => 'px',
						),
						'Mobile'  =>
						array(
							'point' => '16',
							'unit'  => 'px',
						),
					),
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1.2',
						),
					),
					'weight'     => '400',
				),
			),
			array(
				'id'   => 'kxo4Qg',
				'name' => 'Likes',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Hind Siliguri',
						'value' => 'Hind Siliguri',
						'type'  => 'google',
					),
					'weight'     => '400',
					'size'       =>
					array(
						'Desktop' =>
						array(
							'point' => '20',
							'unit'  => 'px',
						),
						'Tablet'  =>
						array(
							'point' => '20',
							'unit'  => 'px',
						),
					),
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1',
						),
					),
				),
			),
			array(
				'id'   => 'i52CMo',
				'name' => 'Fun Fact',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Muli',
						'value' => 'Muli',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Desktop' =>
						array(
							'point' => '36',
							'unit'  => 'px',
						),
						'Tablet'  =>
						array(
							'point' => '34',
							'unit'  => 'px',
						),
						'Mobile'  =>
						array(
							'point' => '32',
							'unit'  => 'px',
						),
					),
					'weight'     => '800',
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1.6',
						),
					),
				),
			),
			array(
				'id'   => '1Tn02D',
				'name' => 'Post Meta',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Hind Siliguri',
						'value' => 'Hind Siliguri',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Desktop' =>
						array(
							'point' => '14',
							'unit'  => 'px',
						),
						'Tablet'  =>
						array(
							'point' => '14',
							'unit'  => 'px',
						),
						'Mobile'  =>
						array(
							'point' => '14',
							'unit'  => 'px',
						),
					),
					'weight'     => '400',
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1',
						),
					),
				),
			),
			array(
				'id'   => 'MeJ5ER',
				'name' => '404',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Muli',
						'value' => 'Muli',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Mobile'  =>
						array(
							'point' => '92',
							'unit'  => 'px',
						),
						'Tablet'  =>
						array(
							'point' => '116',
							'unit'  => 'px',
						),
						'Desktop' =>
						array(
							'point' => '136',
							'unit'  => 'px',
						),
					),
					'weight'     => '800',
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1.1',
						),
					),
				),
			),
			array(
				'id'   => 'YAPBT8',
				'name' => 'Text Icon Hero',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Hind Siliguri',
						'value' => 'Hind Siliguri',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Desktop' =>
						array(
							'point' => '18',
							'unit'  => 'px',
						),
						'Tablet'  =>
						array(
							'point' => '18',
							'unit'  => 'px',
						),
						'Mobile'  =>
						array(
							'point' => '16',
							'unit'  => 'px',
						),
					),
					'weight'     => '500',
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1',
						),
					),
				),
			),
			array(
				'id'   => 'ToWh5m',
				'name' => 'Teams Name',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Muli',
						'value' => 'Muli',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Desktop' =>
						array(
							'point' => '28',
							'unit'  => 'px',
						),
						'Tablet'  =>
						array(
							'point' => '22',
							'unit'  => 'px',
						),
						'Mobile'  =>
						array(
							'point' => '24',
							'unit'  => 'px',
						),
					),
					'weight'     => '800',
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1.2',
						),
					),
				),
			),
			array(
				'id'   => 'K0QhlR',
				'name' => 'Title Post Blog',
				'font' =>
				array(
					'font'       =>
					array(
						'label' => 'Muli',
						'value' => 'Muli',
						'type'  => 'google',
					),
					'size'       =>
					array(
						'Desktop' =>
						array(
							'point' => '18',
							'unit'  => 'px',
						),
						'Tablet'  =>
						array(
							'point' => '18',
							'unit'  => 'px',
						),
						'Mobile'  =>
						array(
							'point' => '16',
							'unit'  => 'px',
						),
					),
					'weight'     => '700',
					'lineHeight' =>
					array(
						'Desktop' =>
						array(
							'unit'  => 'em',
							'point' => '1.7',
						),
					),
				),
			),
		);
	}



	/**
	 * Add Template to Editor.
	 *
	 * @param array $template_files Path to Template File.
	 * @param array $template_type Template Type.
	 *
	 * @return array
	 */
	public function add_template( $template_files, $template_type ) {
		if ( 'wp_template' === $template_type ) {
			$new_templates = array(
				'home',
				'about',
				'service',
				'blog',
				'contact',
				'index',
				'page',
				'single',
				'archive',
				'search',
				'404',
				'basic-template',
				'blank-canvas',
			);

			foreach ( $new_templates as $template ) {
				$template_files[] = array(
					'slug'  => $template,
					'path'  => $this->change_stylesheet_directory() . "/templates/{$template}.html",
					'theme' => get_template(),
					'type'  => 'wp_template',
				);
			}
		}

		return $template_files;
	}

	/**
	 * Use gutenverse template file instead.
	 *
	 * @param string $template_file Path to Template File.
	 * @param string $theme_slug Theme Slug.
	 * @param string $template_slug Template Slug.
	 *
	 * @return string
	 */
	public function template_path( $template_file, $theme_slug, $template_slug ) {
		switch ( $template_slug ) {
			case 'home':
				return $this->change_stylesheet_directory() . '/templates/home.html';
			case 'about':
				return $this->change_stylesheet_directory() . '/templates/about.html';
			case 'service':
				return $this->change_stylesheet_directory() . '/templates/service.html';
			case 'blog':
				return $this->change_stylesheet_directory() . '/templates/blog.html';
			case 'contact':
				return $this->change_stylesheet_directory() . '/templates/contact.html';
			case 'index':
				return $this->change_stylesheet_directory() . '/templates/index.html';
			case 'page':
				return $this->change_stylesheet_directory() . '/templates/page.html';
			case 'single':
				return $this->change_stylesheet_directory() . '/templates/single.html';
			case 'archive':
				return $this->change_stylesheet_directory() . '/templates/archive.html';
			case 'search':
				return $this->change_stylesheet_directory() . '/templates/search.html';
			case '404':
				return $this->change_stylesheet_directory() . '/templates/404.html';
			case 'header':
				return $this->change_stylesheet_directory() . '/parts/header.html';
			case 'footer':
				return $this->change_stylesheet_directory() . '/parts/footer.html';
			case 'basic-template':
				return $this->change_stylesheet_directory() . '/templates/basic-template.html';
			case 'blank-canvas':
				return $this->change_stylesheet_directory() . '/templates/blank-canvas.html';
		}

		return $template_file;
	}

	/**
	 * Register Block Pattern.
	 */
	public function register_block_patterns() {
		new Block_Patterns();
	}

	/**
	 * Enqueue scripts and styles.
	 */
	public function backend_scripts() {
		$screen = get_current_screen();

		wp_enqueue_script( 'wp-api' );

		if ( $screen->id === 'appearance_page_sociatic-dashboard' ) {
			// enqueue css.
			wp_enqueue_style(
				'sociatic-dashboard',
				SOCIATIC_URI . '/assets/css/dashboard.css',
				array(),
				SOCIATIC_VERSION
			);

			// enqueue js.
			wp_enqueue_script(
				'sociatic-dashboard',
				SOCIATIC_URI . '/assets/js/dashboard.js',
				array( 'wp-api-fetch' ),
				SOCIATIC_VERSION,
				true
			);

			wp_localize_script( 'sociatic-dashboard', 'GutenverseThemeConfig', $this->theme_config() );
		}
	}

	/**
	 * Register static data to be used in theme's js file
	 */
	public function theme_config() {
		return array(
			'demo'    => esc_url( 'https:/gutenverse.com/demo?name=sociatic' ),
			'pages'   => array(
				'page-0' => SOCIATIC_URI . 'assets/img/Home-1-scaled.jpg',
				'page-1' => SOCIATIC_URI . 'assets/img/About-scaled.jpg',
				'page-2' => SOCIATIC_URI . 'assets/img/Service-scaled.jpg',
				'page-3' => SOCIATIC_URI . 'assets/img/Single-Post-scaled.jpg',
				'page-4' => SOCIATIC_URI . 'assets/img/Blog.jpg',
			),
			'domain'  => 'sociatic',
			'plugins' => array(
				array(
					'slug' => 'gutenverse',
					'name' => 'Gutenverse',
				),
			),
		);
	}

	/**
	 * Add Menu
	 */
	public function admin_menu() {
		add_theme_page(
			'Sociatic Dashboard',
			'Sociatic Dashboard',
			'manage_options',
			'sociatic-dashboard',
			array( $this, 'load_dashboard' ),
			1
		);
	}

	/**
	 * Template page
	 */
	public function load_dashboard() {
		?>
			<div id="gutenverse-theme-dashboard">
			</div>
		<?php
	}
}
