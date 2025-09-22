<?php
// Ensure that the script is being accessed within WordPress
if ( ! defined( 'ABSPATH' ) ) :
    exit; // Exit if accessed directly
endif;
?>

<div class="ekwc_admin_page ekwc_welcome_page wrap ekwc_admin_settings_page">

    <h2 class="ekwc_empty"></h2>
    
    <div class="ekwc_admin_settings_page_nav">
        <h2 class="nav-tab-wrapper">
            <?php $nonce = wp_create_nonce( 'ekwc_admin_nonce' ); ?>
            <!-- General settings tab -->
            <a href="<?php echo esc_url( add_query_arg( '_wpnonce', $nonce, admin_url( 'admin.php?page=essential_kit&tab=general' ) ) ); ?>" 
                class="<?php echo esc_attr( $active_tab === 'general' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( EKWC_URL . 'assets/img/setting.svg'); ?>" />
                <?php esc_html_e( 'General', 'essential-kit-for-woocommerce' ); ?>
            </a>

            <!-- Table settings tab -->
            <a href="<?php echo esc_url( add_query_arg( '_wpnonce', $nonce, admin_url( 'admin.php?page=essential_kit&tab=style' ) ) ); ?>" 
                class="<?php echo esc_attr( $active_tab === 'style' ? 'nav-tab nav-tab-active' : 'nav-tab' ); ?>">
                <img src="<?php echo esc_url( EKWC_URL . 'assets/img/style.svg'); ?>" />
                <?php esc_html_e( 'Style', 'essential-kit-for-woocommerce' ); ?>
            </a>

        </h2>
    </div>

    <!-- Content area for the active settings tab -->
    <div class="ekwc_admin_settings_page_content">
        <?php
        // Load the content for the currently active tab dynamically.
        require_once EKWC_PATH . 'includes/admin/dashboard/views/about.php';
        require_once EKWC_PATH . 'includes/admin/dashboard/views/' . $active_tab . '.php';
        ?>
    </div>

</div>
