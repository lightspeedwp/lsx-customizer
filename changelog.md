# Change log

## 1.4.0 - In development

### Added

- Added customizer colour options for the Block editor palette

## [[1.3.4]]() - 2020-05-21

### Added

- Woocommerce checkout and cart styling improved.
- Adding in the customizer colour for the accordian block.

### Fixed

- Fixed the My Account menu slug not calling the correct page ID.
- Fixing the my account menu translations.

### Security

- General testing to ensure compatibility with latest WordPress version (5.4.1).
- General testing to ensure compatibility with latest LSX Theme version (2.8).

## [[1.3.3]](https://github.com/lightspeeddevelopment/lsx-customizer/releases/tag/1.3.3) - 2020-03-30

### Fixed

- Moved the un-prefixed `custom_login_url()` function into a class.
- Added the "include-media" mixin to the body colour class, fixing the generating of the CSS.

### Security

- Updating dependencies to prevent vulnerabilities.
- General testing to ensure compatibility with latest WordPress version (5.4).
- General testing to ensure compatibility with latest LSX Theme version (2.7).

## [[1.3.2]](https://github.com/lightspeeddevelopment/lsx-customizer/releases/tag/1.3.2) - 2019-11-13

### Fixed

- Fix - Fixing the `woocommerce_get_page_id is deprecated since version 3.0! Use wc_get_page_id instead.` error.
- Fix - Fixing the `WC_Cart::get_cart_url is deprecated since version 2.5! Use wc_get_cart_url instead.` error.
- Fix - Fixing the placeholders for the widgets.

## [[1.3.1]](https://github.com/lightspeeddevelopment/lsx-customizer/releases/tag/1.3.1) - 2019-08-21

### Added

- Added in Repeat option for background in login screen options.

### Fixed

- Set background size to initial[None] as default

## [[1.3.0]](https://github.com/lightspeeddevelopment/lsx-customizer/releases/tag/1.3.0) - 2019-08-06

### Added

- Adding logging screen options.
- Added in the logo control.
- Adding classes methods.

### Fixed

- More default styling.
- Adjust box shadow colors.
- Coding Standard fixes.

## [[1.2.2]](https://github.com/lightspeeddevelopment/lsx-customizer/releases/tag/1.2.2) - 2018-04-09

### Added

- Update the SCSS 2 CSS Vendor (http://leafo.github.io/scssphp/).

### Fixed

- Making sure the Thank You page does not redirect when you land on the page.

## [[1.2.1]]()

### Deprecated

- Removed the API Class.

## [[1.2.0]]()

### Added

- WooCommerce checkout layout.
- WooCommerce checkout steps.
- WooCommerce checkout custom thank you page.
- WooCommerce checkout custom cart extra HTML.
- WooCommerce checkout custom checkout extra HTML.
- WooCommerce cart menu item position.
- WooCommerce cart menu item style.
- WooCommerce My Account menu item.
- Add WooCommerce Wishlist compatibility.
- Default colours scheme updated (top menu colors).
- Add Sensei compatibility.

### Fixed

- Extra menu items for logout users / Compatibility with LSX Login.

## [[1.1.0]]()

### Added

- Added compatibility with LSX 2.0.
- New project structure.
- UIX copied from TO 1.1 + Fixed issue with sub tabs click (settings).
- New option: disable theme credit.

### Fixed

- Fixed scripts/styles loading order.
- Fixed small issues.

## [[1.0.3]]()

### Changed

- Moved all blog customizer options to LSX Blog Customizer plugin.

### Fixed

- Added filters to send the custom colours to custom selectors.
- Adjusted the plugin settings link inside the LSX API Class.
- Fixed buttons (default and CTA) selectors (hover, active, focus, visited).

## [[1.0.2]]()

### Fixed

- Fixed all prefixes replaces (to* > lsx_to*, TO* > LSX_TO*).

## [[1.0.1]]()

### Fixed

- Added a extra style selector for main menu CSS: item active + hover.
- Avoided use a return function inside the PHP function "empty" (compatibility with PHP 5.5 and lower).
- Compatibility with WPML 3.6.
- Reduced the access to server (check API key status) using transients.
- Made the API URLs dev/live dynamic using a prefix "dev-" in the API KEY.

## [[1.0.0]]()

### Added

- First Version
