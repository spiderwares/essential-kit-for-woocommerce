<?php
// Prevent direct access to the file.
defined( 'ABSPATH' ) || exit; ?>

<div class="ekwc-compare-container">
    <div class="ekwc-controls">
        <h2 class="ekwc-subHeading"><?php echo esc_html( $table_title ); ?></h2>
        <div class="ekwc-filter-reset">
            <div class="ekwc_filter_btn_wrapper">
                <?php echo apply_filters( 'ekwc_compare_after_filter_btn', '' ); ?>
            </div>
        </div>
    </div>
    <div class="ekwc-copy-wrapper"><?php echo wp_kses_post( apply_filters('ekwc_after_compare_title', '', $products ) ); ?></div>
    <div class="ekwc-table-container">
    <div class="ekwc-scrollable-table">
    <?php ob_start(); ?>
        <table class="ekwc-comparison-table ekwc-vertical-table style-1">
            <thead>
                <tr>
                    <td class="ekwc-info"></td>
                    <?php foreach ($products as $product) : ?>
                        <th>
                            <div class="ekwc-compare-product">
                            <input type="checkbox" class="ekwc-check" />
                            <?php if ( isset($ekwc_compare_table['show_image'] ) && $ekwc_compare_table['show_image'] === 'yes' ) : ?>
                                <img class="ekwc-compare-img" src="<?php echo esc_url($product['image']); ?>" alt="<?php echo esc_attr($product['title']); ?>">
                            <?php endif; ?>
                            <?php if( isset($ekwc_compare_table['show_title'] ) && $ekwc_compare_table['show_title'] === 'yes' ): ?>
                                <h3 class="ekwc-name"><?php echo esc_html($product['title']); ?></h3>
                            <?php endif; ?>
                            </div>
                        </th>
                    <?php endforeach; ?>
                </tr>
            </thead>

            <tbody>
                <?php if( isset($ekwc_compare_table['show_price']) && $ekwc_compare_table['show_price'] === 'yes' ): ?>
                    <tr>
                        <td class="ekwc-info"><i class="fas fa-long-arrow-alt-right"></i><?php esc_html_e( 'Price', 'essential-kit-for-woocommerce' ); ?></td>
                        <?php foreach ($products as $product) : ?>
                            <td><?php echo wp_kses_post($product['price']); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>

                <?php if( isset($ekwc_compare_table['show_rating'] ) && $ekwc_compare_table['show_rating'] === 'yes' ): ?>
                    <tr>
                        <td class="ekwc-info"><i class="fas fa-long-arrow-alt-right"></i><?php esc_html_e( 'Rating', 'essential-kit-for-woocommerce' ); ?></td>
                        <?php foreach ($products as $product) : ?>
                            <td class="ekwc-rate"><?php echo wp_kses_post($product['rating']); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>

                <?php if( isset($ekwc_compare_table['show_description'] ) && $ekwc_compare_table['show_description'] === 'yes' ): ?>
                    <tr>
                        <td class="ekwc-info"><i class="fas fa-long-arrow-alt-right"></i><?php esc_html_e( 'Description', 'essential-kit-for-woocommerce' ); ?></td>
                        <?php foreach ($products as $product) : ?>
                            <td><p class="ekwc-description"><?php echo esc_html($product['description']); ?></p></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>


                <?php if( isset($ekwc_compare_table['show_sku'] ) && $ekwc_compare_table['show_sku'] === 'yes' ): ?>
                    <tr>
                        <td class="ekwc-info"><i class="fas fa-long-arrow-alt-right"></i><?php esc_html_e( 'SKU', 'essential-kit-for-woocommerce' ); ?></td>
                        <?php foreach ($products as $product) : ?>
                            <td><?php echo esc_html($product['sku']); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>


                <?php if( isset($ekwc_compare_table['show_availability'] ) && $ekwc_compare_table['show_availability'] === 'yes' ): ?>
                    <tr>
                        <td class="ekwc-info"><i class="fas fa-long-arrow-alt-right"></i><?php esc_html_e( 'Availability', 'essential-kit-for-woocommerce' ); ?></td>
                        <?php foreach ($products as $product) : ?>
                            <td><?php echo esc_html($product['availability']); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>


                <?php if( isset($ekwc_compare_table['show_weight'] ) && $ekwc_compare_table['show_weight'] === 'yes' ): ?>
                    <tr>
                        <td class="ekwc-info"><i class="fas fa-long-arrow-alt-right"></i><?php esc_html_e( 'Weight', 'essential-kit-for-woocommerce' ); ?></td>
                        <?php foreach ($products as $product) : ?>
                            <td><?php echo esc_html($product['weight']); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>


                <?php if( isset($ekwc_compare_table['show_dimensions'] ) && $ekwc_compare_table['show_dimensions'] === 'yes' ): ?>
                    <tr>
                        <td class="ekwc-info"><i class="fas fa-long-arrow-alt-right"></i><?php esc_html_e( 'Dimensions', 'essential-kit-for-woocommerce' ); ?></td>
                        <?php foreach ($products as $product) : ?>
                            <td><?php echo esc_html($product['dimensions']); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>


                <?php if ( ! empty( $products ) && isset( $products[0]['attr'] ) && is_array( $products[0]['attr'] ) ) : ?>
                    <?php foreach ($products[0]['attr'] as $attr_key => $attr_data) : ?>
                        <tr>
                            <td class="ekwc-info">
                                <i class="fas fa-long-arrow-alt-right"></i> 
                                <?php echo esc_html($attr_data['name'] ); ?>
                            </td>
                            <?php foreach ($products as $product) : ?>
                                <td>
                                <?php if ( isset( $product['attr'][$attr_key]['value'] ) && ! empty( $product['attr'][$attr_key]['value'] ) ) :
                                    echo esc_html( $product['attr'][$attr_key]['value'] );
                                endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php echo wp_kses_post( apply_filters( 'ekwc_custom_meta_rows', '', $products ) ); ?>

                <?php if( isset($ekwc_compare_table['show_add_to_cart'] ) && $ekwc_compare_table['show_add_to_cart'] === 'yes' ): ?>
                    <tr>
                        <td class="ekwc-info"><i class="fas fa-long-arrow-alt-right"></i><?php esc_html_e( 'Add To Cart', 'essential-kit-for-woocommerce' ); ?></td>
                        <?php foreach ($products as $product) : ?>
                            <td  class="ekwc-compare-add-to-cart"><?php echo wp_kses_post( $product['add_to_cart'] ); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endif; ?>

                <tr class="ekwc-remove">
                    <td class="ekwc-info"></td>
                    <?php $remove_text = isset($ekwc_compare_genral['remove_btn_text']) && $ekwc_compare_genral['remove_btn_text'] ? $ekwc_compare_genral['remove_btn_text'] : 'Remove'; ?>
                    <?php foreach ($products as $product) : ?>
                        <td>
                            <button class="ekwc-remove-compare" data-product_id="<?php echo esc_attr($product['id']); ?>"><?php echo esc_html($remove_text); ?></button>
                        </td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
        <?php $table_html = ob_get_clean(); ?>
        <?php $table_html = apply_filters('ekwc_comparison_table_html', $table_html, $products, $ekwc_compare_genral, $ekwc_compare_style, $ekwc_compare_table); ?>
        <?php echo wp_kses_post($table_html); ?>
    </div>
    </div>
</div>