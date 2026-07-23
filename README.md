# Quick Popup Anything — Lightweight WordPress Popup Plugin

[![WordPress](https://img.shields.io/badge/WordPress-5.0%2B-blue.svg)](https://wordpress.org/plugins/quick-popup-anything/)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple.svg)](https://www.php.net/)
[![License](https://img.shields.io/badge/License-GPLv2-green.svg)](https://www.gnu.org/licenses/gpl-2.0.html)

The most **lightweight, SEO-friendly popup & modal plugin** for WordPress. Create professional exit-intent popups, auto-open announcements, scroll-triggered modals, and promotional overlays — **without writing a single line of code**.

## ✨ Features

### Core
- **HTML Popup** — Add any HTML, text, images, or formatted content
- **Shortcode Support** — Embed shortcodes from your favorite plugins inside the popup
- **Visual Editor** — Use the familiar WordPress WYSIWYG editor for popup content
- **Responsive Design** — Popups look great on desktop, tablet, and mobile

### Smart Triggers
- **🚪 Exit Intent** — Show the popup when visitors are about to leave your site
- **⏱️ Auto-Open Delay** — Automatically display after a configurable number of seconds
- **📜 Scroll Trigger** — Show popup after visitors scroll past a percentage of the page
- **🖱️ Button Click** — Floating button with 4 position options (Center Left, Center Right, Bottom Left, Bottom Right)
- **🔗 CSS Class Trigger** — Add class `miqpa-open-popup` to any element to open the popup on click
- **📋 Shortcode Button** — Use `[quick_popup_button]` to place popup trigger buttons anywhere in posts and pages

### Display Control
- **Display Only Once** — Show the popup once per visitor using localStorage
- **Hide on Mobile** — Disable popup and button on small screens (< 600px)
- **Disable Popup** — Quickly turn off the popup without deactivating the plugin

### Customization
- **4 Animation Effects** — Fade, Zoom, Slide Up, Slide Down
- **Overlay Control** — Customize overlay color and opacity
- **Button Styling** — Background color, text color, hover colors, z-index
- **Popup Styling** — Background color, text color, max width
- **Custom CSS ID & Class** — Add your own identifiers for advanced styling

### Performance
- **Lightweight** — Minimal footprint, won't slow down your Core Web Vitals
- **Conditional Loading** — CSS & JS only load when the popup is enabled
- **Zero Dependencies** — Only uses jQuery (bundled with WordPress) and Magnific Popup

### Security
- **Bulletproof Sanitization** — Every input validated and sanitized server-side
- **XSS Protection** — All output properly escaped
- **CSRF Protection** — WordPress nonce verification on all settings
- **No External Requests** — No tracking, no phone-home, fully self-contained

## 🚀 Getting Started

### Installation

1. Download the plugin as a ZIP file
2. Go to **WordPress Admin → Plugins → Add New → Upload Plugin**
3. Upload the ZIP file and click **Install Now**
4. Activate the plugin
5. Navigate to **Quick Popup** in the admin sidebar

### Quick Setup

1. **Popup Content Tab** — Write your popup content using the visual editor
2. **Button Settings Tab** — Customize the floating trigger button
3. **Popup Settings Tab** — Configure triggers, animations, and appearance
4. Click **Save Settings** — Your popup is live!

### Shortcode Usage

Place a popup trigger button anywhere in your posts or pages:

```
[quick_popup_button label="Click Me" class="my-custom-class" id="my-button"]
```

### CSS Class Trigger

Add the class `miqpa-open-popup` to any HTML element to make it open the popup:

```html
<a href="#" class="miqpa-open-popup">Open Popup</a>
<button class="miqpa-open-popup">Show Offer</button>
```

## ❓ Frequently Asked Questions

### Does this plugin slow down my website?
No. Quick Popup Anything is built with performance in mind. CSS and JavaScript files only load when the popup is enabled, and the total footprint is under 30KB.

### Will this popup affect my SEO?
No. The plugin follows Google's guidelines for interstitials. The popup content is rendered in standard HTML, and you can use the "Hide on Mobile" option to comply with Google's mobile-friendly requirements.

### Can I show the popup only once per visitor?
Yes! Enable the "Display Only Once" option in Popup Settings. The plugin uses localStorage to remember returning visitors.

### Can I trigger the popup from a menu item?
Yes! Add the CSS class `miqpa-open-popup` to any menu item via **Appearance → Menus → CSS Classes** and it will open the popup on click.

### Does it work with page builders like Elementor?
Yes. You can use the `[quick_popup_button]` shortcode in any page builder's text/shortcode widget.

### Can I show the popup after the user scrolls halfway down?
Yes! Set the "Scroll Trigger" to `50` in Popup Settings, and the popup will appear when visitors scroll past 50% of the page.

## 📋 Changelog

### 2.1.0
- **New:** Exit Intent trigger (desktop)
- **New:** Auto-Open Delay timer
- **New:** Scroll Trigger (percentage-based)
- **New:** 4 animation effects (Fade, Zoom, Slide Up, Slide Down)
- **New:** Overlay color and opacity customization
- **New:** `[quick_popup_button]` shortcode
- **New:** `.miqpa-open-popup` CSS class trigger
- **New:** SEO-optimized plugin description and readme

### 2.0.0
- **Security:** Sanitize callbacks on all settings
- **Security:** XSS protection — all output escaped
- **Security:** CSRF protection via WordPress nonces
- **Security:** Input validation (hex colors, CSS dimensions, CSS identifiers)
- **Fixed:** `$_GET['tab']` XSS vulnerability
- **Fixed:** "Display Only Once" logic bug
- **Fixed:** localStorage being cleared on every page load
- **Fixed:** Admin scripts loading on all pages (now scoped to plugin page)
- **Fixed:** Frontend scripts loading when popup is disabled
- **Fixed:** Wrong text domain
- **Fixed:** Duplicate activation defaults
- **Improved:** Modern admin UI with card-based layout
- **Improved:** Toggle switches for boolean settings
- **Improved:** Field descriptions on all settings
- **Improved:** Responsive admin layout
- **Improved:** Popup open animation (scale + translate)
- **Improved:** Button hover/active micro-animations
- **Improved:** Removed duplicate CSS rules

### 1.0.0
- Initial release

## 🛠️ Built With

- [jQuery](https://jquery.com/) — A fast, small, and feature-rich JavaScript library
- [Magnific Popup](https://dimsemenov.com/plugins/magnific-popup/) — A responsive lightbox & dialog script

## 👥 Developers

- [Parth Solanki](https://monsterinfotech.com/) — Lead Developer
- [Abhishek Kumbhani](https://abhishekkumbhani.com/) — Collaborator

## 📄 License

This project is licensed under the [GPLv2 License](https://www.gnu.org/licenses/gpl-2.0.html).

## 🤝 Contributing

Community contributions, feature requests, bug reports, and patches are always welcome. Please use [GitHub Issues](https://github.com/isolankiparth/quick-popup-anything/issues) for bug reports and feature requests.
