<?php 
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>
<div class="ekwc_admin_page ekwc_admin_settings_page wrap">

    <!-- Navigation tabs for plugin settings -->
    <div class="ekwc_admin_settings_page_nav">
        <h2 class="nav-tab-wrapper">
            <?php $nonce = wp_create_nonce( 'ekwc_admin_nonce' ); ?>
            <!-- General settings tab -->
            <a href="<?php echo esc_url( add_query_arg( '_wpnonce', $nonce, admin_url( 'admin.php?page=ekwc-product-compare&tab=general' ) ) ); ?>" 
                class="<?php echo esc_attr( $active_tab === 'general' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( EKWC_URL . 'assets/img/setting.svg'); ?>" />
                <?php esc_html_e( 'General', 'essential-kit-for-woocommerce' ); ?>
            </a>

            <!-- Table settings tab -->
            <a href="<?php echo esc_url( add_query_arg( '_wpnonce', $nonce, admin_url( 'admin.php?page=ekwc-product-compare&tab=table' ) ) ); ?>" 
                class="<?php echo esc_attr( $active_tab === 'table' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( EKWC_URL . 'assets/img/table.svg'); ?>" />
                <?php esc_html_e( 'Compare Table', 'essential-kit-for-woocommerce' ); ?>
            </a>

            <!-- Style settings tab -->
            <a href="<?php echo esc_url( add_query_arg( '_wpnonce', $nonce, admin_url( 'admin.php?page=ekwc-product-compare&tab=style' ) ) ); ?>" 
                class="<?php echo esc_attr( $active_tab === 'style' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( EKWC_URL . 'assets/img/style.svg'); ?>" />
                <?php esc_html_e( 'Style', 'essential-kit-for-woocommerce' ); ?>
            </a>

            <!-- Premium version tab, visible only if not in the premium version -->
            <a href="<?php echo esc_url( add_query_arg( '_wpnonce', $nonce, admin_url( 'admin.php?page=ekwc-product-compare&tab=premium' ) ) ); ?>" 
                class="<?php echo esc_attr( $active_tab === 'premium' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>" 
                style="color: #c9356e;">
                <img src="<?php echo esc_url( EKWC_URL . 'assets/img/premium.svg'); ?>" />
                <?php esc_html_e( 'Premium Features', 'essential-kit-for-woocommerce' ); ?>
            </a>
        </h2>
    </div>

    <!-- Content area for the active settings tab -->
    <div class="ekwc_admin_settings_page_content">
        <?php
        require_once EKWC_PATH . 'includes/admin/settings/views/product-compare/admin-settings.php';
        // Load the content for the currently active tab dynamically.
        require_once EKWC_PATH . 'includes/admin/settings/views/product-compare/' . $active_tab . '.php';
        ?>
    </div>
</div>
