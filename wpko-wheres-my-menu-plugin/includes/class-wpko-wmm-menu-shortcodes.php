<?php
/**
 * Shortcode logic for WPKO - Where's My Menu?
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPKO_WMM_Menu_Shortcodes {

	public function __construct() {
		// Register the shortcode.
		add_shortcode( 'wpko_menu', [ $this, 'render_menu_shortcode' ] );
	}

	/**
	 * Shortcode callback to render a WordPress menu.
	 *
	 * Usage: [wpko_menu id="42"] or [wpko_menu slug="main-menu"].
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string The HTML output of the menu, or an empty string.
	 */
	public function render_menu_shortcode( array $atts = [] ): string {
		ob_start();

		// Sanitize attributes with a focus on 'id' (term_id) or 'slug'.
		$atts = shortcode_atts(
			[
				'id'    => 0,                         // Menu ID (term_id).
				'slug'  => '',                        // Menu slug.
				'class' => 'wpko-wmm-shortcode-menu', // Optional CSS class.
			],
			$atts,
			'wpko_menu'
		);

		$menu_args = [
			'echo'            => false,
			'container'       => 'nav',
			'container_class' => esc_attr( $atts['class'] ),
			'menu_class'      => 'menu',
			'fallback_cb'     => false,
		];

		// Determine which menu to load.
		if ( ! empty( $atts['id'] ) ) {
			$menu_args['menu'] = absint( $atts['id'] );
		} elseif ( ! empty( $atts['slug'] ) ) {
			$menu_args['menu'] = sanitize_title( $atts['slug'] );
		}

		// If a menu identifier is present, attempt to render it.
		if ( ! empty( $menu_args['menu'] ) ) {
			// wp_nav_menu() handles its own output escaping for menu items.
			$menu_html = wp_nav_menu( $menu_args );

			if ( $menu_html ) {
				echo $menu_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} elseif ( current_user_can( 'manage_options' ) ) {
				echo '<p style="color: red;">' . esc_html__( 'WPKO Error: Menu not found or empty.', 'wpko-wmm' ) . '</p>';
			}
		}

		return ob_get_clean() ?: '';
	}
}
