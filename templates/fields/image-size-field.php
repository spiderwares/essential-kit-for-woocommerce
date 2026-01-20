<?php
/**
 *  Image Size Field Template
 */

// Prevent direct access to the file.
defined( 'ABSPATH' ) || exit; ?>

<td>
    <div class="ekwc-size-field">
        <label for="<?php echo esc_attr( $field_Key ); ?>_width">
            <div><b><?php esc_html_e('Width', 'essential-kit-for-woocommerce'); ?></b></div>
        
            <input type="number" 
                id="<?php echo esc_attr( $field_Key ); ?>_width" 
                name="<?php echo isset( $field['name'] ) ? esc_attr( $field['name'] . '[width]' ) : ''; ?>" 
                value="<?php echo isset( $field_Val['width'] ) ? esc_attr( $field_Val['width'] ) : ''; ?>" 
                placeholder="<?php echo isset( $field['placeholder_width'] ) ? esc_attr( $field['placeholder_width'] ) : 'Width'; ?>" 
                min="0" 
                step="1" />
        </label>

        <label for="<?php echo esc_attr( $field_Key ); ?>_height">
            <div><b><?php esc_html_e('Height', 'essential-kit-for-woocommerce'); ?></b></div>
        
            <input type="number" 
                id="<?php echo esc_attr( $field_Key ); ?>_height" 
                name="<?php echo isset( $field['name'] ) ? esc_attr( $field['name'] . '[height]' ) : ''; ?>" 
                value="<?php echo isset( $field_Val['height'] ) ? esc_attr( $field_Val['height'] ) : ''; ?>" 
                placeholder="<?php echo isset( $field['placeholder_height'] ) ? esc_attr( $field['placeholder_height'] ) : 'Height'; ?>" 
                min="0" 
                step="1" />
        </label>
    </div>
    <small><?php echo isset( $field['desc'] ) ? wp_kses_post( $field['desc'] ) : ''; ?></small>
</td>

