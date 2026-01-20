<?php
// Ensure that the script is being accessed within WordPress
if ( ! defined( 'ABSPATH' ) ) :
    exit; // Exit if accessed directly
endif;
?>

<div class="ekwc_admin_page ekwc_welcome_page wrap ekwc_admin_settings_page">

    <div class="card">
    <!-- Display the plugin title and version -->
        <h1 class="title">
            <?php 
            // Output the plugin title, version, and premium label (if applicable).
            echo esc_html__( 'Essential Kit For WooCommerce', 'essential-kit-for-woocommerce' ) . ' ' . esc_html( EKWC_VERSION ) ; 
            ?>
        </h1>

        <!-- Plugin description and external links -->
        <div class="ekwc_settings_page_desc about-text">
            <p>
                <?php 
                // Translators: %s is replaced with a five-star rating HTML.
                printf( 
                    esc_html__( 'Thank you for choosing our plugin! If you’re happy with its performance, we’d be grateful if you could give us a five-star %s rating. Your support helps us improve and deliver even better features.', 'essential-kit-for-woocommerce' ), 
                    '<span style="color:#ff0000">&#9733;&#9733;&#9733;&#9733;&#9733;</span>' 
                );
                ?>
                <br/>
                <!-- Add links to reviews, changelog, and discussion pages -->
                <a href="<?php echo esc_url( EKWC_REVIEWS ); ?>" target="_blank"><?php esc_html_e( 'Reviews', 'essential-kit-for-woocommerce' ); ?></a> |
                <a href="<?php echo esc_url( EKWC_CHANGELOG ); ?>" target="_blank"><?php esc_html_e( 'Changelog', 'essential-kit-for-woocommerce' ); ?></a> |
                <a href="<?php echo esc_url( EKWC_DISCUSSION ); ?>" target="_blank"><?php esc_html_e( 'Discussion', 'essential-kit-for-woocommerce' ); ?></a>
            </p>
        </div>
    </div>
    
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
