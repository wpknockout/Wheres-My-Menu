<?php
/**
 * Admin logic for WPKO - Where's My Menu?
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPKO_WMM_Admin {

	public function __construct() {
		// Add the 'Menus' link back to the Appearance section.
		add_action( 'admin_menu', [ $this, 'add_classic_menu_link' ], 1 );

		// Add a submenu page under Appearance for shortcode instructions.
		add_action( 'admin_menu', [ $this, 'add_shortcode_instructions_page' ], 20 );
	}

	/**
	 * Adds the classic 'Menus' link back under Appearance.
	 * This uses the standard menus page URL.
	 */
	public function add_classic_menu_link(): void {
		// Ensure the user has the capability to manage theme options.
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}

		add_submenu_page(
			'themes.php',              // Parent slug: Appearance.
			__( 'Menus', 'wpko-wmm' ), // Page title.
			__( 'Menus', 'wpko-wmm' ), // Menu title.
			'edit_theme_options',      // Capability.
			'nav-menus.php',           // Menu slug: Uses the default one.
			''                         // Callback: Empty string to use the default WordPress page.
		);
	}

	/**
	 * Adds a separate instructions page for shortcodes under Appearance.
	 */
	public function add_shortcode_instructions_page(): void {
		add_submenu_page(
			'themes.php',                                  // Parent slug: Appearance.
			__( 'Menu Shortcodes', 'wpko-wmm' ),           // Page title.
			__( 'Menu Shortcodes', 'wpko-wmm' ),           // Menu title.
			'edit_theme_options',                          // Capability.
			'wpko-wmm-shortcode-instructions',             // Menu slug.
			[ $this, 'render_shortcode_instructions_page' ] // Callback.
		);
	}

	/**
	 * Renders the shortcode instructions page.
	 */
	public function render_shortcode_instructions_page(): void {
		// Check user capability again (defensive).
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.', 'wpko-wmm' ) );
		}

		$menus = wp_get_nav_menus();
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'WPKO - Where\'s My Menu? Shortcode Instructions', 'wpko-wmm' ); ?></h1>
			<p class="description">
				<?php esc_html_e( 'Use the shortcodes below to embed your menus anywhere on your site (posts, pages, widgets, and even in FSE template parts).', 'wpko-wmm' ); ?>
			</p>

			<h2 style="margin-top: 30px;"><?php esc_html_e( 'Available Menus and Shortcodes', 'wpko-wmm' ); ?></h2>

			<?php if ( ! empty( $menus ) ) : ?>
				<table class="wp-list-table widefat striped">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Menu Name', 'wpko-wmm' ); ?></th>
							<th><?php esc_html_e( 'Shortcode', 'wpko-wmm' ); ?></th>
							<th><?php esc_html_e( 'PHP Snippet for Templates', 'wpko-wmm' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $menus as $menu ) : ?>
							<tr>
								<td>
									<strong><?php echo esc_html( $menu->name ); ?></strong>
									<p style="font-size: 11px; margin: 0; color: #777;">(ID: <?php echo esc_html( $menu->term_id ); ?>)</p>
								</td>
								<td>
									<code style="background-color: #f0f0f0; padding: 4px 8px; border-radius: 3px; font-size: 14px;">
										[wpko_menu id="<?php echo esc_attr( $menu->term_id ); ?>"]
									</code>
								</td>
								<td>
									<code style="background-color: #f0f0f0; padding: 4px 8px; border-radius: 3px; font-size: 14px;">
										&lt;?php echo do_shortcode( '[wpko_menu id="<?php echo esc_attr( $menu->term_id ); ?>"]' ); ?&gt;
									</code>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php else : ?>
				<p>
					<?php
					printf(
						/* translators: 1: opening link tag, 2: closing link tag */
						esc_html__( 'No menus found. Please create one by going to %1$sAppearance > Menus%2$s.', 'wpko-wmm' ),
						'<a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">',
						'</a>'
					);
					?>
				</p>
			<?php endif; ?>
		</div>
		<?php
	}
}
