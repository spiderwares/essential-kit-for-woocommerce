<?php 
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>
<div class="ekwc_admin_page ekwc_admin_settings_page wrap">

    <!-- Navigation tabs for plugin settings -->
    <div class="ekwc_admin_settings_page_nav">
        <h2 class="nav-tab-wrapper">
            <!-- General settings tab -->
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=ekwc-free-shipping-bar&tab=general' ) ); ?>" 
               class="<?php echo esc_attr( $active_tab === 'general' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( EKWC_URL . 'assets/img/setting.svg'); ?>" />
                <?php esc_html_e( 'General', 'essential-kit-for-woocommerce' ); ?>
            </a>

            <!-- Display settings tab -->
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=ekwc-free-shipping-bar&tab=position' ) ); ?>" 
               class="<?php echo esc_attr( $active_tab === 'position' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( EKWC_URL . 'assets/img/position.svg'); ?>" />
                <?php esc_html_e( 'Shipping Bar', 'essential-kit-for-woocommerce' ); ?>
            </a>

            <!-- Style settings tab -->
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=ekwc-free-shipping-bar&tab=style' ) ); ?>" 
               class="<?php echo esc_attr( $active_tab === 'style' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( EKWC_URL . 'assets/img/style.svg'); ?>" />
                <?php esc_html_e( 'Style', 'essential-kit-for-woocommerce' ); ?>
            </a>

            <!-- Notifications settings tab -->
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=ekwc-free-shipping-bar&tab=notificatons' ) ); ?>" 
            class="<?php echo esc_attr( $active_tab === 'notificatons' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( EKWC_URL . 'assets/img/notification.svg'); ?>" />
                <?php esc_html_e( 'Notifications', 'essential-kit-for-woocommerce' ); ?>
            </a>

            <!-- Effect settings tab -->
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=ekwc-free-shipping-bar&tab=effect' ) ); ?>" 
            class="<?php echo esc_attr( $active_tab === 'effect' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( EKWC_URL . 'assets/img/effect.svg'); ?>" />
                <?php esc_html_e( 'Effect', 'essential-kit-for-woocommerce' ); ?>
            </a>

            <!-- Display Rules settings tab -->
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=ekwc-free-shipping-bar&tab=display_rules' ) ); ?>" 
            class="<?php echo esc_attr( $active_tab === 'display_rules' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( EKWC_URL . 'assets/img/display.svg'); ?>" />
                <?php esc_html_e( 'Display Rules', 'essential-kit-for-woocommerce' ); ?>
            </a>
        </h2>
    </div>

    <!-- Content area for the active settings tab -->
    <div class="ekwc_admin_settings_page_content">
        <?php
        require_once EKWC_PATH . 'includes/admin/settings/views/free-shipping-bar/admin-settings.php';
        // Load the content for the currently active tab dynamically.
        require_once EKWC_PATH . 'includes/admin/settings/views/free-shipping-bar/' . $active_tab . '.php';
        ?>
    </div>
</div>
