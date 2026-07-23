=== Quick Popup Anything ===
Contributors: abhishekkumbhani, isolankiparth
Tags: popup, modal, lightbox, exit intent, lead generation
Requires at least: 5.0
Tested up to: 6.7
Stable tag: 2.1.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Lightweight popup & modal plugin with exit intent, auto-open delay, scroll trigger, 4 animation effects, and shortcode support. No coding needed.

== Description ==

**Quick Popup Anything** is the most lightweight, SEO-friendly popup and modal plugin for WordPress. Create professional exit-intent popups, auto-open announcements, scroll-triggered modals, and promotional overlays — without writing a single line of code.

Perfect for bloggers, WooCommerce store owners, and marketers who need a simple, fast popup solution that won't slow down their site.

= ✨ Key Features =

**Smart Triggers**

* 🚪 **Exit Intent** — Show popup when visitors are about to leave
* ⏱️ **Auto-Open Delay** — Display automatically after a set number of seconds
* 📜 **Scroll Trigger** — Show popup after scrolling past a page percentage
* 🖱️ **Floating Button** — 4 positions: Center Left, Center Right, Bottom Left, Bottom Right
* 🔗 **CSS Class Trigger** — Add `miqpa-open-popup` class to any element
* 📋 **Shortcode** — Use `[quick_popup_button]` anywhere in posts and pages

**Customization**

* 4 animation effects: Fade, Zoom, Slide Up, Slide Down
* Overlay color and opacity control
* Button colors, hover colors, and z-index
* Popup background color, text color, and max width
* Custom CSS ID and class for advanced styling

**Display Control**

* Show popup only once per visitor (localStorage)
* Hide on mobile devices (screens < 600px)
* Disable popup without deactivating the plugin

**Performance & Security**

* Lightweight — under 30KB total, zero impact on Core Web Vitals
* Conditional loading — scripts only load when popup is enabled
* Bulletproof sanitization on all inputs
* XSS protection — all output properly escaped
* No external requests — fully self-contained, no tracking

= 🎯 Use Cases =

* Welcome messages and announcements
* Email newsletter signup forms
* Special offers and promotions
* Cookie consent notices
* Video popups
* Contact form popups (via shortcode)
* Exit-intent lead capture

= Shortcode Usage =

`[quick_popup_button label="Click Me" class="my-class" id="my-button"]`

= CSS Class Trigger =

By default, add the class `miqpa-open-popup` to any HTML element:

`<a href="#" class="miqpa-open-popup">Open Popup</a>`

You can also set a Custom Trigger Class in Popup Settings → Smart Triggers (e.g. `my-custom-trigger`), and both your custom class and `miqpa-open-popup` will work seamlessly.

Works with WordPress menus — just add the CSS class to a menu item via Appearance → Menus.

== Installation ==

1. Upload the `quick-popup-anything` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to **Quick Popup** in the admin sidebar
4. Add your popup content, customize the button, and configure settings
5. Click **Save Settings** — your popup is live!

== Frequently Asked Questions ==

= Does this plugin slow down my website? =

No. Quick Popup Anything is built with performance as a top priority. The total footprint is under 30KB, and CSS/JavaScript files only load when the popup is enabled. Your Core Web Vitals will not be affected.

= Will this popup affect my SEO? =

No. The plugin renders popup content in standard HTML and follows Google's guidelines for interstitials. Use the "Hide on Mobile" option to comply with Google's mobile-friendly requirements.

= Can I show the popup only once per visitor? =

Yes! Enable "Display Only Once" in Popup Settings. The plugin uses localStorage to remember returning visitors — no cookies required.

= Can I trigger the popup from a menu item? =

Absolutely. Add the CSS class `miqpa-open-popup` to any menu item via **Appearance → Menus → Screen Options → CSS Classes**, and it will open the popup on click.

= Does it work with Elementor, Divi, or other page builders? =

Yes. Use the `[quick_popup_button]` shortcode in any page builder's text or shortcode widget.

= Can I show the popup after the user scrolls halfway down the page? =

Yes! Set the "Scroll Trigger" to 50 in Popup Settings, and the popup will appear when visitors scroll past 50% of the page.

= Can I use this for exit-intent popups? =

Yes! Enable "Exit Intent" in Popup Settings. The popup will appear when the visitor's mouse moves toward the browser's close or back button (desktop only).

= Is this plugin GDPR compliant? =

The plugin itself does not collect, store, or transmit any user data. It uses localStorage (not cookies) for the "Display Only Once" feature. The popup content you add is entirely up to you.

== Screenshots ==

1. Admin Settings — Popup Content tab with visual editor
2. Admin Settings — Button Settings tab with color pickers
3. Admin Settings — Popup Settings tab with smart triggers
4. Frontend — Floating button with popup open (Fade animation)
5. Frontend — Popup with Zoom animation effect

== Changelog ==

= 2.1.0 =
* New: Exit Intent trigger
* New: Auto-Open Delay timer
* New: Scroll Trigger (percentage-based)
* New: 4 animation effects (Fade, Zoom, Slide Up, Slide Down)
* New: Overlay color and opacity customization
* New: [quick_popup_button] shortcode
* New: .miqpa-open-popup CSS class trigger
* New: SEO-optimized plugin description and readme

= 2.0.0 =
* Security: Sanitize callbacks on all settings
* Security: XSS protection — all output escaped
* Security: Input validation (hex colors, CSS dimensions, identifiers)
* Fixed: $_GET['tab'] XSS vulnerability
* Fixed: "Display Only Once" logic bug
* Fixed: localStorage cleared on every page load
* Fixed: Admin scripts loading on all admin pages
* Fixed: Frontend scripts loading when popup disabled
* Fixed: Wrong text domain
* Improved: Modern admin UI redesign
* Improved: Toggle switches, field descriptions, responsive layout

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 2.1.0 =
Major feature release: Exit Intent, Auto-Open Delay, Scroll Trigger, 4 animation effects, overlay customization, shortcode support, and CSS class trigger.

= 2.0.0 =
Critical security update: XSS fixes, input sanitization, and admin UI redesign. All users should upgrade immediately.
