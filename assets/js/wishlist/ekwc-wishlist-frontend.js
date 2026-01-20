jQuery(function ($) {

    class EKWCWishlistFrontend {

        constructor() {
            this.eventHandlers();
        }

        eventHandlers() {
            $(document.body).on('click', '.ekwc-wishlist-button', this.wishlistProductHandler.bind(this));
            $(document.body).on('click', '.ekwc-remove-wishlist', this.removeWishlistProductHandler.bind(this));
            $(document.body).on('click', '.ekwc-add-to-cart.ajax_add_to_cart', this.addToCartHandler.bind(this));
            $(document.body).on('click', '.ekwc-delete-wishlist', this.deleteWishlistHandler.bind(this));
            $(document.body).on('click', '.ekwc-wishlist-icon.view_wishlist', this.view_wishlist.bind(this));
        }

        // Handles adding a product to the wishlist
        wishlistProductHandler(e) {
            e.preventDefault();
            var __this          = $(e.currentTarget),
                productId       = __this.data('product-id'),
                parentContainer = __this.closest('.ekwc-wishlist-container'),
                wishlistIcon    = $(".ekwc-wishlist-icon.ekwc-wishlist-button[data-product-id='" + productId + "']");

            if (!productId) {
                console.log('Product ID missing');
                return;
            }
            
            // Send AJAX request to add product to the wishlist
            $.ajax({
                type: 'POST',
                url: ekwc_wishlist_vars.ajax_url,
                data: {
                    action: 'ekwc_add_to_wishlist',
                    product_id: productId,
                    nonce: ekwc_wishlist_vars.wishlist_nonce,
                },
                beforeSend: () => {
                    __this.prop('disabled', true).addClass('ekwc-loading');
                },
                success: (response) => {
                    if (response.success) {
                        if (!ekwc_wishlist_vars.is_user_logged_in) {
                            let guestWishlist = localStorage.getItem( 'ekwc_wishlist' ) 
                                ? JSON.parse( localStorage.getItem( 'ekwc_wishlist' ) ) 
                                : [];
                            
                            if (!guestWishlist.includes( productId )) {
                                guestWishlist.push( productId );
                                localStorage.setItem( 'ekwc_wishlist', JSON.stringify( guestWishlist ) );
                            }
                        }

                        if ( wishlistIcon.length ) {
                            var img = wishlistIcon.find('.ekwc-loop-img');
                            if (img.length) {
                                img.attr( 'src', ekwc_wishlist_vars.wishlist_setting.added_to_wishlist_icon );
                                
                                if( ekwc_wishlist_vars.wishlist_setting.after_add_to_wishlist_action == 'remove_from_list' ){
                                    wishlistIcon.removeClass('ekwc-wishlist-button').addClass('ekwc-remove-wishlist');
                                }
                                
                                if( ekwc_wishlist_vars.wishlist_setting.after_add_to_wishlist_action == 'view_wishlist_link' ){
                                    wishlistIcon.removeClass('ekwc-wishlist-button').addClass('view_wishlist');
                                }
                            }
                        }
                        
                        parentContainer.find('.ekwc-add-button').hide();
                        parentContainer.find('.ekwc-wishlist-actions').show();

                    } else {
                        console.log('Wishlist error:', response.data.message);
                    }
                },
                error: (xhr, status, error) => {
                    console.log('AJAX Error:', error);
                },
                complete: () => {
                    __this.prop('disabled', false).removeClass('ekwc-loading');
                },
            });
        }

        removeWishlistProductHandler(e){
            e.preventDefault();
            var __this          = $(e.currentTarget),
                productId       = __this.data('product-id'),
                wishlist_token  = __this.data('wishlist-token'),
                parentContainer = __this.closest('.ekwc-wishlist-actions').length ? __this.closest('.ekwc-wishlist-actions').parent() : __this.parent(),
                wishlistIcon    = $(".ekwc-wishlist-icon.ekwc-remove-wishlist[data-product-id='" + productId + "']");
        
            $.ajax({
                type: 'POST',
                url: ekwc_wishlist_vars.ajax_url,
                data: {
                    action: 'ekwc_remove_from_wishlist',
                    product_id: productId,
                    wishlist_token: wishlist_token,
                    nonce: ekwc_wishlist_vars.wishlist_nonce,
                },
                beforeSend: () => {
                    __this.prop('disabled', true).addClass('ekwc-loading');
                },
                success: function (response) {
                    if (response.success) {
                        __this.closest('tr.ekwc-wishlist-row').remove();
                        if(parentContainer){
                            parentContainer.find('.ekwc-add-button').show();
                            parentContainer.find('.ekwc-wishlist-actions').hide();
                        }
                        if(wishlistIcon.length){
                            var img = wishlistIcon.find('.ekwc-loop-img');
                            if (img.length) {
                                img.attr( 'src', ekwc_wishlist_vars.wishlist_setting.add_to_wishlist_icon );
                            }
                            wishlistIcon.removeClass( 'ekwc-remove-wishlist' ).addClass( 'ekwc-wishlist-button' );
                        }
                    } else {
                        console.log('Wishlist error:', response.data.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.log('AJAX Error:', error);
                },
                complete: () => {
                    __this.prop('disabled', false).removeClass('ekwc-loading');
                },
            });
        }

        addToCartHandler(e) {
            e.preventDefault();

            var __this      =  $(e.currentTarget),
                productId   = __this.data('product_id');
    
            if (!productId) return;
    
            $.ajax({
                type: 'POST',
                url: wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart'),
                data: { product_id: productId, quantity: 1 },
                beforeSend: () => {
                    __this.addClass('ekwc-loading');
                },
                success: (response) => {
                    if ( ekwc_wishlist_vars.wishlist_setting.ekwc_remove_on_add_to_cart == 'yes' ) {
                        $.ajax({
                            type: 'POST',
                            url: ekwc_wishlist_vars.ajax_url,
                            data: {
                                action: 'ekwc_remove_from_wishlist',
                                product_id: productId,
                                nonce: ekwc_wishlist_vars.wishlist_nonce,
                            },
                            success: function (response) {
                                if (response.success) {
                                    __this.closest('tr.ekwc-wishlist-row').remove();
                                    if ( ekwc_wishlist_vars.wishlist_setting.ekwc_redirect_to_cart == 'yes' ) {
                                        window.location.href = wc_add_to_cart_params.cart_url; 
                                    }    
                                } else {
                                    console.log('something went wrong');
                                }
                            }
                        });
                    }else{
                        if ( ekwc_wishlist_vars.wishlist_setting.ekwc_redirect_to_cart == 'yes' ) {
                            window.location.href = wc_add_to_cart_params.cart_url; 
                        } 
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

        deleteWishlistHandler(e) {
            e.preventDefault();

            var __this      = $(e.currentTarget),
                wishlistId  = __this.data('wishlist-id'),
                wishlistRow = __this.closest('tr.ekwc-wishlist-row');

            if (!wishlistId) return;

            if (confirm('Are you sure you want to delete this wishlist?')) {
                $.ajax({
                    url: ekwc_wishlist_vars.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'ekwc_delete_wishlist',
                        wishlist_id: wishlistId,
                        nonce: ekwc_wishlist_vars.wishlist_nonce,
                    },
                    beforeSend: function () {
                        wishlistRow.css('opacity', '0.5');
                    },
                    success: function (response) {
                        if (response.success) {
                            wishlistRow.remove();
                        } else {
                            console.log('Error: ' + response.data);
                            wishlistRow.css('opacity', '1');
                        }
                    },
                    error: function () {
                        console.log('An error occurred. Please try again.');
                        wishlistRow.css('opacity', '1');
                    },
                });
            }
        }

        view_wishlist(e) {
            e.preventDefault();
            const __this = $(e.currentTarget);
        
            $.ajax({
                url: ekwc_wishlist_vars.ajax_url,
                method: 'POST',
                data: {
                    action: 'get_wishlist_page_url',  
                    nonce: ekwc_wishlist_vars.wishlist_nonce,
                },
                beforeSend: () => {
                    __this.addClass('ekwc-loading');
                },
                success: function(response) {
                    if (response.success) {
                        window.location.href = response.data.url;
                    }
                },
                error: function() {
                    console.log('There was an error processing your request');
                },
                complete: () => {
                    __this.removeClass('ekwc-loading');
                }
            });
        }

    }

    new EKWCWishlistFrontend();
    
});