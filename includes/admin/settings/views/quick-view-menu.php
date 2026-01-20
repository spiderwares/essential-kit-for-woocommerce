<?php defined( 'ABSPATH' ) || exit; ?>
<div class="ekwc_admin_page ekwc_admin_settings_page wrap">

    <!-- Navigation tabs for plugin settings -->
    <div class="ekwc_admin_settings_page_nav">
        <h2 class="nav-tab-wrapper">
            <!-- General settings tab -->
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=ekwc-quick-view&tab=general' ) ); ?>" 
               class="<?php echo esc_attr( $active_tab === 'general' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( EKWC_URL . 'assets/img/setting.svg'); ?>" />
                <?php esc_html_e( 'General', 'essential-kit-for-woocommerce' ); ?>
            </a>

            <!-- Display settings tab -->
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=ekwc-quick-view&tab=style' ) ); ?>" 
               class="<?php echo esc_attr( $active_tab === 'style' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( EKWC_URL . 'assets/img/style.svg'); ?>" />
                <?php esc_html_e( 'Style', 'essential-kit-for-woocommerce' ); ?>
            </a>

            <!-- Premium version tab, visible only if not in the premium version -->
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=ekwc-quick-view&tab=premium' ) ); ?>" 
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
        require_once EKWC_PATH . 'includes/admin/settings/views/quick-view/admin-settings.php';
        require_once EKWC_PATH . 'includes/admin/settings/views/quick-view/' . $active_tab . '.php';
        ?>
    </div>
</div>