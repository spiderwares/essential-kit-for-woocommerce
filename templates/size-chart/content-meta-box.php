<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit; ?>

<div class="ekwc-size-chart-config">

    <!-- Top Description Editor -->
    <div class="ekwc-section">
        <h4><?php esc_html_e( 'Top Description', 'essential-kit-for-woocommerce' ); ?></h4>
        <div class="ekwc-editor-wrapper">
            <?php
            wp_editor( $top_description, 'ekwc_top_description', [
                'textarea_name' => 'ekwc_top_description',
                'textarea_rows' => 8,
                'editor_class'  => 'ekwc-wp-editor',
            ] );
            ?>
        </div>
    </div>

    <!-- Chart Table Builder -->
    <div class="ekwc-section">
        <h4><?php esc_html_e( 'Chart Table', 'essential-kit-for-woocommerce' ); ?></h4>
        <input type="hidden" name="ekwc_table_data" id="ekwc_table_data" value='<?php echo esc_attr( json_encode( $table_data_arr ) ); ?>' />
        <div class="ekwc-table-container">
            <table class="ekwc-table-form">
                <thead>
                    <tr>
                        <th><?php esc_html_e( 'Actions', 'essential-kit-for-woocommerce' ); ?></th>
                        <?php if ( !empty( $table_data_arr[0] ) ) : ?>
                            <?php foreach ( $table_data_arr[0] as $col_index => $col_val ) : ?>
                                <th>
                                    <div class="ekwc-col-actions">
                                        <button type="button" class="button ekwc-add-col"><?php esc_html_e( 'Add', 'essential-kit-for-woocommerce' ); ?></button>
                                        <button type="button" class="button ekwc-remove-col"><?php esc_html_e( 'Remove', 'essential-kit-for-woocommerce' ); ?></button>
                                    </div>
                                </th>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $table_data_arr as $row_index => $row ) : ?>
                        <tr>
                            <td>
                                <div class="ekwc-row-actions">
                                    <button type="button" class="button ekwc-add-row"><?php esc_html_e( 'Add', 'essential-kit-for-woocommerce' ); ?></button>
                                    <button type="button" class="button ekwc-remove-row"><?php esc_html_e( 'Remove', 'essential-kit-for-woocommerce' ); ?></button>
                                </div>
                            </td>
                            <?php foreach ( $row as $cell ) : ?>
                                <td>
                                    <input type="text" name="ekwc_table_cell[]" class="ekwc-cell-input" value="<?php echo esc_attr( $cell ); ?>" />
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bottom Notes Editor -->
    <div class="ekwc-section">
        <h4><?php esc_html_e( 'Bottom Notes', 'essential-kit-for-woocommerce' ); ?></h4>
        <div class="ekwc-editor-wrapper">
            <?php
            wp_editor( $bottom_notes, 'ekwc_bottom_notes', [
                'textarea_name' => 'ekwc_bottom_notes',
                'textarea_rows' => 8,
                'editor_class'  => 'ekwc-wp-editor',
            ] );
            ?>
        </div>
    </div>

</div>