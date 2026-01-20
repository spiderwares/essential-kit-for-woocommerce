<?php
if ( ! defined( 'ABSPATH' ) ) :
    exit; // Exit if accessed directly.
endif;

if(empty($wishlists)):
    echo sprintf( '<p>%s</p>', esc_html__( 'No wishlist found.', 'essential-kit-for-woocommerce' ) );
else: ?>
<div class="ekwc-flex">
    <h3><?php echo esc_html( $setting['wishlist_table_title']); ?></h3>
</div>
<table class="ekwc-wishlist-table">
    <thead>
        <tr>    
            <th><?php esc_html_e( 'Wishlists', 'essential-kit-for-woocommerce' ); ?></th>
            <th><?php esc_html_e( 'Privacy', 'essential-kit-for-woocommerce' ); ?></th>
            <th><?php esc_html_e( 'Count of items', 'essential-kit-for-woocommerce' ); ?></th>
            <th><?php esc_html_e( 'Created on', 'essential-kit-for-woocommerce' ); ?></th>
            
            <?php do_action( 'ekwc_wishlist_table_th_pdf_download' ); ?>
            
            <th><?php esc_html_e( 'Delete', 'essential-kit-for-woocommerce' ); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ( $wishlists as $wishlist ) : ?>
            <?php $wishlist_items = ekwc_get_wishlist_items_with_count( $wishlist['ID'] ); ?>
            <tr class="ekwc-wishlist-row">
                <?php 
                $wishlist_page_id  = get_option( 'ekwc_wishlist_page_id' );
                $wishlist_page_url = $wishlist_page_id ? get_permalink( $wishlist_page_id ) : home_url();
                ?>

                <td>
                    <a href="<?php echo esc_url( add_query_arg( array( 
                        'view'    => $wishlist['wishlist_token'], 
                        '_wpnonce' => wp_create_nonce( 'ekwc_view_wishlist' ) 
                    ), $wishlist_page_url ) ); ?>">
                        <?php echo esc_html( $wishlist['wishlist_name'] ); ?>
                    </a>
                </td>
                <td class="ekwc-center"><?php $privacy_label = ( $wishlist['wishlist_privacy'] == 0 ) ? esc_html__( 'Public', 'essential-kit-for-woocommerce' ) : esc_html__( 'Private', 'essential-kit-for-woocommerce' ); echo esc_html( $privacy_label ); ?></td>
                <td class="ekwc-center"><?php echo esc_html( $wishlist_items['count'] ); ?></td>
                <td class="ekwc-center"><?php $date = new DateTime($wishlist['dateadded']); 
                        echo esc_html($date->format('F j, Y')); ?>
                </td>

                <?php do_action( 'ekwc_wishlist_table_td_pdf_download', $wishlist ); ?>

                <td class="ekwc-center">
                    <div href="#" class="ekwc-delete-wishlist" title="<?php esc_html_e( 'Delete Wishlist', 'essential-kit-for-woocommerce' ); ?>" data-wishlist-id="<?php echo esc_attr( $wishlist['ID'] ); ?>">
                        <svg width="26px" height="26px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14 11V17" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 7H20" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>