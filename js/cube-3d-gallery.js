class WidgetHandlerClassTilted3D extends elementorModules.frontend.handlers.Base {
    getDefaultSettings() {
        return {
            selectors: {

            },
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings( 'selectors' );
        return {

        };
    }

    bindEvents() {

    }

    onDelayTimeChange(  ) {

    }
}

jQuery( window ).on( 'elementor/frontend/init', () => {
    const addHandler = ( $element ) => {
        elementorFrontend.elementsHandler.addHandler( WidgetHandlerClassTilted3D, {
            $element,
        } );

        (function ($) {


            $(document).ready(function () {
                /** Code By Webdevtrick ( https://webdevtrick.com ) **/
                var $carousel = $('.carousel'),
                    currentSlide, nextSlide;

                $('.next').click(function() {
                    currentSlide = $carousel.attr('data-slide');
                    nextSlide = +currentSlide === 4 ? 1 : +currentSlide + 1;
                    $carousel.attr('data-slide', nextSlide);
                });

                $('.prev').click(function() {
                    currentSlide = $carousel.attr('data-slide');
                    nextSlide = +currentSlide === 1 ? 4 : +currentSlide - 1;
                    $carousel.attr('data-slide', nextSlide);
                });
            });
        })
        (jQuery);






    };

    elementorFrontend.hooks.addAction( 'frontend/element_ready/tilted-3d-gallery.default', addHandler );





} );

