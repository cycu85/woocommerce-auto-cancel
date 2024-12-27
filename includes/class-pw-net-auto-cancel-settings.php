<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Prevent direct access
}

class PW_Net_Auto_Cancel_Settings extends WC_Settings_Page {

    public function __construct() {
        $this->id    = 'pw_net_auto_cancel';
        $this->label = __( 'Cancellation', 'pw-net-auto-cancel' );

        parent::__construct();

        add_action( 'woocommerce_admin_field_pw_net_auto_cancel_statuses', [ $this, 'pw_net_render_statuses_field' ] );
    }

    public function get_settings() {
        $settings = [
            [
                'title' => __( 'Auto Cancel Orders Settings', 'pw-net-auto-cancel' ),
                'type'  => 'title',
                'desc'  => __( 'Configure the settings for automatically cancelling orders.', 'pw-net-auto-cancel' ),
                'id'    => 'pw_net_auto_cancel_settings_section',
            ],
            [
                'title'   => __( 'Enable Auto Cancellation', 'pw-net-auto-cancel' ),
                'desc'    => __( 'Enable or disable the auto cancellation of orders.', 'pw-net-auto-cancel' ),
                'id'      => 'pw_net_auto_cancel_enable',
                'default' => 'no',
                'type'    => 'checkbox',
            ],
            [
                'title'   => __( 'Cancellation Time (hours)', 'pw-net-auto-cancel' ),
                'desc'    => __( 'Set the time limit in hours for orders to remain in the selected statuses before being automatically cancelled.', 'pw-net-auto-cancel' ),
                'id'      => 'pw_net_auto_cancel_hours',
                'default' => '12',
                'type'    => 'number',
                'desc_tip' => true,
            ],
            [
                'title'   => __( 'Scheduler Interval (minutes)', 'pw-net-auto-cancel' ),
                'desc'    => __( 'Set the interval in minutes for how often the auto cancellation scheduler should run.', 'pw-net-auto-cancel' ),
                'id'      => 'pw_net_auto_cancel_interval',
                'default' => '30',
                'type'    => 'number',
                'desc_tip' => true,
            ],
            [
                'title'   => __( 'Send Cancellation Email', 'pw-net-auto-cancel' ),
                'desc'    => __( 'Enable sending an email to the customer when an order is automatically cancelled.', 'pw-net-auto-cancel' ),
                'id'      => 'pw_net_auto_cancel_email_enable',
                'default' => 'yes',
                'type'    => 'checkbox',
            ],
            [
                'title'   => __( 'Email Template Location', 'pw-net-auto-cancel' ),
                'desc'    => __( 'To customize the email template, copy the file from the plugin directory to your theme\'s WooCommerce email folder.', 'pw-net-auto-cancel' ),
                'id'      => 'pw_net_auto_cancel_email_template_info',
                'type'    => 'title',
            ],
            [
                'title'   => __( 'Cancel Orders in These Statuses', 'pw-net-auto-cancel' ),
                'desc'    => __( 'Select which order statuses should be auto-cancelled after the set time.', 'pw-net-auto-cancel' ),
                'id'      => 'pw_net_auto_cancel_statuses',
                'type'    => 'pw_net_auto_cancel_statuses',
                'default' => [ 'pending', 'on-hold' ],
            ],
            [
                'type' => 'sectionend',
                'id'   => 'pw_net_auto_cancel_settings_section',
            ],
        ];

        return apply_filters( 'pw_net_auto_cancel_settings', $settings );
    }

    public function pw_net_render_statuses_field( $value ) {
        $statuses       = wc_get_order_statuses();
        $selected       = get_option( $value['id'], [] );
        $field_id       = esc_attr( $value['id'] );
        $field_desc     = ! empty( $value['desc'] ) ? '<p class="description">' . esc_html( $value['desc'] ) . '</p>' : '';
        
        echo '<tr valign="top">';
        echo '<th scope="row" class="titledesc">';
        echo '<label for="' . $field_id . '">' . esc_html( $value['title'] ) . '</label>';
        echo '</th>';
        echo '<td class="forminp">';
        
        foreach ( $statuses as $status_key => $status_label ) {
            $is_checked = in_array( $status_key, $selected, true ) ? 'checked="checked"' : '';
            echo '<label><input type="checkbox" name="' . $field_id . '[]" value="' . esc_attr( $status_key ) . '" ' . $is_checked . ' /> ' . esc_html( $status_label ) . '</label><br />';
        }
        
        echo $field_desc;
        echo '</td>';
        echo '</tr>';
    }


}
