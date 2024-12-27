# woocommerce-auto-cancel
=== PW-Net Auto Cancel Orders ===
Contributors: yourname
Tags: WooCommerce, orders, auto cancel, email notifications
Requires at least: 5.6
Tested up to: 6.4
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Automatically cancel WooCommerce orders after a configurable period and optionally notify customers via email.

== Description ==

The **PW-Net Auto Cancel Orders** plugin provides an automated way to manage pending or incomplete orders in WooCommerce. You can configure the plugin to automatically cancel orders that remain in selected statuses (e.g., Pending, On-Hold) for a specified amount of time. Additionally, the plugin supports sending custom email notifications to customers when their orders are canceled.

### Key Features:
- Automatically cancel orders after a user-defined time in hours.
- Select specific order statuses for cancellation.
- Flexible scheduling interval for the auto-cancellation task.
- Option to send customizable email notifications upon order cancellation.
- Fully localized with translation files for multiple languages.

### Translation Support:
This plugin includes translations for the following languages:
- English (default)
- Polish
- German
- Italian
- Spanish
- Romanian

== Installation ==

1. Download the plugin and upload the files to the `/wp-content/plugins/pw-net-auto-cancel/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Navigate to **WooCommerce > Settings > Cancellation** to configure the plugin settings.

== Configuration ==

- **Enable Auto Cancellation**: Turn on/off the automatic cancellation of orders.
- **Cancellation Time**: Specify the time limit (in hours) after which orders are canceled.
- **Scheduler Interval**: Define how often the cancellation process should run.
- **Select Order Statuses**: Choose the statuses that the plugin will monitor for cancellation.
- **Send Cancellation Email**: Enable/disable email notifications to customers upon order cancellation.
- **Email Template Customization**: Customize the email template by copying the template files from the plugin directory to your theme’s WooCommerce email folder.

  
![alt text](https://github.com/cycu85/woocommerce-auto-cancel/blob/main/wac1.png)


== Frequently Asked Questions ==

**Q: Will this plugin notify customers when their orders are canceled?**  
A: Yes, if the "Send Cancellation Email" option is enabled, the plugin will send an email using a customizable template.  

**Q: Can I customize the email template?**  
A: Absolutely! Copy the files from the plugin’s `/templates/emails/` directory to your theme’s WooCommerce email folder and edit them as needed.

**Q: What happens if the plugin is deactivated?**  
A: All scheduled tasks and plugin settings will be removed, ensuring a clean deactivation process.

== Changelog ==

= 1.0.0 =
- Initial release with automated order cancellation and email notification features.

== License ==

This plugin is licensed under the GPLv2 or later. See [License URI](https://www.gnu.org/licenses/gpl-2.0.html) for details.
