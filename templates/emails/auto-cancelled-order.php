<?php
/**
 * HTML email template for auto-cancelled orders.
 *
 * @package PW_Net_Auto_Cancel_Orders
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Prevent direct access
}

?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p>
    <?php
    echo sprintf(
        esc_html__( 'Hello %s,', 'pw-net-auto-cancel' ),
        esc_html( $order->get_billing_first_name() )
    );
    ?>
</p>

<p>
    <?php echo esc_html__( 'We regret to inform you that your order has been automatically canceled because it was not completed within the specified time limit.', 'pw-net-auto-cancel' ); ?>
</p>

<p>
    <?php echo esc_html__( 'Here are the details of your canceled order:', 'pw-net-auto-cancel' ); ?>
</p>

<h2><?php echo esc_html__( 'Order Details', 'pw-net-auto-cancel' ); ?></h2>

<ul>
    <li>
        <strong><?php echo esc_html__( 'Order number:', 'pw-net-auto-cancel' ); ?></strong>
        <?php echo esc_html( $order->get_order_number() ); ?>
    </li>
    <li>
        <strong><?php echo esc_html__( 'Order date:', 'pw-net-auto-cancel' ); ?></strong>
        <?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?>
    </li>
</ul>

<p>
    <?php echo esc_html__( 'If you have any questions, feel free to contact us.', 'pw-net-auto-cancel' ); ?>
</p>

<p>
    <?php echo esc_html__( 'Thank you for your understanding.', 'pw-net-auto-cancel' ); ?>
</p>

<?php do_action( 'woocommerce_email_footer', $email ); ?>
