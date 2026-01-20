<?php
/**
 * Display Size Chart Template
 *
 * @var int $post_id
 */

if ( ! defined( 'ABSPATH' ) ) :
    exit;
endif; ?>

<?php if ( ! empty( $top_description ) ) : ?>
    <div class="ekwc-top-desc"><?php echo wp_kses_post( wpautop( $top_description ) ); ?></div>
<?php endif; ?>

<?php if ( ! empty( $table_data ) && is_array( $table_data ) ) : ?>
    <table class="ekwc-size-chart-table">
        <?php foreach ( $table_data as $row_index => $row ) : ?>
            <tr>
                <?php foreach ( $row as $cell ) :
                    $tag       = ( $row_index === 0 ) ? 'th' : 'td';
                    $row_style = ( $row_index === 0 ) ? $style['heading'] : ( $row_index % 2 === 0 ? $style['even'] : $style['odd'] );
                    ?>
                    <<?php echo esc_html( $tag ); ?> style="background-color:<?php echo esc_attr( $row_style['bgcolor'] ); ?>; color:<?php echo esc_attr( $row_style['color'] ); ?>;">
                        <?php echo esc_html( $cell ); ?>
                    </<?php echo esc_html( $tag ); ?>>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php if ( ! empty( $bottom_notes ) ) : ?>
    <div class="ekwc-bottom-notes"><?php echo wp_kses_post( wpautop( $bottom_notes ) ); ?></div>
<?php endif; ?>