<?php
/**
 * Plugin Name: PW Net Auto Cancel Orders
 * Description: Automatically cancels WooCommerce orders after a specified time if they remain in selected statuses.
 * Version: 1.0.0
 * Author: Waldemar Ptak
 * Text Domain: pw-net-auto-cancel
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Prevent direct access
}

// Activation hook
register_activation_hook( __FILE__, 'pw_net_auto_cancel_activate' );
function pw_net_auto_cancel_activate() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        deactivate_plugins( plugin_basename( __FILE__ ) );
        wp_die( __( 'WooCommerce must be installed and activated for PW Net Auto Cancel Orders to work.', 'pw-net-auto-cancel' ) );
    }
}

// Deactivation hook
register_deactivation_hook( __FILE__, 'pw_net_auto_cancel_deactivate' );
function pw_net_auto_cancel_deactivate() {
    wp_clear_scheduled_hook( 'pw_net_auto_cancel_cron' );
}

// Add custom interval options for the scheduler
add_filter( 'cron_schedules', 'pw_net_auto_cancel_intervals' );
function pw_net_auto_cancel_intervals( $schedules ) {
    $interval = get_option( 'pw_net_auto_cancel_interval', 30 );
    $schedules['pw_net_custom_interval'] = [
        'interval' => $interval * 60,
        'display'  => __( 'Custom Interval', 'pw-net-auto-cancel' ),
    ];
    return $schedules;
}

// Schedule cron job
if ( ! wp_next_scheduled( 'pw_net_auto_cancel_cron' ) ) {
    wp_schedule_event( time(), 'pw_net_custom_interval', 'pw_net_auto_cancel_cron' );
}

// Cron job action
add_action( 'pw_net_auto_cancel_cron', 'pw_net_auto_cancel_orders' );
function pw_net_auto_cancel_orders() {
    $statuses        = get_option( 'pw_net_auto_cancel_statuses', [] );
    $hours_limit     = get_option( 'pw_net_auto_cancel_hours', 12 );
    $send_email      = get_option( 'pw_net_auto_cancel_email_enable', false );
    $cancel_time     = $hours_limit * HOUR_IN_SECONDS;

    $args = [
        'status' => $statuses,
        'limit'  => -1,
    ];

    $orders = wc_get_orders( $args );

    foreach ( $orders as $order ) {
        $date_created = $order->get_date_created();
        if ( $date_created && ( time() - $date_created->getTimestamp() ) > $cancel_time ) {
            $order->update_status( 'cancelled', __( 'Order automatically cancelled due to inactivity.', 'pw-net-auto-cancel' ) );
            if ( $send_email ) {
                do_action( 'pw_net_auto_cancelled_order_notification', $order->get_id() );
            }
        }
    }
}

// Add custom email class
add_filter( 'woocommerce_email_classes', function ( $email_classes ) {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-email-auto-cancelled-order.php';
    $email_classes['WC_Email_PW_Net_Auto_Cancelled_Order'] = new WC_Email_PW_Net_Auto_Cancelled_Order();
    return $email_classes;
} );

add_action( 'pw_net_auto_cancelled_order_notification', function ( $order_id ) {
    $email = WC()->mailer()->emails['WC_Email_PW_Net_Auto_Cancelled_Order'];
    $email->trigger( $order_id );
} );

// Add settings tab to WooCommerce
add_filter( 'woocommerce_get_settings_pages', 'pw_net_auto_cancel_add_settings_tab' );
function pw_net_auto_cancel_add_settings_tab( $settings ) {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-pw-net-auto-cancel-settings.php';
    $settings[] = new PW_Net_Auto_Cancel_Settings();
    return $settings;
}

// Load plugin text domain
add_action( 'plugins_loaded', function () {
    load_plugin_textdomain( 'pw-net-auto-cancel', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
} );
