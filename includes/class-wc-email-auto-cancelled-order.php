<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Prevent direct access
}

class WC_Email_PW_Net_Auto_Cancelled_Order extends WC_Email {

    public function __construct() {
        $this->id             = 'pw_net_auto_cancelled_order';
        $this->title          = __( 'Auto-Canceled Order', 'pw-net-auto-cancel' );
        $this->description    = __( 'This email is sent when an order is automatically canceled by the plugin.', 'pw-net-auto-cancel' );
        $this->heading        = __( 'Order Canceled', 'pw-net-auto-cancel' );
        $this->subject        = __( 'Your Order Has Been Canceled', 'pw-net-auto-cancel' );
        $this->template_base  = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/';
        $this->template_html  = 'emails/auto-cancelled-order.php';
        $this->template_plain = 'emails/plain-auto-cancelled-order.php';

        parent::__construct();
        $this->recipient = '';
    }

    public function trigger( $order_id ) {
        if ( ! $order_id ) {
            return;
        }

        $this->object    = wc_get_order( $order_id );
        $this->recipient = $this->object->get_billing_email();

        if ( ! $this->is_enabled() || ! $this->get_recipient() ) {
            return;
        }

        $this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
    }

    public function get_content_html() {
        return wc_get_template_html( $this->template_html, array(
            'order'         => $this->object,
            'email_heading' => $this->get_heading(),
            'email'         => $this,
        ), '', $this->template_base );
    }

    public function get_content_plain() {
        return wc_get_template_html( $this->template_plain, array(
            'order'         => $this->object,
            'email_heading' => $this->get_heading(),
            'email'         => $this,
        ), '', $this->template_base );
    }
}
