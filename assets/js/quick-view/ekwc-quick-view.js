jQuery(function ($) {

    class EkWCQuickView {

        constructor() {
            this.eventHandlers();
        }

        eventHandlers() {
            $(document.body).on('click', '.ekwc-quick-view', this.openQuickView.bind(this));
            $(document.body).on('click', '.ekwc-quick-view-close', this.closeQuickView.bind(this));
            $(document.body).on('click', '.ekwc_add_to_cart', this.addToCartHandler.bind(this));
        }

        openQuickView(e) {
            e.preventDefault();

            let __this      = $(e.currentTarget),
                productId   = __this.data('product_id');

            if (!productId) {
                console.log('Product ID is missing.');
                return;
            }

            $.ajax({
                type: 'POST',
                url: ekwc_wishlist_vars.ajax_url, // Ensure `ekwc_wishlist_vars` is localized in PHP
                data: {
                    action: 'ekwc_load_quick_view',
                    product_id: productId,
                    ekwc_nonce: ekwc_vars.ekwc_nonce, 
                },
                beforeSend: () => {
                    __this.addClass('ekwc-loading');
                },
                success: (response) => {
                    if (response.success) {
                        $('.ekwc-model .ekwc-model-content').html(response.data.html);
                        $('.ekwc-model').fadeIn().addClass( 'open' );
                        let slides = $('.ekwc-slider .ekwc-slide');
                        if (slides.length > 1) {
                            $('.ekwc-slider').slick();
                        }
                    } else {
                        console.log('Quick View error:', response.data.message);
                    }
                },
                error: () => {
                    console.log('Error loading Quick View.');
                },
                complete: () => {
                    __this.removeClass('ekwc-loading');
                }
            });
        }

        closeQuickView(e){
            $('.ekwc-model').fadeOut().removeClass( 'open' );
        }

        addToCartHandler(e) {
            e.preventDefault();

            var __this      =  $(e.currentTarget),
                productId   = __this.data('product_id');
    
            if (!productId) return;
    
            $.ajax({
                type: 'POST',
                url: wc_add_to_cart_params.wc_ajax_url.toString().replace("%%endpoint%%", "add_to_cart"),
                data: { product_id: productId, quantity: 1 },
                beforeSend: () => {
                    __this.addClass('ekwc-loading');
                },
                success: (response) => {
                    if ( ekwc_wishlist_vars.quick_view_setting.close_popup_after_add_to_cart == 'yes' ) {
                        this.closeQuickView();
                    }
                    if ( ekwc_wishlist_vars.quick_view_setting.redirect_to_checkout_after_add_to_cart == 'yes' ) {
                        window.location.href = ekwc_wishlist_vars.checkout_url; 
                    }
                },
                error: (xhr, status, error) => {
                    console.log('Error adding to cart.');
                },
                complete: () => {
                    __this.removeClass('ekwc-loading');
                }
            });
        }

    }

    new EkWCQuickView();

});