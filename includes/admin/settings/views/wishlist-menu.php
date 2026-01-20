<?php 
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>
<div class="ekwc_admin_page ekwc_admin_settings_page wrap">

    <!-- Navigation tabs for plugin settings -->
    <div class="ekwc_admin_settings_page_nav">
        <h2 class="nav-tab-wrapper">

            <!-- General settings tab -->
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=ekwc-wishlist&tab=general' ) ); ?>" 
               class="<?php echo esc_attr( $active_tab === 'general' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( EKWC_URL . 'assets/img/setting.svg'); ?>" />
                <?php esc_html_e( 'General', 'essential-kit-for-woocommerce' ); ?>
            </a>

            <!-- Display settings tab -->
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=ekwc-wishlist&tab=wishlist_page' ) ); ?>" 
               class="<?php echo esc_attr( $active_tab === 'wishlist_page' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( EKWC_URL . 'assets/img/page.svg'); ?>" />
                <?php esc_html_e( 'Wishlist Page', 'essential-kit-for-woocommerce' ); ?>
            </a>

            <!-- Design settings tab -->
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=ekwc-wishlist&tab=style' ) ); ?>" 
               class="<?php echo esc_attr( $active_tab === 'style' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( EKWC_URL . 'assets/img/style.svg'); ?>" />
                <?php esc_html_e( 'Style', 'essential-kit-for-woocommerce' ); ?>
            </a>

            <!-- Localization settings tab -->
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=ekwc-wishlist&tab=localization' ) ); ?>" 
               class="<?php echo esc_attr( $active_tab === 'localization' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( EKWC_URL . 'assets/img/localization.svg'); ?>" />
                <?php esc_html_e( 'Localization', 'essential-kit-for-woocommerce' ); ?>
            </a>

        </h2>
    </div>

    <!-- Content area for the active settings tab -->
    <div class="ekwc_admin_settings_page_content">
        <?php
        require_once EKWC_PATH . 'includes/admin/settings/views/wishlist/admin-settings.php';
        // Load the content for the currently active tab dynamically.
        require_once EKWC_PATH . 'includes/admin/settings/views/wishlist/' . $active_tab . '.php';
        ?>
    </div>
</div>
