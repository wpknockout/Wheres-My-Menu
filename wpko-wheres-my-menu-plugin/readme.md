# WPKO - Where's My Menu?

**A WP Knockout Free Utility Plugin**

## Summary

This plugin restores the essential **Appearance > Menus** link in the WordPress administrative dashboard when using modern Full Site Editing (FSE) themes, such as Twenty Twenty-Two, Twenty Twenty-Three, and Twenty Twenty-Five.

Additionally, it automatically generates a simple shortcode for every menu you create, allowing you to easily embed classic navigation menus anywhere on your site, including in posts, pages, widgets, and within block templates.

## Context

With the shift to Full Site Editing, many users familiar with the classic WordPress dashboard find the Menu and Widget options missing. This plugin brings back the familiar menu management screen for those who prefer to manage their menus classically while still using a modern block theme.

## Features

* **Restores Menu Link:** Adds `Appearance > Menus` back to the dashboard.
* **Automatic Shortcodes:** Generates a shortcode for every single menu created.
* **Instruction Page:** Provides a dedicated page under `Appearance > Menu Shortcodes` with a quick reference for all available shortcodes and corresponding PHP snippets.
* **PHP 8.4+ Ready:** Built with modern PHP standards and security best practices.

## Installation

1. Download the plugin ZIP file.
2. Go to your WordPress dashboard, navigate to **Plugins > Add New > Upload Plugin**.
3. Upload the ZIP file and click **Install Now**.
4. Activate the plugin.

## Usage

1. After activation, navigate to **Appearance > Menus** (the link is now restored!) to manage your menus.
2. Once you create a menu, navigate to **Appearance > Menu Shortcodes**.
3. Copy the shortcode provided (e.g., `[wpko_menu id="42"]`) and paste it into any Block, Classic Editor, or Widget area to display your menu.
4. Alternatively, use the PHP snippet in your theme templates: `<?php echo do_shortcode( '[wpko_menu id="42"]' ); ?>`

## Licensing

This plugin is released under the **GPL-2.0-or-later** license. You are free to use, modify, and redistribute it. A copy of the license is included in the `LICENCE.txt` file.

## Contributions

Contributions are welcome! If you find a bug or have a suggestion, please open an issue or submit a pull request on the GitHub repository.

## Links

* **Plugin Author Website:** [https://wpknockout.com](https://wpknockout.com)
* **GitHub Repository:** [\[Insert Git Link Here\]](#)

## Todo List (Future Enhancements)

* [ ] Add shortcode options for depth, container, and custom class.
* [ ] Introduce a simple block to easily select and display menus in the Block Editor.
* [ ] Provide a custom fallback message option for when a menu is not found.

## File Tree Map

```
wpko-wheres-my-menu/
├── readme.md
├── wpko-wheres-my-menu.php
├── LICENCE.txt
└── includes/
    ├── class-wpko-wmm-admin.php
    └── class-wpko-wmm-menu-shortcodes.php
```

## 🔐 Security and Best Practices Implemented

* **Nonce Usage:** Not strictly required for the admin-menu/shortcode-display features, but it is implicitly covered by standard WordPress admin checks.
* **Capability Checks:** `current_user_can( 'edit_theme_options' )` is used to guard administrative pages and output admin error messages.
* **Input Sanitization:** `absint()`, `sanitize_title()`, and `shortcode_atts()` are used to clean shortcode attributes (`id`, `slug`).
* **Output Escaping:** `esc_html_e()`, `esc_html()`, and `esc_attr()` are used for all strings displayed to the user.
* **Singleton Pattern:** The `WPKO_WMM_Plugin` class uses a secure singleton pattern to ensure only one instance runs, preventing conflicts.
