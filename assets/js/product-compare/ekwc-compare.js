jQuery(function($) {

    class EKWCCompare {

        constructor() {
            this.eventHandlers();
        }

        eventHandlers() {
            $(document.body).on('click', '.ekwc-compare-button', this.handleCompareButtonClick.bind(this));
            $(document.body).on('click', '.ekwc-compare-modal-close', this.closeComparePopup.bind(this));
            $(document.body).on('click', '.ekwc-remove-compare', this.handleRemoveCompareButtonClick.bind(this));
            $(document.body).on('click', '.ekwc-filter-btn', this.CompareFilterProduct.bind(this));
            $(document.body).on('click', '.ekwc-reset-btn', this.ResetFilterProduct.bind(this));
            $(document.body).on('change', '.ekwc-check', this.toggleFilterButton.bind(this));
        }

        handleCompareButtonClick(e) {
            
            var __this =  $(e.currentTarget),
                loader = __this.closest('.ekwc-compare-button-wrapper').find('.ekwc-loader').show();

            console.log(loader);
                
            loader.addClass('show');
                
            $('.ekwc-sticky-compare').hide();

            var productId       =  __this.data('product_id'),
                compareProducts =  this.getCookie('wcpc_compare_products'),
                productIds      =  compareProducts ? JSON.parse(compareProducts) : [];

            if (!productIds.includes(productId)) {
                productIds.push(productId);
            }

            this.setCookie('wcpc_compare_products', JSON.stringify(productIds), 30);
            !__this.hasClass('ekwc-compare-icon') && __this.text('Added to compare');
            this.loadCompareProductData(productIds);
            loader.removeClass('show');
        }

        // Function to get a cookie by name
        getCookie(name) {
            let value = `; ${document.cookie}`;
            let parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
            return '';
        }

        // Function to set a cookie
        setCookie(name, value, days) {
            const expires = new Date();
            expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000)); // Set expiry date to 30 days
            document.cookie = `${name}=${value}; expires=${expires.toUTCString()}; path=/`;
        }

        // Function to load compare product data
        loadCompareProductData(productIds) {
            $.ajax({
                type: 'POST',
                url: ekwc_vars.ajax_url,
                data: {
                    action: 'ekwc_get_compare_products',
                    product_ids: productIds,
                    ekwc_nonce: ekwc_vars.ekwc_nonce
                },
                beforeSend: () => {
                  $('body').addClass('ekwc-loading');
                },
                success: (response) => {
                    if (response.success) {
                        $('.ekwc-compare-modal[data-lightbox="yes"]').fadeIn(300, function() {
                            $('.compare-table-container').html(response.data.html);
                            $('.ekwc-compare-modal').addClass('show');
                            $('body').addClass('overflow-hidden');
                        });
                    } else {
                        console.log('Error loading product data.');
                        $('.ekwc-compare-modal').removeClass('show');
                        $('body').removeClass('overflow-hidden');
                        $('.ekwc-compare-modal').hide();
                    }
                },
                error: (xhr, status, error) => {
                    console.error('AJAX Error:', error);
                },
                complete: () => {
                    $('body').removeClass('ekwc-loading');
                }
            });
        }

        closeComparePopup() {
            $('.ekwc-compare-modal').removeClass('show');
            $('.ekwc-compare-modal').hide();
            $('body').removeClass('overflow-hidden');
        }


        // Remove data from the cookie
        handleRemoveCompareButtonClick(e) {
            const productId = $(e.currentTarget).data('product_id'); 
            let compareProducts = this.getCookie('wcpc_compare_products');
            // change button text when we remove
            if ( !$('.ekwc-compare-button[data-product_id=' + productId + ']' ).hasClass( 'ekwc-compare-icon' ) ) {
                $( '.ekwc-compare-button[data-product_id=' + productId + ']' ).text( 'Compare'  );
            }
            let productIds = compareProducts ? JSON.parse(compareProducts) : [];
            productIds = productIds.filter(id => id !== productId);
            this.setCookie('wcpc_compare_products', JSON.stringify(productIds), 30); // Expire in 30 days
            this.loadCompareProductData(productIds);
        }
        
        CompareFilterProduct(e) {
            var container = jQuery(e.currentTarget).closest(".ekwc-compare-container");
            container.find(".ekwc-vertical-table thead th, .ekwc-vertical-table tbody td").not(":first-child").hide();
            container.find(".ekwc-check").each(function () {
                var columnIndex = jQuery(this).closest("th").index(); 
                if (jQuery(this).is(":checked")) {
                    container.find(".ekwc-vertical-table thead th:nth-child(" + (columnIndex + 1) + "), .ekwc-vertical-table tbody td:nth-child(" + (columnIndex + 1) + ")").show();
                }
            });
        }

        ResetFilterProduct(e){
            var $container = jQuery(e.currentTarget).closest(".ekwc-compare-container");
            $container.find(".ekwc-comparison-table thead th, .ekwc-comparison-table tbody td").show();        
            $container.find(".ekwc-check").prop("checked", false);
            this.toggleFilterButton(e);
        }

        toggleFilterButton(e) {
            var container = $(e.currentTarget).closest(".ekwc-compare-container");
            var anyChecked = container.find(".ekwc-check:checked").length > 1;
            container.find(".ekwc-filter-btn").prop("disabled", !anyChecked);
        }

    }

    new EKWCCompare();

});