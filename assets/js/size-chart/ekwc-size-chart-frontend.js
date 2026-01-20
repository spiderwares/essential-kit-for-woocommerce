jQuery(function ($) {

    class EKWCSizeChartFrontend {

        constructor() {
            this.eventHandlers();
        }

        eventHandlers() {
            $(document.body).on('click', '.ekwc-size-charts-list-item', this.loadSizeChartContentHandler.bind(this)); 
        }

        loadSizeChartContentHandler(e) {
            e.preventDefault();
            var __this    = $(e.currentTarget),
                chartId   = __this.data('id');

            $.ajax({
                url: ekwc_size_chart_vars.ajax_url,
                type: 'POST',
                data: {
                    action: 'ekwc_get_size_chart_content',
                    chart_id: chartId,
                    nonce: ekwc_size_chart_vars.nonce,
                },
                beforeSend: () => {
                    __this.addClass('ekwc-loading');
                },
                success: function(response) {
                    if (response.success && response.data.html) {

                        if(ekwc_size_chart_vars.setting.popup_library == 'featherlight'){
                            $.featherlight(response.data.html, {
                                persist: true,
                                closeOnClick: 'background',
                                closeIcon: '&#x2715;', // Optional
                                variant: 'ekwc-size-chart-popup'
                            });
                        }

                        if(ekwc_size_chart_vars.setting.popup_library == 'magnific'){
                            const effectClass = ekwc_size_chart_vars.setting.effect || 'mfp-fade';
                            console.log(effectClass);
                            $.magnificPopup.open({
                                items: {
                                    src: '<div class="ekwc-size-chart-popup ' + effectClass + '">' + response.data.html + '</div>',
                                    type: 'inline'
                                },
                                closeBtnInside: true,
                                removalDelay: 300,
                                mainClass: effectClass 
                            });
                        }

                    } else {
                        console.log('Error loading size chart:', response.data?.message || 'Unknown error');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX Error:', error);
                },
                complete: () => {
                    __this.removeClass('ekwc-loading');
                }
            });
        }

    }

    new EKWCSizeChartFrontend();

});