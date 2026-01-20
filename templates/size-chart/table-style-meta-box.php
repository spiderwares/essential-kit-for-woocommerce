<table class="form-table ekwc-size-chart-styles">
    <tr>
        <th scope="row"><?php esc_html_e( 'Header Colors', 'essential-kit-for-woocommerce' ); ?></th>
        <td>
            <div class="ekwc-color-picker-row">
                <div class="ekwc-size-color-wrapper">
                    <label><?php esc_html_e( 'Background Color', 'essential-kit-for-woocommerce' ); ?></label>
                    <input type="text" class="ekwc-color-picker" name="ekwc_size_chart_style[heading][bgcolor]" value="<?php echo esc_attr( $heading_bgcolor ?? '#e0f2fe' ); ?>" />
                </div>
                <div class="ekwc-size-color-wrapper">
                    <label><?php esc_html_e( 'Text Color', 'essential-kit-for-woocommerce' ); ?></label>
                    <input type="text" class="ekwc-color-picker" name="ekwc_size_chart_style[heading][color]" value="<?php echo esc_attr( $heading_color ?? '#111827' ); ?>" />
                </div>
            </div>
        </td>
    </tr>

    <tr>
        <th scope="row"><?php esc_html_e( 'Odd Row Colors', 'essential-kit-for-woocommerce' ); ?></th>
        <td>
            <div class="ekwc-color-picker-row">
                <div class="ekwc-size-color-wrapper">
                    <label><?php esc_html_e( 'Background Color', 'essential-kit-for-woocommerce' ); ?></label>
                    <input type="text" class="ekwc-color-picker" name="ekwc_size_chart_style[odd][bgcolor]" value="<?php echo esc_attr( $odd_row_bgcolor ?? '#ffffff' ); ?>" />
                </div>
                <div class="ekwc-size-color-wrapper">
                    <label><?php esc_html_e( 'Text Color', 'essential-kit-for-woocommerce' ); ?></label>
                    <input type="text" class="ekwc-color-picker" name="ekwc_size_chart_style[odd][color]" value="<?php echo esc_attr( $odd_row_color ?? '#374151' ); ?>" />
                </div>
            </div>
        </td>
    </tr>

    <tr>
        <th scope="row"><?php esc_html_e( 'Even Row Colors', 'essential-kit-for-woocommerce' ); ?></th>
        <td>
            <div class="ekwc-color-picker-row">
                <div class="ekwc-size-color-wrapper">
                    <label><?php esc_html_e( 'Background Color', 'essential-kit-for-woocommerce' ); ?></label>
                    <input type="text" class="ekwc-color-picker" name="ekwc_size_chart_style[even][bgcolor]" value="<?php echo esc_attr( $even_row_bgcolor ?? '#f7f9fc' ); ?>" />
                </div>
                <div class="ekwc-size-color-wrapper">
                    <label><?php esc_html_e( 'Text Color', 'essential-kit-for-woocommerce' ); ?></label>
                    <input type="text" class="ekwc-color-picker" name="ekwc_size_chart_style[even][color]" value="<?php echo esc_attr( $even_row_color ?? '#111827' ); ?>" />
                </div>
            </div>
        </td>
    </tr>
</table>
