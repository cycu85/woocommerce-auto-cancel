<?php
/**
 * Plain text email template for auto-cancelled orders.
 *
 * @package PW_Net_Auto_Cancel_Orders
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Prevent direct access
}

echo "= " . esc_html( $email_heading ) . " =\n\n";

echo sprintf(
    esc_html__( 'Hello %s,', 'pw-net-auto-cancel' ),
    esc_html( $order->get_billing_first_name() )
) . "\n\n";

echo esc_html__( 'We regret to inform you that your order has been automatically canceled because it was not completed within the specified time limit.', 'pw-net-auto-cancel' ) . "\n\n";

echo esc_html__( 'Here are the details of your canceled order:', 'pw-net-auto-cancel' ) . "\n\n";

echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";

echo sprintf( esc_html__( 'Order number: %s', 'pw-net-auto-cancel' ), esc_html( $order->get_order_number() ) ) . "\n";
echo sprintf( esc_html__( 'Order date: %s', 'pw-net-auto-cancel' ), esc_html( wc_format_datetime( $order->get_date_created() ) ) ) . "\n";

echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo esc_html__( 'If you have any questions, feel free to contact us.', 'pw-net-auto-cancel' ) . "\n\n";

echo esc_html__( 'Thank you for your understanding.', 'pw-net-auto-cancel' ) . "\n\n";

echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n";
echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) );
