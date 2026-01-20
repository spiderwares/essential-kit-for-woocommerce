<?php
defined( 'ABSPATH' ) || exit; ?>

<label><?php esc_html_e( 'Assign', 'essential-kit-for-woocommerce' ); ?></label>
<div>
    <div class="ekwc_assign_wrap">
        <select name="ekwc_assign" id="ekwc_assign" class="ekwc_assign" data-hide=".ekwc_assign_option">
            <?php foreach ( $assign_options as $key => $val ) : ?>
                <option value="<?php echo esc_attr( $key ); ?>"
                        data-show=".<?php echo esc_attr( $key ); ?>"
                    <?php selected( $key === $ekwc_assign ); ?>
                    <?php $disabled_keys = apply_filters( 'ekwc_disabled_assign_options', [ 'combined', 'product_type', 'product_visibility', 'product_tag', 'shipping_class' ] );
                        disabled( in_array( $key, $disabled_keys, true ) ); ?>>
                    <?php echo esc_html( $val ); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Products Pane -->
        <div class="ekwc_assign_option products ekwc_assign_pane"
            style="<?php echo esc_attr( ( isset( $ekwc_assign ) && $ekwc_assign == 'products' ) ? '' : 'display: none;' ); ?>"
            data-option="products">
            <select id="ekwc_assign_products" name="ekwc_assign_products[]"
                class="wc-product-search"
                multiple="multiple"
                data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'jewellery-price-breakup-for-woocommerce' ); ?>"
                data-action="woocommerce_json_search_products"
                data-include_variations="false">
                <?php
                if ( 'products' === $ekwc_assign ) :
                    foreach ( $ekwc_condition as $val ) :
                        $parts = explode( ':', $val );
                        if ( count( $parts ) >= 2 && $parts[0] === 'products' ) :
                            $product_id = absint( $parts[1] );
                            $product    = wc_get_product( $product_id );
                            if ( $product && $product->get_type() !== 'variation' ) :
                                ?>
                                <option value="<?php echo esc_attr( $product_id ); ?>" selected="selected">
                                    <?php echo esc_html( $product->get_name() ); ?>
                                </option>
                                <?php
                            endif;
                        endif;
                    endforeach;
                endif;
                ?>
            </select>
        </div>

        <!-- Product Category Pane -->
        <div class="ekwc_assign_option product_cat ekwc_assign_pane"
            style="<?php echo esc_attr( ( isset( $ekwc_assign ) && $ekwc_assign == 'product_cat' ) ? '' : 'display: none;' ); ?>"
            data-option="product_cat">
            <label for="ekwc_assign_product_cat"><?php esc_html_e( 'Product Categories', 'essential-kit-for-woocommerce' ); ?></label>
            <select id="ekwc_assign_product_cat" name="ekwc_assign_product_cat[]"
                class="wc-enhanced-select"
                multiple="multiple"
                data-placeholder="<?php esc_attr_e( 'Select categories&hellip;', 'essential-kit-for-woocommerce' ); ?>">
                <option value=""></option>
                <?php
                // Get all product categories
                $terms = get_terms( [
                    'taxonomy'   => 'product_cat',
                    'hide_empty' => false,
                ] );

                $selected_terms = [];

                if ( 'product_cat' === $ekwc_assign ) :
                    foreach ( $ekwc_condition as $val ) :
                        $parts = explode( ':', $val );
                        if ( count( $parts ) >= 2 && $parts[0] === 'product_cat' ) :
                            $selected_terms[] = absint( $parts[1] );
                        endif;
                    endforeach;
                endif;

                // Render all categories
                foreach ( $terms as $term ) :
                    $selected = in_array( $term->term_id, $selected_terms, true ) ? 'selected="selected"' : '';
                    echo '<option value="' . esc_attr( $term->term_id ) . '" ' . $selected . '>' . esc_html( $term->name ) . '</option>';
                endforeach;
                ?>
            </select>

        </div>

        <?php do_action( 'ekwc_assign_additional_fields', $ekwc_assign, $ekwc_condition ); ?>

    </div>
</div>
