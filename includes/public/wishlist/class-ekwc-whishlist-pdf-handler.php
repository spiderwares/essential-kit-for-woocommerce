<?php
// Prevent direct access to the file.
defined( 'ABSPATH' ) || exit; 

// Include the Dompdf library using Composer's autoload.
require_once EKWC_PATH . 'vendor/autoload.php'; // Load Dompdf

use Dompdf\Dompdf;
use Dompdf\Options;

if ( ! class_exists( 'EKWC_Wishlist_PDF_Handler' ) ) : 

    /**
     * EKWC_Wishlist_PDF_Handler Class
     *
     * Handles the wishlist PDF generation logic.
     */
    class EKWC_Wishlist_PDF_Handler {

        /**
         * Constructor to initialize event handlers.
         */
        public function __construct() {
            $this->event_handler(); // Set up the event handlers.
        }

        /**
         * Registers actions for generating the wishlist PDF via AJAX.
         */
        public function event_handler() { 
            add_action( 'wp_ajax_ekwc_generate_wishlist_pdf', array( $this, 'generate_wishlist_pdf' ) );
            add_action( 'wp_ajax_nopriv_ekwc_generate_wishlist_pdf', array( $this, 'generate_wishlist_pdf' ) );
        }

        /**
         * Handles the generation of the wishlist PDF.
         */
        public function generate_wishlist_pdf() {

            // Verify nonce for security to prevent CSRF attacks.
            if ( ! isset( $_POST['ekwc_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ekwc_nonce'] ) ), 'ekwc_nonce' ) ) :
                wp_send_json_error( 'Nonce verification failed.' );
                exit;
            endif;

            // Ensure that wishlist_id is provided.
            if ( ! isset( $_POST['wishlist_id'] ) ) :
                wp_send_json_error( [ 'message' => 'Wishlist ID is missing' ] );
                exit;
            endif;
        
            $wishlist_id    = intval( $_POST['wishlist_id'] );
            $wishlist_items = ekwc_get_wishlist_items_with_count( $wishlist_id );

            // Check if the wishlist items are empty or not available.
            if ( empty( $wishlist_items ) || empty( $wishlist_items['items'] ) ) :
                wp_send_json_error( [ 'message' => 'Wishlist is empty' ] );
                exit;
            endif;

            ob_start();
            wc_get_template(
                'wishlist/wishlist-pdf.php',
                array( 
                    'wishlist_items' => $wishlist_items 
                ),
                'essential-tool-for-woocommerce/',
                EKWC_TEMPLATE_PATH 
            );
            $html = ob_get_clean(); 

            $options = new Options();
            $options->set('isHtml5ParserEnabled', true); 
            $options->set('isRemoteEnabled', true);

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html); 
            $dompdf->setPaper('A4', 'portrait'); 
            $dompdf->render(); 

            
            $upload_dir = wp_upload_dir(); 
            $file_path  = $upload_dir['path'] . '/wishlist-' . $wishlist_id . '.pdf'; 
            
            file_put_contents($file_path, $dompdf->output()); 
            wp_send_json_success( [ 'url' => $upload_dir['url'] . '/wishlist-' . $wishlist_id . '.pdf' ] );
        }  
    }

    // Initialize the class to handle PDF generation.
    new EKWC_Wishlist_PDF_Handler();

endif;